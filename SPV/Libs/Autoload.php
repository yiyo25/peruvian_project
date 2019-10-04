<?php 

	function autoladModels($class)
    {

    	//echo ROOT.'Model'.DS.$class.'_model.php';exit;
        if(file_exists(ROOT.'Model'.DS.$class.'.php')){ 
        	//echo ROOT.'Model'.DS.$class.'.php';
            include_once ROOT.'Model'.DS.$class.'.php';
        }
    }

    spl_autoload_register('autoladModels');
 ?>