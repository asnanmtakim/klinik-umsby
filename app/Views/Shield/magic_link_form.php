<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.useMagicLink') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="card mt-4">

    <div class="card-body p-4">
        <div class="text-center mt-2">
            <h5 class="text-primary"><?= lang('Auth.useMagicLink') ?></h5>
            <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop" colors="primary:#0ab39c" class="avatar-xl"></lord-icon>
        </div>

        <div class="alert border-0 alert-warning text-center mb-2 mx-2" role="alert">
            Enter your email and link login will be sent to you!
        </div>
        <div class="p-2">

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

            <form action="<?= url_to('magic-link') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-4">
                    <label class="form-label" for="email"><?= lang('Auth.email') ?></label>
                    <input type="email" class="form-control" id="email" name="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email', auth()->user()->email ?? null) ?>" required>
                </div>

                <div class="text-center mt-4">
                    <button class="btn btn-success w-100" type="submit"><?= lang('Auth.send') ?></button>
                </div>
            </form><!-- end form -->
        </div>
    </div>
    <!-- end card body -->
</div>
<!-- end card -->

<div class="mt-4 text-center">
    <p class="mb-0"><?= lang('Auth.backToLogin'); ?> <a href="<?= url_to('login') ?>" class="fw-semibold text-primary text-decoration-underline"><?= lang('Auth.login') ?></a></p>
</div>
<?= $this->endSection() ?>