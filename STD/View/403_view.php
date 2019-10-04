<?php include "header_view.php";?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Acceso Denegado

            </h1>

        </section>
        <!-- Main content -->
        <section class="content">
            <div class="error-page">
                <h2 class="headline text-red">403</h2>

                <div class="error-content">
                    <h3><i class="fa fa-warning text-red"></i> Oops! Acceso Denegado.</h3>

                    <p>
                        <?php echo $this->error_text; ?>
                    </p>
                    <a class="btn btn-danger" href="javascript:history.back()"> return to Home</a>

                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?php include "footer_view.php";?>