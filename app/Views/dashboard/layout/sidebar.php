<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="<?= url_to('home'); ?>" class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?= setting()->get('App.siteIcon'); ?>" alt="Logo" height="27">
            </span>
            <span class="logo-lg">
                <img src="<?= setting()->get('App.siteLogoDark'); ?>" alt="Logo" height="35">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="<?= url_to('home'); ?>" class="logo logo-light">
            <span class="logo-sm">
                <img src="<?= setting()->get('App.siteIcon'); ?>" alt="Logo" height="27">
            </span>
            <span class="logo-lg">
                <img src="<?= setting()->get('App.siteLogoLight'); ?>" alt="Logo" height="35">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <?php foreach ($siteMenus as $menu) : ?>
                    <?php if (checkPermission($menu['filter'], $menu['filter_value'])) : ?>
                        <?php if ($menu['type'] == 'dashboard-title') : ?>
                            <li class="menu-title"><span data-key="t-<?= slugify($menu['name']); ?>"><?= checkDataLang($menu['name'], $menu['name_en']); ?></span></li>
                        <?php else : ?>
                            <?php if (count($menu['child']) == 0) : ?>
                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="<?= cleanLink(url_to($menu['route'], $menu['params'])); ?>">
                                        <i class="<?= $menu['icon']; ?>"></i>
                                        <span data-key="t-<?= slugify($menu['name']); ?>"><?= checkDataLang($menu['name'], $menu['name_en']); ?></span>
                                    </a>
                                </li>
                            <?php else : ?>
                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="#sidebar-<?= slugify($menu['name']); ?>" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-<?= slugify($menu['name']); ?>">
                                        <i class="<?= $menu['icon']; ?>"></i> <span data-key="t-<?= slugify($menu['name']); ?>"><?= checkDataLang($menu['name'], $menu['name_en']); ?></span>
                                    </a>
                                    <div class="collapse menu-dropdown" id="sidebar-<?= slugify($menu['name']); ?>">
                                        <ul class="nav nav-sm flex-column">
                                            <?php foreach ($menu['child'] as $submenu) : ?>
                                                <?php if (checkPermission($submenu['filter'], $submenu['filter_value'])) : ?>
                                                    <?php if (count($submenu['child']) == 0) : ?>
                                                        <li class="nav-item">
                                                            <a href="<?= cleanLink(url_to($submenu['route'], $submenu['params'])); ?>" class="nav-link" data-key="t-<?= slugify($submenu['name']); ?>"><?= checkDataLang($submenu['name'], $submenu['name_en']); ?></a>
                                                        </li>
                                                    <?php else : ?>
                                                        <li class="nav-item">
                                                            <a href="#sidebar-<?= slugify($submenu['name']); ?>" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-<?= slugify($submenu['name']); ?>" data-key="t-<?= slugify($submenu['name']); ?>"><?= checkDataLang($submenu['name'], $submenu['name_en']); ?></a>
                                                            <div class="collapse menu-dropdown" id="sidebar-<?= slugify($submenu['name']); ?>">
                                                                <ul class="nav nav-sm flex-column">
                                                                    <?php foreach ($submenu['child'] as $subsubmenu) : ?>
                                                                        <?php if (checkPermission($subsubmenu['filter'], $subsubmenu['filter_value'])) : ?>
                                                                            <li class="nav-item">
                                                                                <a href="<?= cleanLink(url_to($subsubmenu['route'], $subsubmenu['params'])); ?>" class="nav-link" data-key="t-<?= slugify($subsubmenu['name']); ?>"><?= checkDataLang($subsubmenu['name'], $subsubmenu['name_en']); ?></a>
                                                                            </li>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>