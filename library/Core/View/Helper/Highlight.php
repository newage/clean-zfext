<?php

/**
 * Highlight code
 *
 * @category Core
 * @package Core_View
 * @subpackage Helper
 * @author V.Leontiev
 */
class Core_View_Helper_Highlight extends Zend_View_Helper_HtmlElement
{
    /**
     * Include prettify css and js
     *
     * @param array $urlOptions
     * @param string $content
     * @param array $options Element options
     * @return string
     */
    public function highlight($code)
    {
        $this->view->headScript()->appendFile('js/prettify.js');
        $this->view->headLink()->appendStylesheet('css/prettify.css');
        $content = '<pre class="prettyprint linenums languague-js">' . $code . '</pre>';

        $this->view->jQuery()->addOnload('prettyPrint()');
        return $content;
    }
}
