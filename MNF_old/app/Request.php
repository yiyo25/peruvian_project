<?php

Class Request {

    private $_controlador;
    private $_metodo;
    private $_argumento;

    public function __construct() {

        if (isset($_GET['url'])) {
           // echo "sdf";Exit;
            //filtramos 'url'..elimina todos los caracteres ecepto las letras
            $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);

            $url = explode('/', $url); //devuelve un array  de cadenas creadas spor el separador '/';

            $url = array_filter($url); //elinina todos los elemento q no sean valido en el array

            $this->_controlador = ucfirst(strtolower(array_shift($url))); //extrae el primer elemento del array
            $this->_metodo = strtolower(array_shift($url));
            $this->_argumento = $url;
        }else{
            echo "sdf";exit;
        }


        if (!$this->_controlador) {

            $this->_controlador = "Index";
        }


        if (!$this->_metodo) {

            $this->_metodo = 'index';
        }

        if (!isset($this->_argumento)) {

            $this->_argumento = array();
        }
    }

    public function getControlador() {

        return $this->_controlador;
    }

    public function getMetodo() {

        return $this->_metodo;
    }

    public function getArgs() {

        return $this->_argumento;
    }

}

?>