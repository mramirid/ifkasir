<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    
    <?php $this->load->view('layouts/_alert') ?>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">List Penjualan</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table no-wrap v-middle mb-0">
                            <thead>
                                <tr class="border-0">
                                    <th class="border-0 font-14 font-weight-medium text-muted px-2">ID Penjualan</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted px-2">Nama Kasir</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted px-2 text-center">Waktu Penjualan</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">Total Harga</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($content as $row) : ?>
                                    <tr>
                                        <td class="border-top-0 px-2 py-4 font-weight-medium"><?= $row->id_penjualan ?></td>
                                        <td class="border-top-0 text-muted px-2 py-4 font-14"><?= $row->nama ?></td>
                                        <td class="border-top-0 text-muted px-2 py-4 font-14 text-center"><?= date('d-m-Y H:i:s', strtotime($row->waktu_penjualan)) ?></td>
                                        <td class="border-top-0 text-center text-muted px-2 py-4">Rp.<?= number_format($row->total_harga, 0, ',', '.') ?>,-</td>
                                        <td class="border-top-0 text-center text-muted px-2 py-4">
                                            <a href="<?= base_url("sales/detail/$row->id_penjualan") ?>" class="btn btn-primary btn-rounded"><i data-feather="shopping-cart"></i>&nbsp;&nbsp;Detail</a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if ($this->uri->segment(2)) : ?>
                    <div class="card-footer bg-white">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 mb-2">
                                <a href="<?= base_url('sales') ?>" class="btn btn-primary btn-rounded text-white"><i class="fas fa-angle-left"></i> List Penjualan</a>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2 d-flex justify-content-center">
                                <div class="row d-flex justify-content-center">
                                    <nav aria-label="Page navigation example">
                                        <?= $pagination ?>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="row d-flex justify-content-center">
                        <nav aria-label="Page navigation example">
                            <?= $pagination ?>
                        </nav>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->