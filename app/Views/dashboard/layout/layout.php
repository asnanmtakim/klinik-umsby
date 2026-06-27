<!doctype html>
<html lang="<?= service('request')->getLocale(); ?>" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8">
    <title><?= $this->renderSection('title') ?> | <?= setting()->get('App.siteTitle', 'lang:' . service('request')->getLocale()); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="<?= setting()->get('App.siteDescription', 'lang:' . service('request')->getLocale()); ?>" name="description" />
    <meta content="Asnanmtakim" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= setting()->get('App.siteIcon'); ?>">

    <!-- Layout config Js -->
    <script src="/assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- Sweet Alert css-->
    <link href="<?= base_url('/assets/libs/sweetalert2/sweetalert2.min.css') ?>" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css" />

    <?= $this->renderSection('libStyles') ?>

    <!-- custom Css-->
    <link href="/assets/css/custom.css" rel="stylesheet" type="text/css" />

    <?= $this->renderSection('pageStyles') ?>
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?= $this->include('dashboard/layout/topbar') ?>

        <!-- ========== App Menu ========== -->
        <?= $this->include('dashboard/layout/sidebar') ?>
        <!-- Left Sidebar End -->

        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <div class="main-content">
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <?= $this->renderSection('main') ?>
            <!-- end main content-->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © <?= setting()->get('App.siteTitle', 'lang:' . service('request')->getLocale()); ?>.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Design & Develop by UMSURA
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- END layout-wrapper -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- Loading Ajax -->
    <div id="loading-ajax">
        <div id="status">
            <div class="spinner-border text-success avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <div class="customizer-setting d-none d-md-block d-print-none">
        <div class="btn-info rounded-pill shadow-lg btn btn-icon btn-lg p-2" data-bs-toggle="offcanvas" data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas">
            <i class='mdi mdi-spin mdi-cog-outline fs-22'></i>
        </div>
    </div>

    <!-- Theme Settings -->
    <?= $this->include('dashboard/layout/settings') ?>
    <script>
        var BASE_URL = '<?= base_url(); ?>';
        var LOCALE = '<?= service('request')->getLocale(); ?>';
        var successMessage = '<?= lang('App.dashboard.success'); ?>';
        var errorMessage = '<?= lang('App.dashboard.failed'); ?>';
        var csrfToken = '<?= csrf_token() ?>';
        var csrfHash = '<?= csrf_hash() ?>';
    </script>
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- JAVASCRIPT -->
    <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/assets/libs/node-waves/waves.min.js"></script>
    <script src="/assets/libs/feather-icons/feather.min.js"></script>
    <script src="/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="/assets/js/plugins.js"></script>
    <!-- Sweet Alerts js -->
    <script src="<?= base_url('/assets/libs/sweetalert2/sweetalert2.min.js') ?>"></script>

    <?= $this->renderSection('libScripts') ?>

    <!-- App js -->
    <script src="/assets/js/app.js"></script>

    <?= $this->renderSection('pageScripts') ?>
</body>

</html>