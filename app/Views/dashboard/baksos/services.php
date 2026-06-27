<?= $this->extend('dashboard/layout/layout') ?>

<?= $this->section('title') ?>
Manajemen Layanan Baksos
<?= $this->endSection() ?>

<?= $this->section('libStyles') ?>
<!--datatable css-->
<link href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.min.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Layanan & Kuota</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?= url_to('dashboard'); ?>"><?= lang('App.dashboard.title'); ?></a></li>
                            <li class="breadcrumb-item">Bakti Sosial</li>
                            <li class="breadcrumb-item active">Layanan & Kuota</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h5 class="card-title mb-0 flex-grow-1">Daftar Layanan Baksos</h5>
                        <div class="flex-shrink-0">
                            <button class="btn btn-sm btn-primary action-add" data-bs-toggle="modal" data-bs-target="#dataModal"><i class="ri-add-line fs-14 align-middle"></i> Tambah Layanan</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tb-data" class="table table-bordered table-striped align-middle" data-url="<?= url_to('admin-baksos-services-all'); ?>">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Layanan</th>
                                        <th>Total Kuota</th>
                                        <th>Sisa Kuota</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
    <!-- container-fluid -->
</div>

<!-- Modal manage data -->
<div class="modal zoomIn fade" id="dataModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-3 bg-info bg-opacity-25">
                <h5 class="modal-title" id="dataModalLabel">Tambah Layanan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('App.dashboard.close'); ?>"></button>
            </div>
            <form id="form-data" action="<?= url_to('admin-baksos-services-save'); ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="id" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="nama_pelayanan" class="form-label">Nama Layanan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_pelayanan" id="nama_pelayanan" placeholder="Masukkan nama layanan medis">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="kuota" class="form-label">Total Kuota <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="kuota" id="kuota" placeholder="Kapasitas kuota maksimal">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi Tambahan</label>
                                <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3" placeholder="Opsional: Keterangan tambahan mengenai layanan ini"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><?= lang('App.dashboard.save'); ?></button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal"><?= lang('App.dashboard.close'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('libScripts') ?>
<!--datatable js-->
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.js"></script>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script src="<?= base_url('/assets/js/pages/admin-baksos-services.init.js'); ?>"></script>
<?= $this->endSection() ?>