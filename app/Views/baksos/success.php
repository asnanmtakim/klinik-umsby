<?= $this->extend('layout/landing') ?>
<?= $this->section('title') ?>Pendaftaran Berhasil<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="section bg-light" id="success" style="min-height: 80vh; padding-top: 150px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-lg border-0 mt-4">
                    <div class="card-body p-5 text-center">
                        <div class="avatar-lg mx-auto mt-2">
                            <div class="avatar-title bg-success-subtle text-success display-3 rounded-circle">
                                <i class="ri-checkbox-circle-fill"></i>
                            </div>
                        </div>
                        <div class="mt-4 pt-2">
                            <h4 class="fw-bold">Pendaftaran Berhasil!</h4>
                            <p class="text-muted mx-4 mt-3"><?= session()->getFlashdata('message') ?? 'Terima kasih telah berpartisipasi dalam Bakti Sosial kami.' ?></p>
                            <div class="mt-5">
                                <a href="<?= url_to('home') ?>" class="btn btn-primary btn-lg w-100">Kembali ke Beranda</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
