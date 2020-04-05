<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    
    <?php $this->load->view('layouts/_alert') ?>
    
    <div class="card-group">
        <div class="card border-right">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <div class="d-inline-flex align-items-center">
                            <h2 class="text-dark mb-1 font-weight-medium"><?= getJumlahKaryawan() ?> Orang</h2>
                        </div>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Karyawan</h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="users"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-right">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium">
                            <sup class="set-doller overflow-auto">Rp.</sup><?= number_format(getTodayEarning(), 0, ',', '.') ?></h2>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Pendapatan hari ini
                        </h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="dollar-sign"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-right">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <div class="d-inline-flex align-items-center">
                            <h2 class="text-dark mb-1 font-weight-medium"><?= getTodayCountSales() ?></h2>
                        </div>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Penjualan hari ini</h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="shopping-cart"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <h2 class="text-dark mb-1 font-weight-medium"><?= getCountMenu() ?></h2>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Jumlah Menu</h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="box"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- *************************************************************** -->
    <!-- End First Cards -->
    <!-- *************************************************************** -->
    <!-- *************************************************************** -->
    <!-- Start Location and Earnings Charts Section -->
    <!-- *************************************************************** -->
    <div class="row">
        <div class="col-md-6 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <h4 class="card-title mb-0">Statistik Pendapatan</h4>
                    </div>
                    <div class="pl-4 mb-5">
                        <div class="stats ct-charts position-relative" style="height: 350px;"></div>
                    </div>
                    <ul class="list-inline text-center mt-4 mb-0">
                        <li class="list-inline-item text-muted font-italic">Pendapatan harian (dalam lipatan ratusan)</li>
                    </ul>
                    <script>
                        // Tanggal & total saling berhubungan
                        var tanggal = [];
                        var total   = [];
                        <?php foreach ($list_penjualan_seminggu as $row) : ?>
                            tanggal.push(<?= $row->tanggal ?>);
                            total.push(<?= $row->total / 100000 ?>);
                        <?php endforeach ?>
                    </script>
                </div>
            </div>
        </div>
        <!-- Start Aktivitas Penjualan -->
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Aktivitas Penjualan</h4>
                    <div class="mt-4 activity">
                        <?php foreach ($list_penjualan as $row) : ?>
                            <div class="d-flex align-items-start border-left-line pb-3">
                                <div>
                                    <a href="<?= base_url("sales/detail/$row->id_penjualan") ?>" class="btn btn-info btn-circle mb-2 btn-item">
                                        <i data-feather="shopping-cart"></i>
                                    </a>
                                </div>
                                <div class="ml-3 mt-2">
                                    <h5 class="text-dark font-weight-medium mb-2">Penjualan Nomor <?= $row->id_penjualan ?></h5>
                                    <p class="font-14 mb-2 text-muted">
                                        Dilayani oleh <?= $row->nama ?> 
                                        <br>
                                        Rp.<?= number_format($row->total_harga, 0, ',', '.') ?>,-
                                    </p>
                                    <span class="font-weight-light font-14 text-muted"><?= $row->waktu_penjualan ?></span>
                                </div>
                            </div>
                        <?php endforeach ?>
                        <a href="<?= base_url('sales') ?>" class="font-14 border-bottom pb-1 border-info">Load More</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Aktivitas Penjualan -->
    </div>
    <!-- *************************************************************** -->
    <!-- End Location and Earnings Charts Section -->
    <!-- *************************************************************** -->
    <!-- *************************************************************** -->
    <!-- Start List Users -->
    <!-- *************************************************************** -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Daftar Karyawan</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table no-wrap v-middle mb-0">
                            <thead>
                                <tr class="border-0">
                                    <th class="border-0 font-14 font-weight-medium text-muted px-2">Nama</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted px-2">Email</th>
                                    <!-- Hanya admin yang boleh liat KTP -->
                                    <?php if ($this->session->userdata('role') == 'admin') : ?>
                                        <th class="border-0 font-14 font-weight-medium text-muted px-2">KTP</th>
                                    <?php endif ?>
                                    <th class="border-0 font-14 font-weight-medium text-muted">Role</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">Status</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">Telefon</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $row) : ?>
                                    <tr>
                                        <td class="border-top-0 px-2 py-4"><?= $row->nama ?></td>
                                        <td class="border-top-0 text-muted px-2 py-4 font-14"><?= $row->email ?></td>
                                        <!-- Hanya admin yang boleh liat KTP -->
                                        <?php if ($this->session->userdata('role') == 'admin') : ?>
                                            <td class="border-top-0 text-muted px-2 py-4 font-14"><?= $row->ktp ?></td>
                                        <?php endif ?>
                                        <td class="border-top-0 px-2 py-4">
                                            <?php if ($row->role == 'admin') : ?>
                                                <div class="popover-icon">
                                                    <!-- Admin juga sebagai kasir -->
                                                    <button class="btn btn-primary rounded-circle btn-circle font-12" data-toggle="tooltip" data-placement="top" title="Administrator">ADM</button>

                                                    <button class="btn btn-cyan rounded-circle btn-circle font-12 popover-item" data-toggle="tooltip" data-placement="top" title="Kasir">KSR</button>
                                                </div>
                                            <?php else : ?>
                                                <div class="popover-icon">
                                                    <!-- Elemen bantu -->
                                                    <button class="btn btn-white rounded-circle btn-circle font-12"></button>

                                                    <button class="btn btn-cyan rounded-circle btn-circle font-12 popover-item" data-toggle="tooltip" data-placement="top" title="Kasir">KSR</button>
                                                </div>
                                            <?php endif ?>
                                        </td>
                                        <td class="border-top-0 text-center px-2 py-4">
                                            <?php if ($row->status == 'aktif') : ?>
                                                <i class="fa fa-circle text-success font-12" data-toggle="tooltip" data-placement="top" title="Akun Aktif"></i>
                                            <?php else : ?>
                                                <i class="fa fa-circle text-danger font-12" data-toggle="tooltip" data-placement="top" title="Akun Non-Aktif"></i>
                                            <?php endif ?>
                                        </td>
                                        <td class="border-top-0 text-center text-muted px-2 py-4"><?= $row->telefon ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="row mb-3">
                        <div class="col-md-12 col-sm-12 mb-2">
                            <a href="<?= base_url('users') ?>" class="btn btn-primary btn-rounded text-white float-right">Lihat Daftar Karyawan <i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- *************************************************************** -->
    <!-- End List Users -->
    <!-- *************************************************************** -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->