<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        Sistema de Programación de Vuelo
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <!--<link rel="icon" href="data:;base64,=">-->
    <link rel="stylesheet" href="<?php echo URLPUBLIC;?>/bootstrap/css/bootstrap.min.css?version=1.8">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">-->
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo URLPUBLIC;?>/css/plantilla.css?version=1.8">
    <link rel="stylesheet" href="<?php echo URLPUBLIC;?>/css/peruvian.css?version=1.8">
    <link rel="stylesheet" href="<?php echo URLPUBLIC;?>/css/jquery-ui.css?version=1.8">
    <link rel="stylesheet" href="<?php echo URLPUBLIC;?>/css/select2.css?version=1.8">
    <!-- Para DataTables -->
    <link rel="stylesheet" href="<?php echo URLPUBLIC;?>/css/dataTables.css">
    <!-- Para datetimepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css" />    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.css" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap2/bootstrap-switch.css" /> 
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    
    <script src="<?php echo URLPUBLIC;?>/plugins/jQuery/jquery-2.2.3.min.js?version=1.8"></script>
    <script src="<?php echo URLPUBLIC;?>/js/jquery-ui.js?version=1.8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="<?php echo URLPUBLIC;?>/bootstrap/js/bootstrap.min.js?version=1.8"></script>
    <script src="<?php echo URLPUBLIC;?>/js/peruvian.js?version=1.8"></script>
    <script src="<?php echo URLPUBLIC;?>/js/validacion.js?version=1.8"></script>
    
    <script src="<?php echo URLPUBLIC;?>/js/select2.js?version=1.8"></script>
    
    <!-- Para DataTables -->
    <script src="<?php echo URLPUBLIC;?>/js/dataTables.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <!-- Para datetimepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js"></script>
    
    <!-- Para Chainned -->
    <script src="<?php echo URLPUBLIC;?>/js/jquery.chained.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.js"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
       
    <!-- Para el calendario de Programación -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.print.css" />
       
    <script src="https://cdn.datatables.net/fixedcolumns/3.2.2/js/dataTables.fixedColumns.min.js"></script>
    <link href="https://cdn.datatables.net/fixedcolumns/3.2.2/css/fixedColumns.dataTables.min.css" rel="stylesheet"/>
        
</head>
<body class="hold-transition skin-blue sidebar-mini" id="bodyProgVuelo" unload="JavaScript:checkRefresh();">
    <div class="wrapper">
        <?php include "menu_view.php";?>
        <div class="preloader" id="preloader"></div>