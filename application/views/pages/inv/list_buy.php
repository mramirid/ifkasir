<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm">
                            <h4 class="card-title">Data Barang</h4>
                        </div>
                        <?php if ($pembelian['status'] != 1) { ?>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-primary badge" data-toggle="modal" data-target="#add_barang">
                                    Tambah Barang
                                </button>

                                <div class="modal fade" id="add_barang" tabindex="-1" role="dialog" aria-labelledby="add_barangLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="add_barangLabel">Tambah Barang</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form role="form" action="<?= base_url() ?>inv/add_detail_pembelian/" method="post">
                                                <div class="modal-body">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label>Nama Menu</label>
                                                            <select name="nama_barang" class="form-control">
                                                                <?php foreach ($list_barang->result() as $rows) { ?>
                                                                    <option value="<?= $rows->id_barang ?>"><?= $rows->nama_barang ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <input type="hidden" name="id_pembelian" value="<?= $id ?>">
                                                        <div class="form-group">
                                                            <label>Jumlah Barang</label>
                                                            <input type="number" name="jumlah_barang" class="form-control" placeholder="Jumlah Barang" autocomplete="off" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Harga Barang</label>
                                                            <input type="number" name="harga_barang" class="form-control" placeholder="Harga Barang" autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="add_barang_detail" class="btn btn-primary">Tambah Barang</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="table-responsive">
                        <table id="tabel_inv" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Id Barang</th>
                                    <th>Jumlah Barang</th>
                                    <th>Harga Barang</th>
                                    <?php if ($pembelian['status'] != 1) echo "<th>Settings</th>" ?>

                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Id Barang</th>
                                    <th>Jumlah Barang</th>
                                    <th>Harga Barang</th>
                                    <?php if ($pembelian['status'] != 1) echo "<th>Settings</th>" ?>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($detail_pembelian->result() as $row) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row->nama_barang ?></td>
                                        <td><?= $row->qty_beli ?></td>
                                        <td><?= $row->subtotal_beli ?></td>
                                        <?php if ($pembelian['status'] != 1) { ?>
                                            <td>

                                                <button type="button" class="btn btn-primary badge" data-toggle="modal" data-target="#edit_barang<?= $row->id_detail_pembelian ?>">
                                                    Edit
                                                </button>

                                                <div class="modal fade" id="edit_barang<?= $row->id_detail_pembelian ?>" tabindex="-1" role="dialog" aria-labelledby="edit_barangLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="edit_barangLabel">Edit Data</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <form role="form" action="<?= base_url() . 'inv/edit_detail_pembelian/' . $row->id_detail_pembelian ?>" method="post">
                                                                <div class="modal-body">
                                                                    <div class="card-body">
                                                                        <div class="form-group">
                                                                            <label>Nama Menu</label>
                                                                            <select name="nama_barang" class="form-control">
                                                                                <?php foreach ($list_barang->result() as $rows) { ?>
                                                                                    <option value="<?= $rows->id_barang ?>"><?= $rows->nama_barang ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <input type="hidden" name="id_pembelian" value="<?= $row->id_pembelian ?>">
                                                                        <div class="form-group">
                                                                            <label>Jumlah Barang</label>
                                                                            <input type="number" name="jumlah_barang" class="form-control" value="<?= $row->qty_beli ?>" autocomplete="off" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Harga Barang</label>
                                                                            <input type="number" name="harga_barang" class="form-control" value="<?= $row->subtotal_beli ?>" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" name="edit_detail_pembelian" class="btn btn-primary">Edit Data</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <a href="#" onclick="del_barang<?= $row->id_detail_pembelian ?>()" class="btn btn-danger badge">Delete</a>
                                                <script>
                                                    function del_barang<?= $row->id_detail_pembelian ?>() {
                                                        var txt;
                                                        if (confirm("Anda yakin ingin mendelete data ini?")) {
                                                            window.location = "<?= base_url() . 'inv/delete_detail_pembelian/' . $row->id_detail_pembelian ?>";
                                                        }
                                                    }
                                                </script>
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