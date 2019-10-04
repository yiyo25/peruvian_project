<?php

/**
 * 
 */
class PruebaController extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function indexAction() {
        $ciudad = Ciudad::all();
        echo "<pre>";
        print_r($ciudad);
        echo "</pre>";
        exit;

        /* foreach ($ciudad as  $value) {
          echo $value->cod_ciudad;
          } */

        /* $ciudad = new Ciudad();
          print_r($ciudad->getCiudad()); */
        $this->_view->assign("hola", "aaaaa");
        $this->_view->show_page("index.tpl");
    }

}

?>