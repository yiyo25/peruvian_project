<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistema de Programación de Vuelo</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link href="<?php echo URLPUBLIC;?>/css/Site_new.css?version=1.1" rel="stylesheet" type="text/css" />
    <link href="<?php echo URLPUBLIC;?>/css/bootstrap.css?version=1.1" rel="stylesheet" type="text/css" />
    <link href="<?php echo URLPUBLIC;?>/css/netStyles_new.css?version=1.1" rel="stylesheet" type="text/css" />
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <!--<div class="wrapper">-->
    <form method="post" action="<?php echo URLLOGICA;?>login/" id="">
        <div class="backred">
            <div class="userLogin">
                <div class="formLogin">
                    <div class="logo_ness_login"></div>
                    <div class="row">
                        <label for="usuario" class="control-label col-md-3 label_login">
                            Usuario
                        </label>
                    </div>
                    <div class="row">
                        <input name="usuario" type="text" id="usuario" class="col-md-3 form-control" />
                    </div>
                    <div class="row">
                        <label for="password" class="control-label col-md-3 label_login">
                            Clave
                        </label>
                    </div>
                    <div class="row">
                        <input name="password" type="password" id="password" class="form-control col-md-3" />
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="submit" name="ingresar" value="INGRESAR" id="ingresar" class="btn boton_login btn-block" />
                        </div>
                        <div class="col-md-6">
                            <input type="reset" class="btn boton_login btn-block" value="LIMPIAR" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <center>
                               <span style="color: #fff">
                                <?php
                                   //echo "<pre>".print_r($this->objlogin,true)."</pre>";
                                   if(isset($this->objloginError)){
                                       echo utf8_encode($this->objlogin["Error"]["Descripcion"]);
                                   }
                                ?>
                                </span>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php include 'footer_view.php';?>
