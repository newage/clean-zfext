<?php

/**
 * User_Model_UsersTable
 * 
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
     * Update user data
     * @param array $request
     * @return array
     */
    public function update(array $request)
    {
        $user = self::getInstance()->findOneById($request['id']);

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
        $instance = self::getInstance()->findOneById($request['id']);

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
        $instance = self::getInstance()->findOneById($request['id']);

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
        $user = self::getDbTable()->createRow();

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
}