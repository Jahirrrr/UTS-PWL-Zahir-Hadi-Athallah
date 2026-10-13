<h1 class="h3 fw-bold mb-4"><?= h($title) ?></h1>
<?php require __DIR__ . '/../layout/errors.php'; ?>
<div class="row">
    <div class="col-lg-10">
        <section class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4">
                <form method="post">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="name">Nama</label>
                            <input class="form-control rounded-3" id="name" name="name" value="<?= h($data['name']) ?>" maxlength="128" required autofocus>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="email">Email</label>
                            <input class="form-control rounded-3" id="email" name="email" type="email" value="<?= h($data['email']) ?>" maxlength="128" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold" for="password">Password</label>
                            <input class="form-control rounded-3" id="password" name="password" type="password" minlength="6" maxlength="72" autocomplete="new-password" <?= $id === '' ? 'required' : '' ?>>
                            <div class="form-text">Gunakan 6–72 byte. Saat edit, kosongkan jika password tidak diganti.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="account_type_id">Tipe Akun</label>
                            <select class="form-select rounded-3" id="account_type_id" name="account_type_id" required>
                                <option value="">Pilih tipe akun</option>
                                <?php foreach ($types as $type): ?>
                                    <option value="<?= h($type['id']) ?>" <?= $data['account_type_id'] === $type['id'] ? 'selected' : '' ?>><?= h($type['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text">Satu tipe untuk satu akun. <a href="index.php?page=types&amp;action=create">Tambah tipe</a> jika diperlukan.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="status">Status</label>
                            <select class="form-select rounded-3" id="status" name="status">
                                <option value="Aktif" <?= $data['status'] === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                                <option value="Nonaktif" <?= $data['status'] === 'Nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="identification_type">Jenis Identitas</label>
                            <select class="form-select rounded-3" id="identification_type" name="identification_type">
                                <option value="NIM" <?= $data['identification_type'] === 'NIM' ? 'selected' : '' ?>>NIM</option>
                                <option value="NIP" <?= $data['identification_type'] === 'NIP' ? 'selected' : '' ?>>NIP</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="identification_number">Nomor Identitas</label>
                            <input class="form-control rounded-3" id="identification_number" name="identification_number" value="<?= h($data['identification_number']) ?>" inputmode="numeric" pattern="[0-9]+" maxlength="128" required>
                        </div>
                    </div>
                    <?php if (!$types): ?>
                        <div class="alert alert-warning mt-3">Tambahkan tipe akun terlebih dahulu.</div>
                    <?php endif; ?>
                    <div class="d-flex gap-2 mt-4">
                        <button class="btn btn-primary px-4" type="submit" <?= !$types ? 'disabled' : '' ?>>Simpan</button>
                        <a class="btn btn-outline-secondary" href="index.php?page=accounts">Batal</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
