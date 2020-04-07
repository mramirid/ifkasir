<div class="container-fluid">
    <div class="card-group">
        <div class="card border-right">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <div class="d-inline-flex align-items-center">
                            <h2 class="text-dark mb-1 font-weight-medium"><?= $jumlah_barang ?></h2>
                        </div>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">All Menu</h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i class="fas fa-box"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-right">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium">
                            <?php
                            if ($jumlah_total_barang) echo $jumlah_total_barang;
                            else echo "0"
                            ?>
                        </h2>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">All Stock Inventory</h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i class="fas fa-boxes"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-right">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <div class="d-inline-flex align-items-center">
                            <h2 class="text-dark mb-1 font-weight-medium">
                                <?php
                                if ($jumlah_pegawai) echo $jumlah_pegawai;
                                else echo "0"
                                ?>
                            </h2>
                        </div>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Show Employees</h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="users"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <h2 class="text-dark mb-1 font-weight-medium">
                            <?php
                            if ($kerugian) echo $kerugian;
                            else echo "0"
                            ?>
                        </h2>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Item losses</h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="dollar-sign"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm">
                            <h4 class="card-title">Data Pembelian</h4>
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-success badge" data-toggle="modal" data-target="#add_beli">
                                Tambah Pembelian
                            </button>

                            <div class="modal fade" id="add_beli" tabindex="-1" role="dialog" aria-labelledby="add_beliLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="add_beliLabel">Tambah Barang</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <form role="form" action="<?= base_url() ?>inv/add_pembelian/" method="post">
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>Date Created</label>
                                                        <input type="name" name="date" class="form-control" value="<?= date('Y-m-d H:i:s') ?>" readonly>
                                                        <label>Nama Toko</label>
                                                        <input type="name" name="nama_toko" class="form-control" placeholder="Nama Toko" autocomplete="off" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" name="add_pembelian" class="btn btn-primary">Lanjutkan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="tabel_pembelian" class="table table-striped table-bordered no-wrap">
                            <thead>
                                <tr>
                                    <th>Waktu Pembelian</th>
                                    <th>Nama User</th>
                                    <th>Nama Toko</th>
                                    <th>Banyak Barang</th>
                                    <th>Total Harga</th>
                                    <th>Settings</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Waktu Pembelian</th>
                                    <th>Nama User</th>
                                    <th>Nama Toko</th>
                                    <th>Banyak Barang</th>
                                    <th>Total Harga</th>
                                    <th>Settings</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($list_pembelian->result() as $row) { ?>
                                    <tr>
                                        <td><?= $row->waktu_pembelian ?></td>
                                        <td><?= $row->nama ?></td>
                                        <td><?= $row->nama_toko ?></td>
                                        <td><?= $row->banyak_barang ?></td>
                                        <td><?= $row->total_harga ?></td>
                                        <?php if ($this->session->userdata('role') == 'admin' || $this->session->userdata('nama') == $row->nama) { ?>
                                            <td class="text-center">
                                                <a href="<?= base_url() . 'inv/set_status/' . $row->id_pembelian ?>" class="btn btn-dark badge">Set <?php if ($row->status == 1) echo "Belum"; ?> Selesai</a><br>
                                                <?php if ($row->status == 1) { ?>
                                                    <a href="<?= base_url() . 'InvLoss/set_rugi/' . $row->id_pembelian ?>" class="btn btn-warning badge">Set Rugi</a><br>
                                                <?php } ?>
                                                <a href="<?= base_url() . 'inv/buy/' . $row->id_pembelian ?>" class="btn btn-<?php if ($row->status == 1) echo "success";
                                                                                                                                else echo "primary"; ?> badge"><?php if ($row->status == 1) echo "Lihat";
                                                                                                                                                                else echo "Edit"; ?></a>
                                                <?php if ($row->status != 1) { ?>
                                                    <a href="#" onclick="del_beli<?= $row->id_pembelian ?>()" class="btn btn-danger badge">Delete</a>
                                                <?php } ?>
                                                <script>
                                                    function del_beli<?= $row->id_pembelian ?>() {
                                                        var txt;
                                                        if (confirm("Anda yakin ingin mendelete data ini?")) {
                                                            window.location = "<?= base_url() . 'inv/delete_pembelian/' . $row->id_pembelian ?>";
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm">
                            <h4 class="card-title">Data Barang</h4>
                        </div>
                        <?php if ($this->session->userdata('role') == 'admin') { ?>
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

                                            <form role="form" action="<?= base_url() ?>inv/add_barang/" method="post">
                                                <div class="modal-body">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label>Nama Barang</label>
                                                            <input type="name" name="nama_barang" class="form-control" placeholder="Nama Barang" autocomplete="off" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Jumlah Barang</label>
                                                            <input type="number" name="jumlah_barang" class="form-control" placeholder="Jumlah Barang" autocomplete="off" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Harga Barang</label>
                                                            <input type="number" name="harga_barang" class="form-control" placeholder="Harga Barang" autocomplete="off" required>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="jenis_makanan" value="makanan" checked>
                                                            <label class="form-check-label">Makanan</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="jenis_makanan" value="minuman">
                                                            <label class="form-check-label">Minuman</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="add_barang" class="btn btn-primary">Tambah Barang</button>
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
                                    <th>Jenis Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah Barang</th>
                                    <th>Harga Jual</th>
                                    <?php if ($this->session->userdata('role') == 'admin') echo "<th>Settings</th>" ?>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah Barang</th>
                                    <th>Harga Jual</th>
                                    <?php if ($this->session->userdata('role') == 'admin') echo "<th>Settings</th>" ?>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($list_barang->result() as $row) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row->tipe_barang ?></td>
                                        <td><?= $row->nama_barang ?></td>
                                        <td><?= $row->qty_inventory ?></td>
                                        <td><?= $row->harga_jual ?></td>

                                        <?php if ($this->session->userdata('role') == 'admin') { ?>
                                            <td>

                                                <button type="button" class="btn btn-primary badge" data-toggle="modal" data-target="#edit_barang<?= $row->id_barang ?>">
                                                    Edit
                                                </button>

                                                <div class="modal fade" id="edit_barang<?= $row->id_barang ?>" tabindex="-1" role="dialog" aria-labelledby="edit_barangLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="edit_barangLabel">Edit Data</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <form role="form" action="<?= base_url() . 'inv/edit_barang/' . $row->id_barang ?>" method="post">
                                                                <div class="modal-body">
                                                                    <div class="card-body">
                                                                        <div class="form-group">
                                                                            <label>Nama Barang</label>
                                                                            <input type="name" name="nama_barang" class="form-control" value="<?= $row->nama_barang ?>" autocomplete="off" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Jumlah Barang</label>
                                                                            <input type="number" name="jumlah_barang" class="form-control" value="<?= $row->qty_inventory ?>" autocomplete="off" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Harga Barang</label>
                                                                            <input type="number" name="harga_barang" class="form-control" value="<?= $row->harga_jual ?>" autocomplete="off" required>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio" name="jenis_makanan" value="makanan" <?php if ($row->tipe_barang == "makanan") echo "checked"; ?>>
                                                                            <label class="form-check-label">Makanan</label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio" name="jenis_makanan" value="minuman" <?php if ($row->tipe_barang == "minuman") echo "checked"; ?>>
                                                                            <label class="form-check-label">Minuman</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" name="add_menu" class="btn btn-primary">Edit Data</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <a href="#" onclick="del_barang<?= $row->id_barang ?>()" class="btn btn-danger badge">Delete</a>
                                                <script>
                                                    function del_barang<?= $row->id_barang ?>() {
                                                        var txt;
                                                        if (confirm("Anda yakin ingin mendelete data ini?")) {
                                                            window.location = "<?= base_url() . 'inv/delete_barang/' . $row->id_barang ?>";
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