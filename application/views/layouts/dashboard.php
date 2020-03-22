<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/images/logo-icon.png') ?>">
    <title><?= $title ?></title>
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/extra-libs/c3/c3.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/libs/chartist/chartist.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css') ?>" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/style.min.css') ?>" rel="stylesheet">
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

        <!-- Navbar -->
        <?php $this->load->view('layouts/_navbar') ?>
        <!-- End Navbar -->

        <!-- Sidebar -->
        <?php $this->load->view('layouts/_sidebar') ?>
        <!-- End Sidebar -->

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-7 align-self-center">
                        <h3 class="page-title text-truncate text-dark font-weight-medium mb-1"><?= $breadcrumb_title ?></h3>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item active" aria-current="page"><?= $breadcrumb_path ?></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-5 align-self-center">
                        <div class="float-right">
                            <button type="button" class="btn btn-primary btn-rounded"><i class="fas fa-calendar"></i> &nbsp;<?= date('d-m-Y') ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->

            <!-- Content -->
            <?php $this->load->view($page) ?>
            <!-- End Content -->

            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center text-muted">
                All Rights Reserved by PKL Kelompok Kasir. Designed and Developed by Amir - Alfath - Aliev.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Main Wrapper -->
    <!-- ============================================================== -->
    
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?= base_url('assets/libs/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/libs/popper.js/umd/popper.min.js') ?>"></script>
    <script src="<?= base_url('assets/libs/bootstrap/js/bootstrap.min.js') ?>"></script>
    <!-- apps -->
    <!-- apps -->
    <script src="<?= base_url('assets/js/app-style-switcher.js') ?>"></script>
    <script src="<?= base_url('assets/js/feather.min.js') ?>"></script>
    <script src="<?= base_url('assets/libs/perfect-scrollbar/perfect-scrollbar.jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/sidebarmenu.js') ?>"></script>
    <!--Custom JavaScript -->
    <script src="<?= base_url('assets/js/custom.min.js') ?>"></script>
    <!--This page JavaScript -->
    <script src="<?= base_url('assets/extra-libs/c3/d3.min.js') ?>"></script>
    <script src="<?= base_url('assets/extra-libs/c3/c3.min.js') ?>"></script>
    <script src="<?= base_url('assets/libs/chartist/chartist.min.js') ?>"></script>
    <script src="<?= base_url('assets/libs/chartist-plugin-tooltips/chartist-plugin-tooltip.min.js') ?>"></script>
    <script src="<?= base_url('assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js') ?>"></script>
    <script src="<?= base_url('assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js') ?>"></script>
    <script src="<?= base_url('assets/js/pages/dashboards/dashboard1.min.js') ?>"></script>
</body>

</html>