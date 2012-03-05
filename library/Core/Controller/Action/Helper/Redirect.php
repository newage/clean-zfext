<?php

/**
 * Redirect to url use multilingual route
 *
 * @category Core
 * @package Core_Controller
 * @subpackage Action_Helper
 * @author V.Leontiev
 * 
 * @version $Id$
 */
class Core_Controller_Action_Helper_Redirect extends Zend_Controller_Action_Helper_Redirector
{
    
    /**
     * Goto url use multilingual route
     * 
     * @param string $url [optional]
     */
    public function gotoUrl($url = '/')
    {
        $params = explode('/', $url);
        
        if (empty($params[0])) {
            unset($params[0]);
        }
        
        $module = array_shift($params);
        if (empty($module)) {
            $module = $this->getFrontController()->getDefaultModule();
        }
        
        $controller = array_shift($params);
        if (empty($controller)) {
            $controller = $this->getFrontController()->getDefaultControllerName();
        }
        
        $action = array_shift($params);
        if (empty($action)) {
            $action = $this->getFrontController()->getDefaultAction();
        }
        
        if (!empty($params)) {
            $newArray = array();
            for ($i = 0; $i < count($params); $i += 2) {
                $newArray[$params[$i]] = $params[$i+1];
            }
            $params = $newArray;
        }
        
        $routeParams = array_merge(array(
            'action' => $action,
            'controller' => $controller,
            'module' => $module), $params);
        
        
        parent::gotoRoute($routeParams, 'multilingual');
    }
    
    /**
     * Redirect use multilingual route
     * 
     * @see parent::gotoRoute
     */
    public function gotoRoute(array $urlOptions = array(), $name = null, $reset = false, $encode = true)
    {
        parent::gotoRoute($urlOptions, 'multilingual');
    }
}

