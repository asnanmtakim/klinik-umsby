<?= $this->extend('layout/landing') ?>
<?= $this->section('title') ?>Pendaftaran Bakti Sosial<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="section bg-light" id="register" style="min-height: 100vh; padding-top: 120px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="text-center mb-4">
                    <h2 class="text-primary fw-semibold">Pendaftaran Bakti Sosial</h2>
                    <p class="text-muted">Isi formulir di bawah ini untuk mendaftar pada kegiatan bakti sosial Launching Klinik Pratama UMSURA.</p>
                </div>

                <div class="card shadow-lg border-0 mt-4">
                    <div class="card-body p-4">
                        <?php if (session()->getFlashdata('error')) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Gagal!</strong> <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('errors')) : ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($is_closed) && $is_closed) : ?>
                            <div class="alert alert-warning text-center p-4">
                                <h4><i class="ri-error-warning-line align-middle me-2"></i> Pendaftaran Ditutup</h4>
                                <p class="mb-0 mt-2">Mohon maaf, pendaftaran Bakti Sosial telah ditutup. Terima kasih atas antusiasme Anda.</p>
                            </div>
                            <div class="text-center mt-4">
                                <a href="<?= url_to('home') ?>" class="btn btn-primary"><i class="ri-arrow-left-line align-middle me-1"></i> Kembali ke Beranda</a>
                            </div>
                        <?php else : ?>
                            <form action="<?= url_to('baksos-register') ?>" method="post">
                                <?= csrf_field() ?>

                                <div class="mb-3">
                                    <label for="service_id" class="form-label">Pilih Layanan <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-lg" id="service_id" name="service_id" required>
                                        <option value="">-- Pilih Layanan Bakti Sosial --</option>
                                        <?php foreach ($services as $service) : ?>
                                            <?php $disabled = ($service['sisa_kuota'] <= 0) ? 'disabled' : ''; ?>
                                            <option value="<?= $service['id'] ?>" <?= $disabled ?> <?= old('service_id') == $service['id'] ? 'selected' : '' ?>>
                                                <?= esc($service['nama_pelayanan']) ?> (Sisa Kuota: <?= $service['sisa_kuota'] ?>)
                                                <?php if ($service['sisa_kuota'] <= 0) echo ' - PENUH'; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= old('nama_lengkap') ?>" placeholder="Masukkan nama lengkap" required>
                                </div>

                                <div class="mb-3">
                                    <label for="nik" class="form-label">NIK (Nomor Induk Kependudukan) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nik" name="nik" value="<?= old('nik') ?>" placeholder="Masukkan 16 digit NIK" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="umur" class="form-label">Umur <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="umur" name="umur" value="<?= old('umur') ?>" placeholder="Umur" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                            <option value="">Pilih</option>
                                            <option value="L" <?= old('jenis_kelamin') == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                            <option value="P" <?= old('jenis_kelamin') == 'P' ? 'selected' : '' ?>>Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="no_hp" class="form-label">No. HP / WhatsApp <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= old('no_hp') ?>" placeholder="08xxxxxxxxxx" required>
                                </div>

                                <div class="mb-4">
                                    <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= old('alamat') ?></textarea>
                                </div>

                                <div class="mt-4">
                                    <button class="btn btn-primary btn-lg w-100" type="submit">Daftar Sekarang</button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>