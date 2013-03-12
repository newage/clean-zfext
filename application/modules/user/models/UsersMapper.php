<?php

/**
 * User_Model_UsersTable
 *
 * @category Application
 * @package Application_User_Models
 * @subpackage Mapper
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
     * @return User_Model_Users
     */
    public function save(Core_Model_Abstract $model)
    {
        $imageModel = new Application_Model_Images();
        $imageModel->setSizeWidth(Application_Model_Images::SIZE_MEDIUM_WIDTH);
        $imageModel->setSizeHeight(Application_Model_Images::SIZE_MEDIUM_HEIGHT);

        $imageMapper = new Application_Model_ImagesMapper();
        $imageModel = $imageMapper->setModel($imageModel)->resize()->upload();

        $table = $this->getDbTable();
        return $table->insert($model->toArray());
    }

    /**
     * Update user data
     * @param array $request
     * @return array
     */
    public function update(array $request)
    {
        $user = $this->getDbTable()->getById($request['id']);

        $user->login = $request['login'];
        $user->email = $request['email'];
        $user->password = $request['password'];

        $user->save();
        return $user->getLastModified();
    }

    /**
     * Disable user account
     * @param array $request
     * @return array
     */
    public function disable(array $request)
    {
        $user = $this->getDbTable()->getById($request['id']);

        $user->status = User_Model_Users::STATUS_BLOCKED;

        $user->save();
        return $user->getLastModified();
    }

    /**
     * Enable user account
     * @param array $request
     * @return array
     */
    public function enable(array $request)
    {
        $user = self::getInstance()->findOneById($request['id']);

        $user->status = User_Model_Users::STATUS_ACTIVE;

        $user->save();
        return $user->getLastModified();
    }

    /**
     * Registration new user
     *
     * @param array $request
     * @return bool
     */
    public function register($request)
    {
        $user = $this->getDbTable()->createRow();

        $user->login = $request['login'];
        $user->email = $request['email'];
        $user->password = $request['password'];
        $user->role = 'user';
        $user->status = User_Model_Users::STATUS_ACTIVE;

        $user->save();
        return $user->getLastModified();
    }

    /**
     * Create and send email with link to restore password
     * @param array $request
     * @return bool
     */
    public function forgotPassword($request)
    {
        $hash = md5(date('Y-m-d H:i:s'));

        $user = Doctrine_Query::create()
            ->update('User_Model_Users')
            ->set('hash', '?', $hash)
            ->where('email = ?', $request['email']);
        $user->execute();

        $link = 'http://' . $_SERVER['SERVER_NAME'] . '/user/forgot/restore/en/hash/' . $hash;

        $mail = new Zend_Mail();
        $mail->setBodyText('For restoration password, please click here ' . $link . ' and enter a new password');
        $mail->setFrom('somebody@example.com', 'Some Sender');
        $mail->addTo($request['email'], 'Some Recipient');
        $mail->setSubject('Restory password');
        $mail->send();
    }

    /**
     * Update password
     * @param array $request
     * @return bool
     */
    public function updatePassword($request)
    {
        $user = self::getInstance()->findOneBy('email', $request['email']);
        $user->set('password', '?', $request['password']);
        $user->set('hash', '?', '');
        $user->save();

        return true;
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