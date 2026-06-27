<?= $this->extend('layout/landing') ?>
<?= $this->section('title') ?>Beranda<?= $this->endSection() ?>
<?= $this->section('content') ?>
<!-- start hero section -->
<section class="section job-hero-section bg-light pb-0" id="hero">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6">
                <div>
                    <h1 class="display-6 fw-semibold text-capitalize mb-3 lh-base">Selamat Datang di <span class="text-primary">Klinik Pratama</span> Rawat Inap UMSURA</h1>
                    <p class="lead text-muted lh-base mb-4">Melayani dengan hati, mengutamakan kesehatan Anda. Ikuti kegiatan Bakti Sosial gratis dalam rangka Grand Launching kami!</p>
                    <div class="mt-4">
                        <a href="<?= url_to('baksos') ?>" class="btn btn-primary btn-lg">Daftar Bakti Sosial <i class="ri-arrow-right-line align-bottom ms-1"></i></a>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-5">
                <div class="position-relative home-img text-center mt-5 mt-lg-0">
                    <img src="<?= base_url('assets/') ?>images/job-profile2.png" alt="" class="user-img">
                    <div class="circle-effect">
                        <div class="circle"></div>
                        <div class="circle2"></div>
                        <div class="circle3"></div>
                        <div class="circle4"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</section>
<!-- end hero section -->

<!-- start about section -->
<section class="section" id="process">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h1 class="mb-3 ff-secondary fw-semibold text-capitalize lh-base">Tentang <span class="text-primary">Kami</span></h1>
                    <p class="text-muted">Klinik Pratama Rawat Inap UMSURA adalah fasilitas layanan kesehatan yang didedikasikan untuk memberikan pelayanan medis berkualitas, terjangkau, dan profesional bagi masyarakat umum dan civitas akademika.</p>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!--end row-->
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-none border-0 mb-0">
                    <div class="card-body">
                        <div class="avatar-sm rounded avatar-title bg-success-subtle text-success mb-4 fs-20">
                            <i class="ri-heart-pulse-line"></i>
                        </div>
                        <h5 class="fs-18">Pelayanan Prima</h5>
                        <p class="text-muted mb-0">Kami selalu mengutamakan keramahan, kecepatan, dan kenyamanan pasien dalam setiap prosedur medis.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-none border-0 mb-0">
                    <div class="card-body">
                        <div class="avatar-sm rounded avatar-title bg-warning-subtle text-warning mb-4 fs-20">
                            <i class="ri-hospital-line"></i>
                        </div>
                        <h5 class="fs-18">Fasilitas Memadai</h5>
                        <p class="text-muted mb-0">Didukung oleh peralatan medis yang modern dan bersih untuk menunjang akurasi diagnosa.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-none border-0 mb-0">
                    <div class="card-body">
                        <div class="avatar-sm rounded avatar-title bg-info-subtle text-info mb-4 fs-20">
                            <i class="ri-user-star-line"></i>
                        </div>
                        <h5 class="fs-18">Tenaga Ahli</h5>
                        <p class="text-muted mb-0">Ditangani oleh dokter dan tenaga medis profesional yang tersertifikasi dan berpengalaman di bidangnya.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end container -->
</section>
<!-- end about section -->

<!-- start services section -->
<section class="section bg-light" id="categories">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="text-center mb-5">
                    <h1 class="mb-3 ff-secondary fw-semibold text-capitalize lh-base">Layanan <span class="text-primary">Klinik</span></h1>
                    <p class="text-muted">Klinik kami menyediakan berbagai layanan kesehatan dasar hingga pemeriksaan khusus untuk memastikan kondisi optimal Anda.</p>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-none text-center py-3">
                    <div class="card-body py-4">
                        <div class="avatar-sm position-relative mb-4 mx-auto">
                            <div class="job-icon-effect"></div>
                            <div class="avatar-title bg-transparent text-primary rounded-circle">
                                <i class="ri-stethoscope-line fs-1"></i>
                            </div>
                        </div>
                        <a href="#!" class="stretched-link">
                            <h5 class="fs-17 pt-1">Poli Umum</h5>
                        </a>
                        <p class="mb-0 text-muted">Konsultasi & Pemeriksaan Medis</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-none text-center py-3">
                    <div class="card-body py-4">
                        <div class="avatar-sm position-relative mb-4 mx-auto">
                            <div class="job-icon-effect"></div>
                            <div class="avatar-title bg-transparent text-primary rounded-circle">
                                <i class="ri-tooth-line fs-1"></i>
                            </div>
                        </div>
                        <a href="#!" class="stretched-link">
                            <h5 class="fs-17 pt-1">Poli Gigi</h5>
                        </a>
                        <p class="mb-0 text-muted">Pemeriksaan & Tindakan Gigi</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-none text-center py-3">
                    <div class="card-body py-4">
                        <div class="avatar-sm position-relative mb-4 mx-auto">
                            <div class="job-icon-effect"></div>
                            <div class="avatar-title bg-transparent text-primary rounded-circle">
                                <i class="ri-microscope-line fs-1"></i>
                            </div>
                        </div>
                        <a href="#!" class="stretched-link">
                            <h5 class="fs-17 pt-1">Laboratorium</h5>
                        </a>
                        <p class="mb-0 text-muted">Cek Darah & Tes Diagnostik</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-none text-center py-3">
                    <div class="card-body py-4">
                        <div class="avatar-sm position-relative mb-4 mx-auto">
                            <div class="job-icon-effect"></div>
                            <div class="avatar-title bg-transparent text-primary rounded-circle">
                                <i class="ri-heart-pulse-line fs-1"></i>
                            </div>
                        </div>
                        <a href="#!" class="stretched-link">
                            <h5 class="fs-17 pt-1">Poli KIA & KB</h5>
                        </a>
                        <p class="mb-0 text-muted">Kesehatan Ibu & Anak</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-none text-center py-3">
                    <div class="card-body py-4">
                        <div class="avatar-sm position-relative mb-4 mx-auto">
                            <div class="job-icon-effect"></div>
                            <div class="avatar-title bg-transparent text-primary rounded-circle">
                                <i class="ri-capsule-line fs-1"></i>
                            </div>
                        </div>
                        <a href="#!" class="stretched-link">
                            <h5 class="fs-17 pt-1">Instalasi Farmasi</h5>
                        </a>
                        <p class="mb-0 text-muted">Apotek & Obat-obatan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end container -->
</section>
<!-- end services section -->

<!-- start facilities section -->
<section class="section" id="candidates">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-5">
                <div class="mt-4 mt-lg-0">
                    <img src="<?= base_url('assets/') ?>images/about.jpg" alt="Klinik Facilities" class="img-fluid rounded shadow-lg">
                </div>
            </div>
            <div class="col-lg-6">
                <div>
                    <h2 class="mb-3 ff-secondary fw-semibold text-capitalize">Fasilitas <span class="text-primary">Unggulan</span></h2>
                    <p class="text-muted mb-4">Kami merancang klinik ini dengan memperhatikan kenyamanan dan aksesibilitas bagi pasien. Berikut beberapa fasilitas unggulan yang kami miliki:</p>
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-xs flex-shrink-0 me-3">
                            <div class="avatar-title bg-success-subtle text-success rounded-circle">
                                <i class="ri-check-line"></i>
                            </div>
                        </div>
                        <h5 class="fs-15 mb-0">Ruang Inap Nyaman & Bersih</h5>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-xs flex-shrink-0 me-3">
                            <div class="avatar-title bg-success-subtle text-success rounded-circle">
                                <i class="ri-check-line"></i>
                            </div>
                        </div>
                        <h5 class="fs-15 mb-0">Ambulans 24 Jam Siaga</h5>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-xs flex-shrink-0 me-3">
                            <div class="avatar-title bg-success-subtle text-success rounded-circle">
                                <i class="ri-check-line"></i>
                            </div>
                        </div>
                        <h5 class="fs-15 mb-0">Sistem Pendaftaran Digital (Antrian Cepat)</h5>
                    </div>
                    <div class="d-flex align-items-center mb-4">
                        <div class="avatar-xs flex-shrink-0 me-3">
                            <div class="avatar-title bg-success-subtle text-success rounded-circle">
                                <i class="ri-check-line"></i>
                            </div>
                        </div>
                        <h5 class="fs-15 mb-0">Kawasan Parkir Luas & Aman</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end container -->
</section>
<!-- end facilities section -->

<!-- start contact section -->
<section class="py-5 bg-primary position-relative">
    <div class="bg-overlay bg-overlay-pattern opacity-50"></div>
    <div class="container">
        <div class="row align-items-center gy-4">
            <div class="col-sm">
                <div>
                    <h4 class="text-white mb-2 text-capitalize">Butuh Layanan Darurat atau Informasi Lebih Lanjut?</h4>
                    <p class="text-white-50 mb-0">Tim medis kami siap melayani Anda. Hubungi nomor kontak kami untuk pendaftaran rawat jalan atau info layanan in-patient.</p>
                </div>
            </div>
            <!-- end col -->
            <div class="col-sm-auto">
                <div>
                    <a href="<?= setting('App.siteWhatsapp') ?>" target="_blank" class="btn btn-danger btn-lg"><i class="ri-whatsapp-line align-middle me-2"></i> Hubungi WhatsApp</a>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</section>
<!-- end contact section -->

<?= $this->endSection() ?>