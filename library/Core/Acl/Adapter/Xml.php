<?php

/**
 * Get ACL map from xml files
 *
 * @category   Library
 * @package    Core_Acl
 * @subpackage Adapter
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 */
class Core_Acl_Adapter_Xml implements Core_Acl_Adapter_Abstract
{
    public function getOptions()
    {
        $options = array(
            'config'=>'acl',
            'section'=>'production'
        );

        $moduleConfig = new Core_Module_Config($options);
        $config = $moduleConfig->readConfigs()->toArray();

        return $config;
    }
}

