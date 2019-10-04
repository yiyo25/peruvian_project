<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LogoutController
 *
 * @author ihuapaya
 */
class LogoutController extends Controller{
    
    public function indexAction(){
        if(isset($_SESSION[NAME_SESS_USER]) && count($_SESSION[NAME_SESS_USER])>0){
           // unset($_SESSION[NAME_SESS_USER]);
           session_destroy();
            //echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";exit;
            header('location:https://dev.peruvian.pe/loginPeruvian/ES/');
            exit;
        }
    }
   
}
