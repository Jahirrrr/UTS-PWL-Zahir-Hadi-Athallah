<div class="row justify-content-center mt-5">
    <div class="col-md-7 col-lg-5">
        <section class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4"><span class="d-inline-block bg-primary-subtle text-primary-emphasis rounded-4 px-4 py-3 fs-3 fw-bold">M</span></div>
                <p class="small text-primary text-center fw-semibold mb-2">MANAJEMEN AKUN</p>
                <h1 class="h3 fw-bold text-center">Selamat datang</h1>
                <p class="text-body-secondary text-center mb-4">Masuk untuk mengelola akun, tipe akun, dan jenis aksi.</p>
                <?php if ($error !== ''): ?>
                    <div class="alert alert-danger" role="alert"><?= h($error) ?></div>
                <?php endif; ?>
                <form method="post" action="index.php?page=auth&amp;action=login">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="email">Email</label>
                        <input class="form-control rounded-3" id="email" name="email" type="email" value="<?= h($email) ?>" maxlength="128" placeholder="nama@pnj.ac.id" autocomplete="username" required autofocus>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold" for="password">Password</label>
                        <input class="form-control rounded-3" id="password" name="password" type="password" autocomplete="current-password" required>
                    </div>
                    <button class="btn btn-primary w-100 rounded-3 py-2" type="submit">Login</button>
                </form>
                <p class="small text-body-secondary text-center mt-4 mb-0">UTS Pemrograman Web Lanjut · 2026 / 2027</p>
            </div>
        </section>
    </div>
</div>
