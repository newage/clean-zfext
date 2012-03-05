<?php

/**
 * Description of AuthentiacationControllerTest
 *
 * @author vadim
 */
class AuthentiacationControllerTest extends ControllerTestCase
{
    public function testTrueUserLoginAction()
    {
        //Set emulate form
        $this->getRequest()
             ->setMethod('POST')
             ->setPost(array(
                 'realm' => 'user',
                 'username' => 'user',
                 'password' => '123456'
             ));

        //Login dispatch
        $this->dispatch('/user/authentication/login');
        //Set login params
        $this->_doLogin(__DIR__ . DIRECTORY_SEPARATOR . 'loginFixtures.txt');
        //Get identity
        $this->assertEquals(Zend_Auth::getInstance()->getIdentity(), 'user');
    }

    public function testFalseUserLoginAction()
    {
        //Set emulate form
        $this->getRequest()
             ->setMethod('POST')
             ->setPost(array(
                 'realm' => 'user',
                 'username' => 'user',
                 'password' => '124456'
             ));

        //Login dispatch
        $this->dispatch('/user/authentication/login');

        //Set login params
        $this->_doLogin(__DIR__ . DIRECTORY_SEPARATOR . 'loginFixtures.txt');

        //Get identity
        $this->assertNull(Zend_Auth::getInstance()->getIdentity());
    }

    /**
     * Logined use auth adapter
     * @param string $realm
     * @param string $login
     * @param string $password
     */
    protected function _doLogin($file)
    {
        $realm    = $this->getRequest()->getParam('realm');
        $login    = $this->getRequest()->getParam('username');
        $password = $this->getRequest()->getParam('password');

        $authAdapter = new Zend_Auth_Adapter_Digest($file, $realm, $login, $password);

        $result = $authAdapter->authenticate();

        if ($result->isValid()) {
            Zend_Auth::getInstance()
                ->setStorage(new Zend_Auth_Storage_Session('Zend_Auth'))
                ->getStorage()
                ->write($authAdapter->getRealm());
        }
    }

}

