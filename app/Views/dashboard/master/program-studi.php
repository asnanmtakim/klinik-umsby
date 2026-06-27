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
                    <div class="card-header align-items-center d-flex">
                        <h5 class="card-title mb-0 flex-grow-1"><?= $title; ?></h5>
                        <?php if (auth()->user()->can('admin.master.manage')): ?>
                            <div class="flex-shrink-0">
                                <button class="btn btn-sm btn-success action-sync" data-url="<?= url_to('master-program-studi-sync'); ?>"><i class="ri-refresh-line fs-14 align-middle"></i> Sinkronisasi Data</button>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-3 col-lg-3 mb-3">
                                <label for="select_fakultas">Fakultas</label>
                                <select class="form-control" data-choices id="select_fakultas">
                                    <option value="" selected>Semua Fakultas</option>
                                    <?php foreach ($fakultas as $row) : ?>
                                        <option value="<?= $row->id; ?>"><?= $row->nama_fakultas; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <hr class="mt-0">
                        <div class="table-responsive">
                            <table id="tb-data" class="table table-bordered table-striped align-middle" data-url="<?= url_to('master-program-studi-all'); ?>">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Jenjang</th>
                                        <th>Nama Program Studi</th>
                                        <th>Fakultas</th>
                                        <th>Urutan Kursi</th>
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
                <h5 class="modal-title" id="dataModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('App.dashboard.close'); ?>"></button>
            </div>
            <form id="form-data" action="<?= url_to('master-program-studi-save'); ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="id" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="id_fakultas" class="form-label">Fakultas <span class="text-danger">*</span></label>
                                <select class="form-control" name="id_fakultas" id="id_fakultas">
                                    <option value="">Pilih Fakultas</option>
                                    <?php foreach ($fakultas as $row) : ?>
                                        <option value="<?= $row->id; ?>"><?= $row->nama_fakultas; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="nama_program_studi" class="form-label">Nama Program Studi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_program_studi" id="nama_program_studi" placeholder="Nama Program Studi">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="level_program_studi" class="form-label">Jenjang <span class="text-danger">*</span></label>
                                <select class="form-control" name="level_program_studi" id="level_program_studi">
                                    <option value="">Pilih Jenjang</option>
                                    <option value="Profesi">Profesi</option>
                                    <option value="D3">D3</option>
                                    <option value="D4">D4</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                    <option value="Sp1">Sp1</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="urutan_kursi" class="form-label">Urutan Kursi</label>
                                <input type="number" class="form-control" name="urutan_kursi" id="urutan_kursi" placeholder="Urutan Kursi">
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
<script src="<?= base_url('/assets/js/pages/master-program-studi.init.js'); ?>"></script>
<?= $this->endSection() ?>