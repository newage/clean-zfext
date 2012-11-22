<?php
include("phar://".dirname(__FILE__)."/vendor/ZendFramework/library/zf.phar");
$version = new Zend_Version;
print "Compiled ZF version is: \r\n";
print $version::VERSION."\r\n";
