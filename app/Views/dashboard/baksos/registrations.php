<?= $this->extend('dashboard/layout/layout') ?>

<?= $this->section('title') ?>
Data Pendaftar Baksos
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
                    <h4 class="mb-sm-0">Data Pendaftar</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?= url_to('dashboard'); ?>"><?= lang('App.dashboard.title'); ?></a></li>
                            <li class="breadcrumb-item">Bakti Sosial</li>
                            <li class="breadcrumb-item active">Data Pendaftar</li>
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
                        <h5 class="card-title mb-0 flex-grow-1">Daftar Warga Terdaftar Baksos</h5>
                        <div class="flex-shrink-0 d-flex gap-2">
                            <select class="form-select form-select-sm w-auto" id="filter_service">
                                <option value="">Semua Layanan</option>
                                <?php foreach ($services as $service) : ?>
                                    <option value="<?= $service['id'] ?>"><?= esc($service['nama_pelayanan']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="button" class="btn btn-success btn-sm" id="btn-export" data-url="<?= url_to('admin-baksos-registrations-export'); ?>">
                                <i class="ri-file-excel-2-line align-bottom me-1"></i> Export Excel
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tb-data" class="table table-bordered table-striped align-middle" data-url="<?= url_to('admin-baksos-registrations-all'); ?>">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Lengkap</th>
                                        <th>NIK</th>
                                        <th>Umur</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Alamat</th>
                                        <th>No HP</th>
                                        <th>Layanan Baksos</th>
                                        <th>Waktu Daftar</th>
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
<?= $this->endSection() ?>

<?= $this->section('libScripts') ?>
<!--datatable js-->
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.js"></script>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script src="<?= base_url('/assets/js/pages/admin-baksos-registrations.init.js'); ?>"></script>
<?= $this->endSection() ?>