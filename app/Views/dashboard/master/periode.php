<?= $this->extend('dashboard/layout/layout') ?>

<?= $this->section('title') ?>
<?php $title = checkDataLang($route['name'], $route['name_en']); ?>
<?= $title; ?>
<?= $this->endSection() ?>

<?= $this->section('libStyles') ?>
<!--datatable css-->
<link href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.min.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('pageStyles') ?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0"><?= $title; ?></h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?= url_to('dashboard'); ?>"><?= lang('App.dashboard.title'); ?></a></li>
                            <li class="breadcrumb-item active"><?= $title; ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Manajemen Data Periode Wisuda</h5>
                        <div class="flex-shrink-0">
                            <button type="button" class="btn btn-success action-add" data-title="Tambah Periode Wisuda">
                                <i class="ri-add-line align-bottom me-1"></i> Tambah Periode
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mb-4">
                            <table class="table align-middle mb-0" id="periodeTable" data-url="<?= url_to('periode-all'); ?>">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Periode</th>
                                        <th>Semester</th>
                                        <th>Tanggal Pelaksanaan</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
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
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-3 bg-info bg-opacity-25">
                <h5 class="modal-title" id="dataModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('App.dashboard.close'); ?>"></button>
            </div>
            <form id="form-data" action="<?= url_to('periode-save'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="id" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="id_semester" class="form-label">Semester <span class="text-danger">*</span></label>
                                <select class="form-select" name="id_semester" id="id_semester">
                                    <option value="">Pilih Semester</option>
                                    <?php foreach ($semesters as $s) : ?>
                                        <option value="<?= $s->id ?>"><?= $s->nama_semester ?> <?= $s->tahun_semester ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="nama_periode" class="form-label">Nama Periode <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_periode" id="nama_periode" placeholder="Nama Periode">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" data-provider="flatpickr" data-date-format="d-m-Y" placeholder="Tanggal Pelaksanaan">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="waktu_mulai" class="form-label">Waktu Mulai <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" name="waktu_mulai" id="waktu_mulai">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="waktu_selesai" class="form-label">Waktu Selesai <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" name="waktu_selesai" id="waktu_selesai">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="tanggal_gladi" class="form-label">Tanggal Gladi Bersih <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tanggal_gladi" id="tanggal_gladi" data-provider="flatpickr" data-date-format="d-m-Y" placeholder="Tanggal Gladi">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="waktu_gladi" class="form-label">Waktu Gladi Bersih <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" name="waktu_gladi" id="waktu_gladi">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="lokasi" class="form-label">Lokasi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="lokasi" id="lokasi" placeholder="Lokasi">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="link_google_maps" class="form-label">Link Google Maps</label>
                                <input type="text" class="form-control" name="link_google_maps" id="link_google_maps" placeholder="Link Map">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="link_survey" class="form-label">Link Survey Kepuasan</label>
                                <input type="text" class="form-control" name="link_survey" id="link_survey" placeholder="Link Survey Kepuasan (Contoh: https://forms.gle/...)">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="tema_wisuda" class="form-label">Tema Wisuda</label>
                                <input type="text" class="form-control" name="tema_wisuda" id="tema_wisuda" placeholder="Tema Wisuda">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="makna_wisuda" class="form-label">Makna Wisuda</label>
                                <textarea class="form-control" name="makna_wisuda" id="makna_wisuda" rows="3" placeholder="Makna Wisuda"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="logo_wisuda" class="form-label">Logo Wisuda</label>
                                <input type="file" class="form-control" name="logo_wisuda" id="logo_wisuda" accept="image/*">
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
<script src="<?= base_url('/assets/js/pages/periode.init.js'); ?>"></script>
<?= $this->endSection() ?>