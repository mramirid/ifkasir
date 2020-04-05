<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Data Kerugian Pembelian</h4>
                    </div>
                    <div class="table-responsive">
                        <table id="tabel_pembelian" class="table table-striped table-bordered no-wrap">
                            <thead>
                                <tr>
                                    <th>Waktu Pembelian</th>
                                    <th>Nama User</th>
                                    <th>Nama Toko</th>
                                    <th>Total Harga</th>
                                    <th>Total Rugi</th>
                                    <th>Settings</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Waktu Pembelian</th>
                                    <th>Nama User</th>
                                    <th>Nama Toko</th>
                                    <th>Total Harga</th>
                                    <th>Total Rugi</th>
                                    <th>Settings</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($loss_pembelian->result() as $row) { ?>
                                    <tr>
                                        <td><?= $row->waktu_pembelian ?></td>
                                        <td><?= $row->nama ?></td>
                                        <td><?= $row->nama_toko ?></td>
                                        <td><?= $row->total_harga ?></td>
                                        <td><?= $row->total_rugi ?></td>
                                        <?php if ($this->session->userdata('role') == 'admin' || $this->session->userdata('nama') == $row->nama) { ?>
                                            <td class="text-center">
                                                <a href="<?= base_url() . 'InvLoss/set_rugi/' . $row->id_pembelian ?>" class="btn btn-warning badge">Set Rugi</a><br>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>