<?php


class LogoutController extends Controller
{
    public function indexAction(){
        if(isset($_SESSION[NAME_SESS_USER]) && count($_SESSION[NAME_SESS_USER])>0){
            // unset($_SESSION[NAME_SESS_USER]);
            session_destroy();
            //echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";exit;
            header('location:'.URL_LOGIN_APP);
            exit;
        }
    }
}