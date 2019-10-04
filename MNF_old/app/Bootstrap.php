<?php

class Bootstrap {

    public static function run(Request $request) {

        $controller = $request->getControlador() . 'Controller';
        $metodo = $request->getMetodo() . 'Action';
        $args = $request->getArgs();

        $rutaControlador = ROOT . 'Controller' . DS . $controller . '.php';
        //echo $rutaControlador;exit;
        if (is_readable($rutaControlador)) {

            require_once $rutaControlador;

            $controlador = new $controller;

            if (is_callable(array($controlador, $metodo))) {
                $metodo = $request->getMetodo() . 'Action';
            }/* else{
              $metodo = 'indexAction';
              } */

            if (method_exists($controlador, $metodo)) {
                if (isset($args)) {
                    call_user_func_array(array($controlador, $metodo), $args);
                } else {
                    call_user_func(array($controlador, $metodo));
                }
            } else {
                throw new Exception('El metodo ' . $metodo . ' no existe');
            }
        } else {
            $view = new View();
            $view->show404page();
            exit();
            //throw new Exception('Controlador No encontrado existe');
        }
    }

}

?>