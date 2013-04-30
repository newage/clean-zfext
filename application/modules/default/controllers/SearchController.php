<?php
/**
 * Default search controller
 *
 * @category Application
 * @package Application_Default
 * @subpackage Controllers
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://bitbucket.org/newage/clean-zfext
 * @since php 5.1 or higher
 */

class SearchController extends Zend_Controller_Action
{

    /**
     * Initialize default method
     *
     */
    public function init()
    {
//        Zend_Controller_Action_HelperBroker::addHelper(
//            new ZendX_JQuery_Controller_Action_Helper_AutoComplete()
//        );

        $this->_helper->contextSwitch()
            ->addActionContext('autocomplete', 'json')
            ->initContext();
    }

    /**
     * Intex action
     * Generate login form
     *
     */
    public function indexAction()
    {

        // Add it to the ViewRenderer
//        $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
//        $viewRenderer->setView($this->view);
//        Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);

        $form = new Zend_Dojo_Form();
        $form->addElement(
            'PasswordTextBox',
            'password',
            array(
                'required'       => true,
                'trim'           => true,
                'lowercase'      => true
            )
        );
        $form->addElement(
            'Button',
            'foo',
            array(
                'label' => 'Button Label',
            )
        );
        $this->view->form = $form;

//        $index = Zend_Search_Lucene::create(BASE_PATH . '/data/my-index');
//
//        $doc = new Zend_Search_Lucene_Document();
//
//        $docUrl = 'zend';
//        // Store document URL to identify it in the search results
//        $doc->addField(Zend_Search_Lucene_Field::Text('url', $docUrl));
//
//        $docContent = 'zend ext';
//        // Index document contents
//        $doc->addField(Zend_Search_Lucene_Field::UnStored('contents', $docContent));
//
//        // Add document to the index
//        $index->addDocument($doc);
    }

    public function autocompleteAction()
    {
//        $this->_helper->autoComplete(array("New York"));
    }
}
