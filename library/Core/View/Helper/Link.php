<?php

/**
 * Helper for html element <a href="...">...</a>
 *
 * @category   Library
 * @package    Core_View
 * @subpackage Helper
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 * @example    $view->link(array('module'=>'default'), 'text', array('class'=>'link'))
 */
class Core_View_Helper_Link extends Zend_View_Helper_HtmlElement
{
    /**
     * Create href link
     *
     * $urlOptions = array(
     *   'module' => '',
     *   'controller' => '',
     *   'action' => '',
     *   'name' => null,
     *   'reset' => false,
     *   'encode' => true
     * )
     *
     * @param array $urlOptions
     * @param string $content
     * @param array $options Element options
     * @return string
     */
    public function link(array $urlOptions, $content, array $options = array())
    {
        $name = isset($urlOptions['name']) ? $urlOptions['name'] : null;
        unset($urlOptions['name']);
        $reset = isset($urlOptions['reset']) ? $urlOptions['reset'] : true;
        unset($urlOptions['reset']);
        $encode = isset($urlOptions['encode']) ? $urlOptions['encode'] : true;
        unset($urlOptions['encode']);

        $router = Zend_Controller_Front::getInstance()->getRouter();
        $link = $router->assemble($urlOptions, $name, $reset, $encode);

        //translate title
        if (isset($options['title'])) {
            $options['title'] = Zend_Registry::get('Zend_Translate')->translate($options['title']);
        }

        //translate alt
        if (isset($options['alt'])) {
            $options['alt'] = Zend_Registry::get('Zend_Translate')->translate($options['alt']);
        }

        $params = $this->_htmlAttribs($options);

        return '<a href="' . $link . '" ' . $params . '>' . $content . '</a>';
    }
}
