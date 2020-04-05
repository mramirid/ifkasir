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
    <!-- CSS Libraries -->
    <link href="<?= base_url('assets/extra-libs/c3/c3.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/libs/chartist/chartist.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') ?>" rel="stylesheet">
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
                            <!-- Mengganti button tanggal menjadi search tanggal di halaman list penjualan -->
                            <?php if ($this->uri->segment(1) == 'sales') : ?>
                                <form action="<?= base_url('sales/search_time') ?>" method="POST">
                                    <div class="customize-input">
                                        <input name="time" class="form-control custom-shadow custom-radius border-0 bg-white" type="search" placeholder="DD-MM-YYYY" aria-label="Search" value="<?= $this->session->userdata('time') ?>">
                                    </div>
                                </form>
                            <?php else : ?>
                                <button type="button" class="btn btn-primary btn-rounded"><i class="fas fa-calendar"></i> &nbsp;<?= date('d/m/y') ?></button>
                            <?php endif ?>
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
                All Rights Reserved by PKL IFKasir Kelompok Inventory - Kasir - Pembukuan.
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

    <!-- Grafik di dashboard -->
    <?php if ($this->uri->segment(1) == 'home') : ?>
        <script src="<?= base_url('assets/libs/chartist/chartist.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/chartist-plugin-tooltips/chartist-plugin-tooltip.min.js') ?>"></script>
        <script src="<?= base_url('assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js') ?>"></script>
        <script src="<?= base_url('assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js') ?>"></script>
        <script src="<?= base_url('assets/js/pages/dashboards/dashboard.js') ?>"></script>
    <?php endif ?>
    
    <!-- Cetak struk -->
    <script>
		function printDiv(divName){
			var printContents = document.getElementById(divName).innerHTML;
			var originalContents = document.body.innerHTML;

			document.body.innerHTML = printContents;

			window.print();

			document.body.innerHTML = originalContents;
		}
	</script>

    <!-- Tabel inventory pakai data table -->
    <?php if ($this->uri->segment(1) == 'inv' || $this->uri->segment(1) == 'invloss') : ?>
        <script src="<?= base_url() ?>assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script>
            $('#tabel_pembelian, #tabel_inv').DataTable();
        </script>
    <?php endif ?>
</body>

</html>