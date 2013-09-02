<?php

/**
 * Mepper for user model
 *
 * @category Application
 * @package    Application_Model
 * @subpackage Mapper
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://github.com/newage/clean-zfext
 * @since php 5.1 or higher
 */
class Application_Model_Mapper_User extends Core_Model_Mapper_Abstract
{

    protected $_prefixCache = 'user';
    
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
                        Application_Model_User::STATUS_ENABLE . '"');

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
     * Save new user
     *
     * @param array $formValues
     * @return int
     */
    public function save($formValues)
    {
        //Save user
        $modelUser = new Application_Model_User($formValues);
        $modelUser->setRoleId(2);
        
        $insertUserId = parent::save($modelUser);
        
        parent::_cleanCache(
            Zend_Cache::CLEANING_MODE_MATCHING_ANY_TAG,
            array('users')
        );

        return $insertUserId;
    }

    /**
     * Update user password
     *
     * @param Array $formValues
     * @return mixed
     */
    public function changePassword($formValues)
    {
        $user = $this->getDbTable()->getById($this->_getCurrentUserId());

        $user->setPassword($formValues['password']);

        return $user->save();
    }

    /**
     * Change status for user
     *
     * @param int $id User id
     * @return Application_Model_User
     */
    public function changeStatus($id)
    {
        $user = $this->getDbTable()->getById((int)$id);

        switch ($user->getStatus()) {
            case Application_Model_User::STATUS_ENABLE:
                $user->status = Application_Model_User::STATUS_DISABLE;
                break;
            case Application_Model_User::STATUS_DISABLE:
                $user->status = Application_Model_User::STATUS_ENABLE;
                break;
        }

        $user->save();

        $cacheId = $this->_getCacheId($id);
        $this->_removeCache($cacheId);

        return $user;
    }

    /**
     * Get user
     *
     * @param int $id
     * @return Application_Model_User
     */
    public function find($id)
    {
        $cacheId = $this->_getCacheId($id);

        if (!($user = $this->_loadCache($cacheId))) {
            $user = $this->getDbTable()->getById($id);

            if ($user === null) {
                return null;
            }

            if ($user->getUserDetailsId() > 0) {
                $profile = $user->findDependentRowset('Application_Model_DbTable_Profile');
                $user->setProfileModel($profile);

                $image = $profile->findDependentRowset('Application_Model_DbTable_Image');
                $profile->setImagesModel($image);
                
                $this->_saveCache($user, $cacheId, array('users', 'users_details'));
            }
        }

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

        $user = $this->find($identity->id);
        
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
