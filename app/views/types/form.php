<h1 class="h3 fw-bold mb-4"><?= h($title) ?></h1>
<?php require __DIR__ . '/../layout/errors.php'; ?>
<div class="row">
    <div class="col-lg-8">
        <section class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4">
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="name">Nama Tipe Akun</label>
                        <input class="form-control rounded-3" id="name" name="name" value="<?= h($data['name']) ?>" maxlength="128" required autofocus>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold" for="description">Deskripsi</label>
                        <textarea class="form-control rounded-3" id="description" name="description" rows="5" maxlength="5000"><?= h($data['description']) ?></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary px-4" type="submit">Simpan</button>
                        <a class="btn btn-outline-secondary" href="index.php?page=types">Batal</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
