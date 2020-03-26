<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">

    <?php $this->load->view('layouts/_alert') ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Formulir Edit Data <?= $input->nama ?></h4>
                    <form action="<?= base_url("users/edit/$input->id_user") ?>" method="POST">
                        <?= form_hidden('id_user', $input->id_user) ?>
                        <div class="form-body">
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2">Nama Lengkap</label>
                                    <div class="col-lg-10">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="nama"><i class="fas fa-user"></i></label>
                                                    </div>
                                                    <?= form_input('nama', $input->nama, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Bukan nama panggilan']) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-12">
                                                <?= form_error('nama') ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2">E-mail</label>
                                    <div class="col-lg-10">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="email"><i class="fas fa-at"></i></label>
                                                    </div>
                                                    <?= form_input(['type' => 'email', 'name' => 'email', 'value' => $input->email, 'class' => 'form-control', 'placeholder' => 'Masukan alamat email aktif', 'required' => true]) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-12">
                                                <?= form_error('email') ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2">Password</label>
                                    <div class="col-lg-10">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="password"><i class="fas fa-key"></i></label>
                                                    </div>
                                                    <?= form_password('password', '', ['class' => 'form-control', 'placeholder' => 'Password minimal 4 karakter']) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-12">
                                                <?= form_error('password') ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2">Nomor Telefon</label>
                                    <div class="col-lg-10">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="telefon"><i class="fas fa-phone"></i></label>
                                                    </div>
                                                    <?= form_input('telefon', $input->telefon, ['class' => 'form-control', 'placeholder' => 'Masukan nomor telefon aktif', 'required' => true]) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-12">
                                                <?= form_error('telefon') ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2">Nomor KTP</label>
                                    <div class="col-lg-10">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="ktp"><i class="fas fa-address-card"></i></label>
                                                    </div>
                                                    <?= form_input('ktp', $input->ktp, ['class' => 'form-control', 'placeholder' => 'Masukan nomor ktp aktif', 'required' => true]) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-12">
                                                <?= form_error('ktp') ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2">Role</label>
                                    <div class="col-lg-10">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="role-options"><i class="fas fa-edit"></i></label>
                                                    </div>
                                                    <select class="form-control" name="role" id="role-options">
                                                        <option value="admin" <?= $input->role == 'admin' ? 'selected' : '' ?>>Admin</option>
                                                        <option value="kasir" <?= $input->role == 'kasir' ? 'selected' : '' ?>>Kasir</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2">Status Akun</label>
                                    <div class="col-lg-10">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="status-options"><i class="fas fa-user-times"></i></label>
                                                    </div>
                                                    <select class="form-control" name="status" id="status-options">
                                                        <option value="aktif" <?= $input->status == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                                        <option value="non-aktif" <?= $input->status == 'non-aktif' ? 'selected' : '' ?>>Non-Aktif</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="text-right">
                                <button type="submit" class="btn btn-info">Update</button>
                                <a href="<?= base_url('users') ?>" class="btn btn-dark">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->