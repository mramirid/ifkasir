<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- Submemu Dashboard -->
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="<?= base_url('home') ?>" aria-expanded="false">
                        <i data-feather="home" class="feather-icon"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <li class="list-divider"></li>

                <!-- Submemu Kasir -->
                <li class="nav-small-cap"><span class="hide-menu">Kasir</span></li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?= base_url('cashier') ?>" aria-expanded="false">
                        <i data-feather="file-plus" class="feather-icon"></i>
                        <span class="hide-menu">Pesan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?= base_url('cart') ?>" aria-expanded="false">
                        <i data-feather="shopping-cart" class="feather-icon"></i>
                        <span class="hide-menu">Keranjang Pesanan</span>
                    </a>
                </li>
                <li class="sidebar-item"> 
                    <a class="sidebar-link sidebar-link" href="<?= base_url('sales') ?>" aria-expanded="false">
                        <i data-feather="list" class="feather-icon"></i>
                        <span class="hide-menu">List Penjualan</span>
                    </a>
                </li>

                <li class="list-divider"></li>

                <!-- Submemu Manajemen Inventory -->
                <li class="nav-small-cap"><span class="hide-menu">Manajemen Inventory</span></li>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="<?= base_url('inv') ?>" aria-expanded="false">
                        <i data-feather="box" class="feather-icon"></i>
                        <span class="hide-menu">Inventory</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="<?= base_url('invloss') ?>" aria-expanded="false">
                        <i data-feather="list" class="feather-icon"></i>
                        <span class="hide-menu">Daftar Rugi</span>
                    </a>
                </li>

                <li class="list-divider"></li>

                <!-- Submemu Pembukuan -->
                <li class="nav-small-cap"><span class="hide-menu">Pembukuan</span></li>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="<?= base_url('pembukuan') ?>" aria-expanded="false">
                        <i data-feather="book" class="feather-icon"></i>
                        <span class="hide-menu">Pembukuan</span>
                    </a>
                </li>

                <li class="list-divider"></li>

                <!-- Submemu Manajemen Karyawan -->
                <li class="nav-small-cap"><span class="hide-menu">Manajemen Karyawan</span></li>
                <li class="sidebar-item"> 
                    <a class="sidebar-link sidebar-link" href="<?= base_url('users') ?>" aria-expanded="false">
                        <i data-feather="users" class="feather-icon"></i>
                        <span class="hide-menu">Daftar Karyawan</span>
                    </a>
                </li>
                <?php if ($this->session->userdata('role') == 'admin') : ?>
                    <li class="sidebar-item"> 
                        <a class="sidebar-link sidebar-link" href="<?= base_url('register') ?>" aria-expanded="false">
                            <i data-feather="user-plus" class="feather-icon"></i>
                            <span class="hide-menu">Register Karyawan</span>
                        </a>
                    </li>
                <?php endif ?>
                
                <li class="list-divider"></li>

                <!-- Submemu Extra -->
                <li class="nav-small-cap"><span class="hide-menu">Extra</span></li>
                <li class="sidebar-item"> 
                    <a class="sidebar-link sidebar-link" href="https://github.com/mramirid/IFKasir.git" aria-expanded="false">
                        <i data-feather="github" class="feather-icon"></i>
                        <span class="hide-menu">Repository</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="<?= base_url('about') ?>" aria-expanded="false">
                        <i data-feather="info" class="feather-icon"></i>
                        <span class="hide-menu">About us</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->