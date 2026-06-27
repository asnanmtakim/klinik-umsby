<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="<?= url_to('home'); ?>" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="<?= setting()->get('App.siteIcon'); ?>" alt="Logo" height="27">
                        </span>
                        <span class="logo-lg">
                            <img src="<?= setting()->get('App.siteLogoDark'); ?>" alt="" height="35">
                        </span>
                    </a>

                    <a href="<?= url_to('home'); ?>" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="<?= setting()->get('App.siteIcon'); ?>" alt="Logo" height="27">
                        </span>
                        <span class="logo-lg">
                            <img src="<?= setting()->get('App.siteLogoLight'); ?>" alt="" height="35">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->
                <form class="app-search d-none d-md-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="<?= lang('App.dashboard.search'); ?>..." autocomplete="off" id="search-options" value="">
                        <span class="mdi mdi-magnify search-widget-icon"></span>
                        <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" id="search-close-options"></span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                        <div data-simplebar style="max-height: 320px;">
                            <?php foreach ($siteMenus as $menu) : ?>
                                <?php if (checkPermission($menu['filter'], $menu['filter_value'])) : ?>
                                    <?php if ($menu['type'] == 'dashboard-title') : ?>
                                        <div class="dropdown-header mt-2">
                                            <h6 class="text-overflow text-muted mb-1 text-uppercase"><?= checkDataLang($menu['name'], $menu['name_en']); ?></h6>
                                        </div>
                                    <?php else : ?>
                                        <?php if (count($menu['child']) == 0) : ?>
                                            <a href="<?= cleanLink(url_to($menu['route'], $menu['params'])); ?>" class="dropdown-item notify-item">
                                                <i class="ri-bubble-chart-line align-middle fs-18 text-muted me-2"></i>
                                                <span><?= checkDataLang($menu['name'], $menu['name_en']); ?></span>
                                            </a>
                                        <?php else : ?>
                                            <?php foreach ($menu['child'] as $submenu) : ?>
                                                <?php if (checkPermission($submenu['filter'], $submenu['filter_value'])) : ?>
                                                    <?php if (count($submenu['child']) == 0) : ?>
                                                        <a href="<?= url_to($submenu['route'], $submenu['params']); ?>" class="dropdown-item notify-item">
                                                            <i class="ri-lifebuoy-line align-middle fs-18 text-muted me-2"></i>
                                                            <span><?= checkDataLang($submenu['name'], $submenu['name_en']); ?></span>
                                                        </a>
                                                    <?php else : ?>
                                                        <?php foreach ($submenu['child'] as $subsubmenu) : ?>
                                                            <?php if (checkPermission($subsubmenu['filter'], $subsubmenu['filter_value'])) : ?>
                                                                <a href="<?= url_to($subsubmenu['route'], $subsubmenu['params']); ?>" class="dropdown-item notify-item">
                                                                    <i class="ri-user-settings-line align-middle fs-18 text-muted me-2"></i>
                                                                    <span><?= checkDataLang($subsubmenu['name'], $subsubmenu['name_en']); ?></span>
                                                                </a>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex align-items-center">


                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="<?= checkImageUser(auth()->user()->avatar); ?>" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?= auth()->user()->username; ?></span>
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">
                                    <?php
                                    $groups = auth()->user()->getGroups();
                                    foreach ($groups as $group) {
                                        $groupsTitle[] = setting('AuthGroups.groups')[$group]['title'];
                                    }
                                    ?>
                                    <?= implode(', ', $groupsTitle); ?>
                                </span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header"><?= lang('App.auth.welcome'); ?> <?= formatFullName(auth()->user()->first_name, auth()->user()->last_name); ?></h6>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= url_to('logout'); ?>"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout"><?= lang('App.auth.logout'); ?></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- removeNotificationModal -->
<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('App.dashboard.close'); ?>" id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4><?= lang('App.dashboard.areYouSure'); ?></h4>
                        <p class="text-muted mx-4 mb-0"><?= lang('App.dashboard.removeNotification'); ?></p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal"><?= lang('App.dashboard.close'); ?></button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification" data-url="#"><?= lang('App.dashboard.deleteIt'); ?></button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->