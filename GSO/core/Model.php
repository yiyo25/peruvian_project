<?php 
/*namespace cco_dev\app;
use cco_dev\app\Database as Database;*/

class Model extends Database
{
    
    public function __construct($dbName=DB_NAME) {
        parent::__construct($dbName);
        //$this->db = $this->conectar($dbName);
    }
   
   /* protected static $table;
    protected static $_primary_key;
    protected static $database;
    private $data = array();
    
    function __construct($data = null)
    {
       	$this->data = $data;
    }
	
	
   public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {

        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Propiedad indefinida mediante __get(): ' . $name .
            ' en ' . $trace[0]['file'] .
            ' en la línea ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }*/
}

?>