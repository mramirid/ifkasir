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
                        <h4 class="card-title">List Karyawan</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table no-wrap v-middle mb-0">
                            <thead>
                                <tr class="border-0">
                                    <th class="border-0 font-14 font-weight-medium text-muted">Nama</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted px-2">Email</th>
                                    <!-- Hanya admin yang boleh liat KTP -->
                                    <?php if ($this->session->userdata('role') == 'admin') : ?>
                                        <th class="border-0 font-14 font-weight-medium text-muted">KTP</th>
                                    <?php endif ?>
                                    <th class="border-0 font-14 font-weight-medium text-muted">Role</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">Status</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">Telefon</th>
                                    <!-- Hanya admin yang boleh edit -->
                                    <?php if ($this->session->userdata('role') == 'admin') : ?>
                                        <th class="border-0 font-14 font-weight-medium text-muted text-center"></th>
                                    <?php endif ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($content as $row) : ?>
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
                                        <!-- Hanya admin yang boleh melakukan aksi pada data -->
                                        <?php if ($this->session->userdata('role') == 'admin') : ?>
                                            <td class="border-top-0 text-center text-muted px-2 py-4">
                                                <?= form_open(base_url("user/delete"), ['method' => 'POST']) ?>
                                                    <?= form_hidden('id', $row->id_user) ?>
                                                    <a href="<?= base_url("user/edit/$row->id_user") ?>" class="btn btn-sm">
                                                        <i class="fas fa-edit text-info"></i>
                                                    </a>
                                                    <button type="submit" class="btn btn-sm" onclick="return confirm('Apakah yakin ingin menghapus?')">
                                                        <i class="fas fa-trash text-danger"></i>
                                                    </button>
                                                <?= form_close() ?>
                                            </td>
                                        <?php endif ?>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>

                        <div class="row d-flex justify-content-center">
                            <nav aria-label="Page navigation example">
                                <?= $pagination ?>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->