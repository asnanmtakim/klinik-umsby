<?= $this->extend('dashboard/layout/layout') ?>

<?= $this->section('title') ?>
Manajemen Dokumentasi Wisuda
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
                    <h4 class="mb-sm-0">Manajemen Dokumentasi Wisuda</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?= url_to('dashboard'); ?>"><?= lang('App.dashboard.title'); ?></a></li>
                            <li class="breadcrumb-item active">Dokumentasi Wisuda</li>
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
                        <h5 class="card-title mb-0 flex-grow-1">Data Tautan Dokumentasi</h5>
                        <div class="flex-shrink-0">
                            <button type="button" class="btn btn-success action-add" data-title="Tambah Tautan Dokumentasi">
                                <i class="ri-add-line align-bottom me-1"></i> Tambah Link
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-3">
                                <label for="select_periode">Filter Periode</label>
                                <select class="form-control" data-choices id="select_periode">
                                    <option value="">Semua Periode</option>
                                    <?php foreach ($periodes as $p) : ?>
                                        <option value="<?= $p->id ?>" <?= $p->status == 'aktif' ? 'selected' : '' ?>><?= $p->nama_periode ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <hr class="mt-0">
                        <div class="table-responsive mb-4">
                            <table class="table align-middle mb-0" id="dokumentasiTable" data-url="<?= url_to('dokumentasi-all'); ?>">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Periode</th>
                                        <th>Nama Tautan</th>
                                        <th>Link URL</th>
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
            <form id="form-data" action="<?= url_to('dokumentasi-save'); ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="id" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="id_periode" class="form-label">Periode Wisuda <span class="text-danger">*</span></label>
                                <select class="form-select" name="id_periode" id="id_periode">
                                    <option value="">Pilih Periode</option>
                                    <?php foreach ($periodes as $p) : ?>
                                        <option value="<?= $p->id ?>"><?= $p->tahun_semester ?> - <?= $p->nama_periode ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="nama_dokumentasi" class="form-label">Nama Tautan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_dokumentasi" id="nama_dokumentasi" placeholder="Misal: Dokumentasi Sesi 1" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="link_url" class="form-label">Link Google Drive / URL <span class="text-danger">*</span></label>
                                <input type="url" class="form-control" name="link_url" id="link_url" placeholder="https://drive.google.com/..." required>
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
<script src="<?= base_url('/assets/js/pages/dokumentasi.init.js'); ?>"></script>
<?= $this->endSection() ?>
