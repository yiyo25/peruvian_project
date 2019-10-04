<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	private static $instance;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		self::$instance =& $this;
		
		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');

		$this->load->initialize();
		
		log_message('debug', "Controller Class Initialized");
	}

	public static function &get_instance()
	{
		return self::$instance;
	}

    function isAccessProgram($programa,$tipo,$usuario){

        $apilogin = new ApiLogin();
        //$usuario = $_SESSION[NAME_SESS_USER]["id_usuario"];
        $acceso = $apilogin->GetAccesoProgExec($usuario,$programa,$tipo);

        if(isset($acceso->result) && $acceso->result == true){
            return true;
        }else{
            return false;
        }
    }

    function PermisosporPaginas($programa,$tipo,$usuario){

        require_once '../../ApiLogin/apiLogin.php';
        $apilogin = new ApiLogin();
        //echo $usuario;Exit;
        //$usuario = $_SESSION[NAME_SESS_USER]["id_usuario"];
        $acceso = $apilogin->GetPermisosProgporPaginas($usuario,$programa,$tipo);
        return $acceso->permisos;

    }
    function getAllPermisos($usuario,$usuario,$tipo=1){
        $apilogin = new ApiLogin();

        $acceso = $apilogin->getAllPermisos($usuario,$tipo);
        return $acceso->permisos;

    }
}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */