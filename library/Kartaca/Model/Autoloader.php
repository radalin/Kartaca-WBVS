<?php

class Kartaca_Model_Autoloader
{
    public static function autoload($className)
    {
        if (Zend_Loader::isReadable("{$className}.php")) {
            require_once("{$className}.php");
        } else if (Zend_Loader::isReadable("tables/{$className}.php")) {
            require_once("tables/{$className}.php");
        }
    }
}
