<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.login') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="card mt-4">

    <div class="card-body p-4">
        <div class="text-center mt-2">
            <h5 class="text-primary"><?= lang('App.auth.welcome'); ?></h5>
            <p class="text-muted">
                <?= lang('Auth.login') ?> <?= setting()->get('App.siteTitle', 'lang:' . service('request')->getLocale()); ?>.
            </p>
        </div>
        <div class="p-2 mt-4">

            <?php if (session('error') !== null) : ?>
                <div class="alert alert-danger" role="alert"><?= esc(session('error')) ?></div>
            <?php elseif (session('errors') !== null) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php if (is_array(session('errors'))) : ?>
                        <?php foreach (session('errors') as $error) : ?>
                            <?= esc($error) ?>
                            <br>
                        <?php endforeach ?>
                    <?php else : ?>
                        <?= esc(session('errors')) ?>
                    <?php endif ?>
                </div>
            <?php endif ?>

            <?php if (session('message') !== null) : ?>
                <div class="alert alert-success" role="alert"><?= esc(session('message')) ?></div>
            <?php endif ?>

            <form action="<?= url_to('login') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="username" class="form-label"><?= lang('Auth.username') ?></label>
                    <input type="text" class="form-control" id="username" name="username" inputmode="username" autocomplete="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" required>
                </div>

                <div class="mb-3">
                    <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
                        <div class="float-end">
                            <?= lang('Auth.forgotPassword') ?> <a href="<?= url_to('magic-link') ?>" class="text-muted"><?= lang('Auth.useMagicLink') ?></a>
                        </div>
                    <?php endif ?>
                    <label class="form-label" for="password-input"><?= lang('Auth.password') ?></label>
                    <div class="position-relative auth-pass-inputgroup mb-3">
                        <input type="password" class="form-control pe-5 password-input" id="password-input" name="password" inputmode="text" autocomplete="current-password" placeholder="<?= lang('Auth.password') ?>" required>
                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                    </div>
                </div>

                <?php if (setting('Auth.sessionConfig')['allowRemembering']) : ?>
                    <div class="form-check">
                        <input class="form-check-input" name="remember" type="checkbox" value="" id="auth-remember-check" <?php if (old('remember')) : ?> checked<?php endif ?>>
                        <label class="form-check-label" for="auth-remember-check">
                            <?= lang('Auth.rememberMe') ?>
                        </label>
                    </div>
                <?php endif; ?>

                <div class="mt-4">
                    <button class="btn btn-success w-100" type="submit"><?= lang('Auth.login') ?></button>
                </div>
            </form>
        </div>
    </div>
    <!-- end card body -->
</div>
<!-- end card -->

<?php if (setting('Auth.allowRegistration')) : ?>
    <div class="mt-4 text-center">
        <p class="mb-0">
            <?= lang('Auth.needAccount') ?> <a href="<?= url_to('register') ?>" class="fw-semibold text-primary text-decoration-underline">
                <?= lang('Auth.register') ?>
            </a>
        </p>
    </div>
<?php endif ?>
<?= $this->endSection() ?>