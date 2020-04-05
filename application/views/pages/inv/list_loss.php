<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Good Morning <?= $this->session->userdata('nama') ?>!</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="inv">Inventory</a></li>
                        <li class="breadcrumb-item text-muted" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-5 align-self-center">
            <div class="float-right">
                <button type="button" class="btn btn-primary btn-rounded"><i class="fas fa-calendar"></i> &nbsp;<?= date('d/m/y') ?></button>
            </div>
        </div>
    </div>
</div>
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
                                        <td><?= $row->id_user ?></td>
                                        <td><?= $row->nama_toko ?></td>
                                        <td><?= $row->total_harga ?></td>
                                        <td><?= $row->total_rugi ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url() . 'inv/set_rugi/' . $row->id_pembelian ?>" class="btn btn-warning badge">Set Rugi</a><br>
                                        </td>
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