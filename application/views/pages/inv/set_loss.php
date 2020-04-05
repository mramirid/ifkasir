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
                        <h4 class="card-title">Data Rugi Detail</h4>
                    </div>
                    <div class="table-responsive">
                        <table id="tabel_inv" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Id Barang</th>
                                    <th>Total Harga</th>
                                    <th>Total Rugi</th>
                                    <th>Settings</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Id Barang</th>
                                    <th>Total Harga</th>
                                    <th>Total Rugi</th>
                                    <th>Settings</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($detail_pembelian->result() as $row) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row->id_barang ?></td>
                                        <td><?= $row->subtotal_beli ?></td>
                                        <td><?= $row->subtotal_rugi ?></td>
                                        <td>

                                            <button type="button" class="btn btn-primary badge" data-toggle="modal" data-target="#edit_barang<?= $row->id_detail_pembelian ?>">
                                                Set Rugi
                                            </button>

                                            <div class="modal fade" id="edit_barang<?= $row->id_detail_pembelian ?>" tabindex="-1" role="dialog" aria-labelledby="edit_barangLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="edit_barangLabel">Set Rugi</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <form role="form" action="<?= base_url() . 'inv/edit_rugi/' . $row->id_detail_pembelian ?>" method="post">
                                                            <div class="modal-body">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-sm">
                                                                            <div class="form-group">
                                                                                <label>Nama Menu</label>
                                                                                <input type="name" name="id_menu" class="form-control" value="<?= $row->id_barang ?>" readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm">
                                                                            <div class="form-group">
                                                                                <label>Jumlah Barang</label>
                                                                                <input type="number" name="jumlah_barang" class="form-control" value="<?= $row->qty_beli ?>" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" name="id_pembelian" value="<?= $row->id_pembelian ?>">
                                                                    <div class="form-group">
                                                                        <label>total Rugi</label>
                                                                        <input type="number" name="total_rugi" class="form-control" value="<?= $row->subtotal_rugi ?>" autocomplete="off" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" name="edit_rugi" class="btn btn-primary">Edit Data</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
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