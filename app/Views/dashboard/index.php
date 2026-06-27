<?= $this->extend('dashboard/layout/layout') ?>
<?= $this->section('title') ?>Dasbor<?= $this->endSection() ?>
<?= $this->section('main') ?>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Dasbor</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Menu Pengguna</a></li>
                            <li class="breadcrumb-item active">Dasbor</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-4 col-md-6">
                <!-- card -->
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Total Pendaftar Baksos</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?= esc($totalRegistrations) ?>">0</span></h4>
                                <a href="<?= url_to('admin-baksos-registrations') ?>" class="text-decoration-underline text-muted">Lihat Pendaftar</a>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-success-subtle rounded fs-3">
                                    <i class="ri-user-add-line text-success"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-4 col-md-6">
                <!-- card -->
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Layanan Aktif</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?= esc($totalServices) ?>">0</span></h4>
                                <a href="<?= url_to('admin-baksos-services') ?>" class="text-decoration-underline text-muted">Kelola Layanan</a>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-info-subtle rounded fs-3">
                                    <i class="ri-heart-pulse-line text-info"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-4 col-md-6">
                <!-- card -->
                <div class="card card-animate bg-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-white-50 text-truncate mb-0"> Kesiapan Kuota</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4 text-white"><span class="counter-value" data-target="<?= esc($kesiapanKuota) ?>">0</span>%</h4>
                                <a href="<?= url_to('admin-baksos-services') ?>" class="text-decoration-underline text-white-50">Cek Status Kuota</a>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-white bg-opacity-25 rounded fs-3">
                                    <i class="ri-pie-chart-line text-white"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->

        <!-- Greeting Section -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-4 text-center">
                        <div class="avatar-md mx-auto mb-4">
                            <div class="avatar-title bg-light text-primary rounded-circle fs-24">
                                <i class="ri-hospital-line"></i>
                            </div>
                        </div>
                        <h4 class="fw-semibold">Selamat Datang di Sistem Manajemen Baksos</h4>
                        <p class="text-muted mb-4">Pantau antrean, perbarui ketersediaan kuota, dan kelola data pendaftar klinik secara *real-time* di dasbor Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
