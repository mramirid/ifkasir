<div class="container-fluid">
    
    <?php $this->load->view('layouts/_alert') ?>

    <div class="row" id="printStruk">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    Detail Penjualan
                </div>
                <div class="card-body">
                    <table class="table-responsive mb-3 no-wrap">
                        <tr>
                            <td>Nomor penjualan</td>
                            <td>:</td>
                            <td><?= $penjualan->id_penjualan ?></td>
                        </tr>
                        <tr>
                            <td>NIP Kasir</td>
                            <td>:</td>
                            <td><?= $penjualan->id_user ?></td>
                        </tr>
                        <tr>
                            <td>Nama Kasir</td>
                            <td>:</td>
                            <td><?= $penjualan->nama ?></td>
                        </tr>
                        <tr>
                            <td>Waktu</td>
                            <td>:</td>
                            <td><?= date('d/m/Y H:i:s', strtotime($penjualan->waktu_penjualan)) ?></td>
                        </tr>
                    </table>
                    <p>Terima kasih sudah berbelanja 😊</p>
                    <table class="table table-responsive w-100 d-block d-md-table">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list_pesanan as $row) : ?>
                                <tr>
                                    <td>
                                        <strong><?= $row->nama_barang ?></strong>
                                    </td>
                                    <td class="text-center">Rp.<?= number_format($row->harga_jual, 0, ',', '.') ?>,-</td>
                                    <td class="text-center"><?= $row->qty_jual ?></td>
                                    <td class="text-center">Rp.<?= number_format($row->subtotal_jual, 0, ',', '.') ?>,-</td>
                                </tr>
                            <?php endforeach ?>
                            <tr>
                                <td colspan="3"><strong>Total:</strong></td>
                                <td class="text-center"><strong>Rp.<?= number_format(array_sum(array_column($list_pesanan, 'subtotal_jual')), 0, ',', '.') ?>,-</strong></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-2">
                            <a href="<?= base_url('sales') ?>" class="btn btn-primary btn-rounded text-white"><i class="fas fa-angle-left"></i> Kembali ke List Penjualan</a>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-2">
                            <button class="btn btn-success btn-rounded float-right" onclick="printDiv('printStruk')">Cetak Struk <i class="fas fa-angle-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>