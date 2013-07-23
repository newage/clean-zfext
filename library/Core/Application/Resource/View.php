<?php

/**
 * Extend resource for View
 *
 * @category Core
 * @package Core_Application
 * @subpackage Resource
 * @author V.Leontiev
 *
 * @version  $Id$
 */
class Core_Application_Resource_View extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * @var Zend_View_Interface
     */
    protected $_view;

    /**
     * Defined by Zend_Application_Resource_Resource
     *
     * @return Core_View
     */
    public function init()
    {
        $view = $this->getView();

        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
        $viewRenderer->setView($view);
        return $view;
    }

    /**
     * Retrieve view object
     *
     * @return Core_View
     */
    public function getView()
    {
        if (null === $this->_view) {
            $options = $this->getOptions();

            $this->_view = new Core_View($options);

            if (isset($options['doctype'])) {
                $this->_view->doctype()->setDoctype(strtoupper($options['doctype']));
                if (isset($options['charset']) && $this->_view->doctype()->isHtml5()) {
                    $this->_view->headMeta()->setCharset($options['charset']);
                }
            }
            if (isset($options['contentType'])) {
                $this->_view->headMeta()->appendHttpEquiv('Content-Type', $options['contentType']);
            }
            if (isset($options['assign']) && is_array($options['assign'])) {
                $this->_view->assign($options['assign']);
            }

            if (isset($options['title'])) {
                $this->_view->headTitle($options['title'])->enableTranslation();
            }

            if (isset($options['titleSeparator'])) {
                $this->_view->headTitle()->setSeparator($options['titleSeparator']);
            }

            if (isset($options['title'])) {
                $this->_view->projectTitle($options['title']);
            }
        }
        return $this->_view;
    }
}

