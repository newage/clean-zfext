<?php

/**
 * Get ACL map from xml files
 *
 * @author vadim
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

