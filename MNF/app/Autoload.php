<?php 

    function autoloadCore($class)
    {
        if(file_exists(APP_PATH.ucfirst(strtolower($class)).'.php')){
            include_once APP_PATH.ucfirst(strtolower($class)).'.php';
        }
    }

    function autoladLibs($class)
    {
        if(file_exists(ROOT.'library'.DS.'class.'.strtolower($class).'.php')){
            include_once ROOT.'library'.DS.'class.'.strtolower($class).'.php';
        }
    }
    
    function autoladModels($class)
    {
        if(file_exists(ROOT.'Models'.DS.$class.'.php')){
            include_once ROOT.'Models'.DS.$class.'.php';
        }
    }

    spl_autoload_register('autoloadCore');
    spl_autoload_register('autoladLibs');
    spl_autoload_register('autoladModels');
