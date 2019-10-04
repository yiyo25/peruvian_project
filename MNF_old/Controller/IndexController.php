<?php


class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        //echo "sf";Exit;
        if (!$this->isAccesoApp()) {
            header('location:'.URL_LOGIN_APP);
            exit;
        }else{
            $this->redireccionar("tuua_application/ta_listado_vuelos");
        }
    }
}