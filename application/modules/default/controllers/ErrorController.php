<?php
/**
 * Default error controller
 *
 * @category Application
 * @package Application_Default
 * @subpackage Controllers
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://github.com/newage/clean-zfext
 * @since php 5.1 or higher
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
                $this->view->exception = 'Sorry, the page you were looking does not exist.';
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

        $this->view->identity = Zend_Auth::getInstance()->hasIdentity();
    }
}