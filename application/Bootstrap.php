<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initModels()
    {
        $this->bootstrap("namespace"); //Make sure that namespace bootstrap has run before...
        //Add models to the include path...
        set_include_path(
            get_include_path() . PATH_SEPARATOR .
            APPLICATION_PATH . "/models/"
        );

        //Now register the custom model autoloader...
        Zend_Loader_Autoloader::getInstance()
            ->pushAutoloader(array('Kartaca_Model_Autoloader', 'autoload'));
    }

    protected function _initNamespace()
    {
        Zend_Loader_Autoloader::getInstance()->registerNamespace("Kartaca");
    }

    protected function _initRoutes()
    {
        //Don't forget to bootstrap the front controller as the resource may not been created yet...
        $this->bootstrap("frontController");
        $front = $this->getResource("frontController");
        //Read the routes from an ini file and in that ini file use the options with routes prefix...
        //$front->getRouter()->addConfig(new Zend_Config_Ini(APPLICATION_PATH . "/configs/routes.ini"), "routes");
    }

    protected function _initConstants()
    {
        define("APPLICATION_BASEURL", $this->_options["baseUrl"]);
        define("APPLICATION_BASEURL_INDEX", $this->_options["baseUrl"] . "/index.php");
    }

}

