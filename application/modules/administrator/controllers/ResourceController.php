<?php
/**
 * Administrator resource controller
 *
 * @category Application
 * @package Application_Administrator
 * @subpackage Controllers
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://github.com/newage/clean-zfext
 * @since php 5.1 or higher
 */

class Administrator_ResourceController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout->setLayout('administrator/layout');

        $this->_helper->contextSwitch()
            ->addActionContext('data', 'json')
            ->initContext();
    }

    /**
     * @todo Create table helper and create js table
     */
    public function indexAction()
    {
        $this->view->tableHeader = array(
            'Id',
            'Name',
            'Parent'
        );
    }

    public function dataAction()
    {
        $model = new Administrator_Model_Resource($this->getRequest()->getParams());
        $resources = $model->getResources();
        $this->view->sEcho = 1;
        $this->view->iTotalRecords = count($resources);
        $this->view->iTotalDisplayRecords = 10;
        $this->view->aaData = $resources;
    }
}
