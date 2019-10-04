<!DOCTYPE html>
<html>
{$content_head}

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

      <!-- Logo -->
        <a href="{$BASE_URL}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">
                  <img src="{$SERVER_PUBLIC}img/logo-peruvian-small.png" />
            </span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">
                  <img src="{$SERVER_PUBLIC}img/logo-peruvian.png" />
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
                  <span class="hidden-xs">{$NAME_USER}</span>
                </a>
              </li>
              <li>
                <a href="{$BASE_URL}logout" ><i class="fa fa-power-off"></i></a>
              </li>
            </ul>
          </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    {include file="inc/sidebar.tpl"}
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          {$title}
          <small>{$descripcion}</small>
        </h1>
        {*<ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-thumb-tack"></i> Nivel 1</a></li>
          <li class="active">Nivel Actual</li>
        </ol>*}
        
      </section>

      <!-- Main content -->
      <section class="content">
          
            <div id="notification_succes" class="alert alert-success alert-dismissable" role="alert" 
                 style="background-color: #d4edda !important; color: #155724 !important; display:none; ">
                <span id="message_notification">A simple success alert—check it out!</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                </button>
            </div>
        {$content_main}
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    {$content_footer}

  </div>
    {$content_footer_js}

</body>
</html>
