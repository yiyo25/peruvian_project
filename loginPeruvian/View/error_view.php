<?php include "header_view.php";?>
<style>
.contenedor{
    position: relative;
    display: inline-block;
    text-align: center;
}
 
.texto-encima{
    position: absolute;
    top: 10px;
    left: 10px;
}
.centrado{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
</style>
<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="<?php echo URLLOGICA;?>login/index" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
            <img src="<?php echo URLPUBLIC;?>/img/logo-peruvian-small.png" />
        </span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
            <img src="<?php echo URLPUBLIC;?>/img/logo-peruvian.png" />
        </span>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs">
                            <?php echo 
                            "aa";?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo URLLOGICA;?>login/salir">
                        <i class="fa fa-power-off"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">Detalle de Aplicaciones</li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            APLICACIONES PERUVIAN
            <small>Detalle</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class='box box-danger'>
            <div class="box-header with-border">
                <h3 class="box-title">Aplicaciones</h3>
            </div>
            <div class="box-body">
                <div class='container-fluid'>
                   <div class='row' style="margin-top: 10px">
                    <?php echo $this->msg_catch; ?>
                    </div>
                </div>

            </div>
            <div class="box-footer clearfix">
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include "footer_view.php";?>
