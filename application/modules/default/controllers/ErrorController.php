<?php
/**
 * Default error controller
 *
 * @category   Application
 * @package    Application_Default
 * @subpackage Controller
 *
 * @version  $Id: ErrorController.php 87 2010-08-29 10:15:50Z vadim.leontiev $
 */

class ErrorController extends Zend_Controller_Action
{

    /**
     * Default error action
     * Request 404 error and logged other errors
     *
     * @return void;
     */
    public function errorAction()
    {
        $this->view->headTitle('Error');
        
        $errors = $this->_getParam('error_handler');
        
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                $this->getResponse()->setRawHeader('HTTP/1.1 404 Not Found');
                $this->view->exception = 'Page not found!';
                break;
            default:
                
                if (APPLICATION_ENV != 'production') {
                    $message = $errors->exception->getMessage() . ' - ' .
                               $errors->exception->getFile() . ' [' . $errors->exception->getLine() . ']';

//                    Zend_Registry::get('Zend_Log')->crit($message);
                }
                
                $this->view->exception = 'Fatall error. Please try again!';
                break;
        }
    }

    public function deniedmvcAction()
    {
        $this->view->headTitle('Access denied');

        $session = new Zend_Session_Namespace('Zend_Request');

        if (!empty($session->params) && Zend_Auth::getInstance()->hasIdentity()) {
            $this->view->deny = $session->params['module'] . '/' .
                    $session->params['controller'] . '/' .
                    $session->params['action'];
            $session->params = null;
        } else {
            $this->view->deny = $this->getRequest()->getParam('module') . '/' .
                    $this->getRequest()->getParam('controller') . '/' .
                    $this->getRequest()->getParam('action');
        }
    }
}