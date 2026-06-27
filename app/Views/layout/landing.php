<!doctype html>
<html lang="<?= service('request')->getLocale(); ?>" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <?php $title = $this->renderSection('title'); ?>
    <title><?= $title ? $title . ' | ' : '' ?><?= setting()->get('App.siteTitle', 'lang:' . service('request')->getLocale()); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="<?= setting()->get('App.siteDescription', 'lang:' . service('request')->getLocale()); ?>" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= setting()->get('App.siteIcon'); ?>">

    <!--Swiper slider css-->
    <link href="<?= base_url('assets/') ?>libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="<?= base_url('assets/') ?>js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="<?= base_url('assets/') ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url('assets/') ?>css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url('assets/') ?>css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="<?= base_url('assets/') ?>css/custom.min.css" rel="stylesheet" type="text/css" />
</head>

<body data-bs-spy="scroll" data-bs-target="#navbar-example">

    <!-- Begin page -->
    <div class="layout-wrapper landing">
        <nav class="navbar navbar-expand-lg navbar-landing fixed-top job-navbar" id="navbar">
            <div class="container-fluid custom-container">
                <a class="navbar-brand" href="<?= url_to('home') ?>">
                    <img src="<?= setting()->get('App.siteLogoDark'); ?>" class="card-logo card-logo-dark" alt="logo dark" height="35">
                    <img src="<?= setting()->get('App.siteLogoLight'); ?>" class="card-logo card-logo-light" alt="logo light" height="35">
                </a>
                <button class="navbar-toggler py-0 fs-20 text-body" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="mdi mdi-menu"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mt-2 mt-lg-0" id="navbar-example">
                        <li class="nav-item">
                            <a class="nav-link active" href="#hero">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#process">Tentang Kami</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#categories">Layanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#candidates">Fasilitas</a>
                        </li>
                    </ul>

                    <div class="">
                        <a href="<?= url_to('dashboard') ?>" class="btn btn-soft-primary"><i class="ri-user-3-line align-bottom me-1"></i> Dashboard</a>
                    </div>
                </div>
            </div>
        </nav>
        <!-- end navbar -->

        <?= $this->renderSection('content') ?>

        <!-- Start footer -->
        <footer class="custom-footer bg-dark py-5 position-relative">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mt-4">
                        <div>
                            <div>
                                <img src="<?= setting()->get('App.siteLogoLight'); ?>" alt="logo light" height="35" />
                            </div>
                            <div class="mt-4 fs-13">
                                <p><?= setting()->get('App.siteDescription', 'lang:' . service('request')->getLocale()); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7 ms-lg-auto">
                        <div class="row justify-content-end">
                                <div class="col-sm-4 mt-4">
                                    <h5 class="text-white mb-0">Menu Utama</h5>
                                    <div class="text-muted mt-3">
                                        <ul class="list-unstyled ff-secondary footer-list">
                                            <li><a href="<?= url_to('home') ?>">Beranda</a></li>
                                            <li><a href="<?= url_to('home') ?>#process">Tentang Kami</a></li>
                                            <li><a href="<?= url_to('home') ?>#categories">Layanan</a></li>
                                            <li><a href="<?= url_to('home') ?>#candidates">Fasilitas</a></li>
                                            <li><a href="<?= url_to('baksos') ?>">Pendaftaran Bakti Sosial</a></li>
                                        </ul>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

                <div class="row text-center text-sm-start align-items-center mt-5">
                    <div class="col-sm-6">
                        <div>
                            <p class="copy-rights mb-0">
                                <script> document.write(new Date().getFullYear()) </script> © <?= setting()->get('App.siteTitle', 'lang:' . service('request')->getLocale()); ?>.
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end mt-3 mt-sm-0">
                            <ul class="list-inline mb-0 footer-list gap-4 fs-13">
                                <li class="list-inline-item">
                                    Design & Develop by UMSURA
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end footer -->

        <!--start back-to-top-->
        <button onclick="topFunction()" class="btn btn-info btn-icon landing-back-top" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->

    </div>
    <!-- end layout wrapper -->

    <!-- JAVASCRIPT -->
    <script src="<?= base_url('assets/') ?>libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/') ?>libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url('assets/') ?>libs/node-waves/waves.min.js"></script>
    <script src="<?= base_url('assets/') ?>libs/feather-icons/feather.min.js"></script>
    <script src="<?= base_url('assets/') ?>js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="<?= base_url('assets/') ?>js/plugins.js"></script>

    <!--Swiper slider js-->
    <script src="<?= base_url('assets/') ?>libs/swiper/swiper-bundle.min.js"></script>

    <!--job landing init -->
    <script src="<?= base_url('assets/') ?>js/pages/job-lading.init.js"></script>
</body>

</html>