<?php

/**
 * Access plugin
 * Access logined user
 * Read roles from base
 *
 * @category Core
 * @package Core_Controller
 * @subpackage Plugin
 * @author V.Leontiev
 *
 * @version  $Id$
 */
class Core_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{

    /**
     * Plugin configuration settings array
     *
     * @var array
     */
    protected $_options = array();

    /**
     * Denied page settings
     *
     * @var array
     */
    protected $_deniedPage = array(
        'module'     => 'default',
        'controller' => 'error',
        'action'     => 'denied'
    );

    /**
     * Redirect to nofound page
     * @var array
     */
    protected $_errorPage = array(
        'module'     => 'default',
        'controller' => 'error',
        'action'     => 'nofound'
    );
    
    /**
     * Login page
     * @var array
     */
    protected $_loginPage = array(
        'module'     => 'parent',
        'controller' => 'registration',
        'action'     => 'index'  
    );
    
    /**
     * Url to redirect when user unlogined
     *
     * @var string
     */
    protected $_unLogined = '/';

    /**
     * default role name
     *
     * @var string
     */
    protected $_roleName = 'guest';

    /**
     * ACL object
     *
     * @var Zend_Acl
     */
    protected $_acl;

    /**
     * Zend_Cache
     *
     * @var object
     */
    protected $_cache = null;

    /**
     * Resources collection
     * @var array
     */
    protected $_resources = array();
    
    /**
     *
     * @param array $options 
     */
    public function  __construct(Array $options = array())
    {
        if (isset($options['denied'])) {
            $this->_deniedPage = array_merge($this->_deniedPage, $options['denied']);
        }
        
        if (isset($options['login'])) {
            $this->_loginPage = array_merge($this->_loginPage, $options['login']);
        }
        
        if (isset($options['error'])) {
            $this->_errorPage = array_merge($this->_errorPage, $options['error']);
        }

        if (isset($options['role'])) {
            $this->_roleName = $options['role'];
        }

        if (isset($options['unlogined'])) {
        	$this->_unLogined = $options['unlogined'];
        }

        $this->_options = $options;
    }

    /**
     * Sets the ACL object
     *
     * @param  Zend_Acl $acl
     * @return void
     **/
    public function setAcl(Zend_Acl $acl)
    {
        $this->_acl = $acl;
    }

    /**
     * Returns the ACL object
     *
     * @return Zend_Acl
     **/
    public function getAcl()
    {
        $this->loadCache();

        if (null == $this->_acl) {
            $config = $this->_getConfig();
            $this->setAcl(new Core_Acl($config));
            $this->saveCache();
        }
        
        Zend_Registry::set('Zend_Acl', $this->_acl);

        return $this->_acl;
    }

    /**
     * Load Zend_Acl from cache
     *
     * @return void
     */
    public function loadCache()
    {
        if (($cache = $this->getCache()) !== false && $this->getCache()->test('Zend_Acl')) {
            $this->_acl = $cache->load('Zend_Acl');
        }
        return;
    }

    /**
     * Save Zend_Acl to cache
     *
     * @return void
     */
    public function saveCache()
    {
        if(($cache = $this->getCache()) !== false) {
            $cache->save($this->_acl, 'Zend_Acl');
        }
        return;
    }

    /**
     * Get cache from ACL
     *
     * @return Zend_Cache_Core|false
     */
    public function getCache()
    {
        if (Zend_Registry::get('Zend_Cache_Manager')->hasCache('acl')) {
            $cache = Zend_Registry::get('Zend_Cache_Manager')->getCache('acl');
            return $cache;
        }
        return false;
    }

    /**
     * Sets the ACL role to use
     *
     * @param string $roleName
     * @return void
     */
    public function setRoleName($roleName)
    {
        $this->_roleName = $roleName;
    }

    /**
     * Returns the ACL role used
     *
     * @return string
     */
    public function getRoleName()
    {
        $identity = Zend_Auth::getInstance()->getIdentity();

        if ($identity) {
            if (!$identity->role) {
                throw new Zend_Auth_Exception('Dont set role name');
            } else {
                $this->_roleName = $identity->role;
            }
        }

        return $this->_roleName;
    }

    /**
     * Verify resource access from users
     * Add ACL to Zend_Registry
     *
     * @param  Zend_Controller_Request_Abstract $request
     * @return bool
     * @throws Login_Exception Error resource
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $acl = $this->getAcl();
        $resource = $request->getModuleName() . '/' . $request->getControllerName();

        /** Check resource */
        if (!$acl->has($resource)) {
            if (Zend_Controller_Front::getInstance()->getParam('env') == 'development') {
                $this->getResponse()->appendBody('<h2>Resource "'.$resource.'" not found in ACL rules</h2>');
                return true;
            } else {
                $this->_toError();
                return false;
            }
        }

        if ($acl->isAllowed($this->getRoleName(), $resource, $request->getActionName()) === true) {
            return true;
        } else {
            /** Redirect to access denied page or login */
            if (Zend_Auth::getInstance()->hasIdentity()) {
                $this->_denyAccess();
            } else {
                /** Save request to session */
                $session = new Zend_Session_Namespace('Core_Request');
                $session->params = $this->_request->getParams();
            
                $this->_toLogin();
            }
        }
    }
    
    /**
     * Set to error page
     * 
     * @return void
     */
    protected function _toError()
    {
        $this->_setDispatched($this->_errorPage);
    }
    
    /**
     * Deny Access Function
     * Redirects to errorPage,
     * this can be called from an action using the action helper
     *
     * @return void
     */
    protected function _denyAccess()
    {
        $this->_setDispatched($this->_deniedPage);
    }

    /**
     * Allow Access function
     * 
     */
    protected function _toLogin()
    {
        $this->_setDispatched($this->_loginPage);
    }

    /**
     * Set new dispatched
     * 
     * @param array $params Dispatcher params
     * @param type $dispatched
     */
    protected function _setDispatched(Array $params, $dispatched = false)
    {
        $this->_request->setModuleName($params['module']);
        $this->_request->setControllerName($params['controller']);
        $this->_request->setActionName($params['action']);
        $this->_request->setDispatched($dispatched);
    }
    
    /**
     * Create config rules array
     * @return array
     */
    protected function _getConfig()
    {
        $options = array(
            'config'=>'acl',
            'section'=>'production'
        );

        $moduleConfig = new Core_Module_Config_Xml($options);
        $config = $moduleConfig->readConfigs()->toArray();

        return $config;
    }
}