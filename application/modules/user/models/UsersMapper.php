<?php

/**
 * Mepper for user model
 *
 * @category Application
 * @package    Application_Modules_User
 * @subpackage Model_Mapper
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://bitbucket.org/newage/clean-zfext
 * @since php 5.1 or higher
 */
class User_Model_UsersMapper extends Core_Model_Mapper_Abstract
{
    /**
     * Return bool if find registerd user on fields email and password
     *
     * @param string $login
     * @param string $password
     * @return bool
     */
    public function authenticate($email, $password, $remember = false)
    {
        $authAdapter = new Core_Auth_Adapter_DbTable();
        $authAdapter->setTableName('users')
                    ->setIdentityColumn('email')
                    ->setCredentialColumn('password')
                    ->setCredentialTreatment('MD5(CONCAT(salt, ?)) AND status = "' .
                        User_Model_Users::STATUS_ENABLE . '"');

        $authAdapter->setIdentity($email)
                    ->setCredential($password);

        $auth = Zend_Auth::getInstance();
        $auth->setStorage(new Zend_Auth_Storage_Session('Zend_Auth'));
        $result = $authAdapter->authenticate($authAdapter);

        if ($result->isValid() === true) {
            $data = $authAdapter->getResultRowObject(null, array('password','salt','password_reset_hash'));
            $auth->getStorage()->write($data);

            if ($remember === true) {
                Zend_Session::rememberMe(60*60*24*14);
            }

            return true;
        }
        return false;
    }

    /**
     * Save new user and upload avatar
     *
     * @return mixed
     */
    public function save(Core_Model_Abstract $model)
    {
        $table = $this->getDbTable();
        $result = $table->insert($model->toArray());

        $identity = Zend_Auth::getInstance()->getIdentity();
        $cacheId = md5('User_' . $identity->id);
        $this->getCache()->remove($cacheId);

        return $result;
    }

    /**
     * Update user password
     *
     * @param User_Model_Users $request
     * @return mixed
     */
    public function changePassword(User_Model_Users $request)
    {
        $user = $this->getDbTable()->getById($this->_getCurrentUserId());

        $user->password = $request->getPassword();
        $user->salt = $request->getSalt();

        return $user->save();
    }

    /**
     * Disable user account
     *
     * @param User_Model_Users $request
     * @return mixed
     */
    public function disable(User_Model_Users $request)
    {
        $user = $this->getDbTable()->getById($this->_getCurrentUserId());

        $user->status = User_Model_Users::STATUS_DISABLE;

        return $user->save();
    }

    /**
     * Enable user account
     *
     * @param User_Model_Users $request
     * @return mixed
     */
    public function enable(User_Model_Users $request)
    {
        $user = $this->getDbTable()->findOneById($this->_getCurrentUserId());

        $user->status = User_Model_Users::STATUS_ENABLE;

        return $user->save();
    }

    /**
     * Get user
     *
     * @param int $id
     * @return User_Model_Users
     */
    public function getUser($id = 0)
    {
        if ($id == 0) {
            $id = $this->_getCurrentUserId();
        }

        $user = $this->getDbTable()->getById($id);
        return $user;
    }

    /**
     * Create and send email with link to restore password
     * @param array $request
     * @return bool
     */
    public function forgotPassword($request)
    {
        $hash = md5(date('Y-m-d H:i:s'));

        $user = $this->getDbTable()->getByEmail($request['email']);

        $user->passwordResetHash = $hash;
        $user->save();

        $link = 'http://' . $_SERVER['SERVER_NAME'] . '/user/forgot/restore/hash/' . $hash;

        $mail = new Zend_Mail();
        $mail->setBodyText('For restoration password, please click here ' . $link . ' and enter a new password');
        $mail->setFrom('somebody@example.com', 'Some Sender');
        $mail->addTo($request['email'], 'Some Recipient');
        $mail->setSubject('Restory password');
        $mail->send();

        return true;
    }

    /**
     * Update password
     * @param array $request
     * @return bool
     */
    public function updatePassword($request)
    {
        $user = $this->getDbTable()->getByPassword_reset_hash($request['hash']);

        $user->setPassword($request['password']);
        $user->setPasswordResetHash('');
        $user->save();

        return true;
    }

    /**
     * Get user profile
     *
     * @return User_Model_Users
     */
    public function getCurrentUser()
    {
        $identity = Zend_Auth::getInstance()->getIdentity();

        $cacheId = md5('users_' . $identity->id);
        if (!($user = $this->loadCache($cacheId))) {
            $user = $this->getDbTable()->getById($identity->id);

            if ($user === null) {
                //go to error page for don't find user
            }

            $profile = $user->findDependentRowset('User_Model_DbTable_Profile')->current();
            $image = $profile->findParentRow('Application_Model_DbTable_Images');

            $user->setProfile($profile)->setAvatar($image);
            $this->saveCache($user, $cacheId);
        }

        return $user;
    }

    public function getPaginator()
    {
        $adapter = new Zend_Paginator_Adapter_DbSelect($this->getDbTable()->select()->from('users'));
        $adapter->setRowCount(
            $this->getDbTable()->select()->from(
                'users',
                array(
                   Zend_Paginator_Adapter_DbSelect::ROW_COUNT_COLUMN => 'id'
                )
            )
        );

        return $adapter;
    }
}
