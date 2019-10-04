<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo URLLOGICA;?>" class="logo">
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
        <a href="" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="<?php echo URLLOGICA;?>" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs"><?php echo $this->objUsu;?></span>
                        <input type="hidden" id="Usuario" name="Usuario" value="<?php echo $this->objUsu["Usuario"];?>" />
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
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">Sistema de Programación de Vuelo</li>
            <?php echo $this->objMenu; ?>
            <!-- Optionally, you can add icons to the links -->
           
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>