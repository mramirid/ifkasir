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
                                    <?php if ($this->session->userdata('role') == 'admin') : ?>
                                        <th class="border-0 font-14 font-weight-medium text-muted">KTP</th>
                                    <?php endif ?>
                                    <th class="border-0 font-14 font-weight-medium text-muted">Role</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">Status</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">Telefon</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($content as $row) : ?>
                                    <tr>
                                        <td class="border-top-0 px-2 py-4">
                                            <h5 class="text-dark mb-0 font-16 font-weight-medium"><?= $row->nama ?></h5>
                                        </td>
                                        <td class="border-top-0 text-muted px-2 py-4 font-14"><?= $row->email ?></td>
                                        <?php if ($this->session->userdata('role') == 'admin') : ?>
                                            <td class="border-top-0 text-muted px-2 py-4 font-14"><?= $row->ktp ?></td>
                                        <?php endif ?>
                                        <td class="border-top-0 px-2 py-4">
                                            <?php if ($row->role == 'admin') : ?>
                                                <div class="popover-icon">
                                                    <button class="btn btn-primary rounded-circle btn-circle font-12" data-toggle="tooltip" data-placement="top" title="Administrator">ADM</button>
                                                    <button class="btn btn-cyan rounded-circle btn-circle font-12 popover-item" data-toggle="tooltip" data-placement="top" title="Kasir">KSR</button>
                                                </div>
                                            <?php else : ?>
                                                <div class="popover-icon">
                                                    <button class="btn btn-white rounded-circle btn-circle font-12"></button>
                                                    <button class="btn btn-cyan rounded-circle btn-circle font-12 popover-item" data-toggle="tooltip" data-placement="top" title="Kasir">KSR</button>
                                                </div>
                                            <?php endif ?>
                                        </td>
                                        <td class="border-top-0 text-center px-2 py-4">
                                            <?php if ($row->status == 'aktif') : ?>
                                                <i class="fa fa-circle text-success font-12" data-toggle="tooltip" data-placement="top" title="Karyawan Aktif"></i>
                                            <?php else : ?>
                                                <i class="fa fa-circle text-danger font-12" data-toggle="tooltip" data-placement="top" title="Karyawan Non-Aktif"></i>
                                            <?php endif ?>
                                        </td>
                                        <td class="border-top-0 text-center text-muted px-2 py-4"><?= $row->telefon ?></td>
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