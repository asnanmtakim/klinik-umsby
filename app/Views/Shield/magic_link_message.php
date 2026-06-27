<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.useMagicLink') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="card mt-4">
    <div class="card-body p-4 text-center">
        <div class="avatar-lg mx-auto mt-2">
            <div class="avatar-title bg-light text-success display-3 rounded-circle">
                <i class="ri-checkbox-circle-fill"></i>
            </div>
        </div>
        <div class="mt-4 pt-2">
            <h4>
                <?= lang('Auth.useMagicLink') ?>
            </h4>
            <p class="fw-bold mx-4">
                <?= lang('Auth.checkYourEmail') ?>
            </p>
            <p class="text-muted mx-4">
                <?= lang('Auth.magicLinkDetails', [setting('Auth.magicLinkLifetime') / 60]) ?>
            </p>
        </div>
    </div>
    <!-- end card body -->
</div>
<!-- end card -->

<?= $this->endSection() ?>