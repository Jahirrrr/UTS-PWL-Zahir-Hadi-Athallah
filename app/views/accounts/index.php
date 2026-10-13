<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h1 class="h2 fw-bold mb-2"><?= h($title) ?></h1>
        <p class="text-body-secondary mb-0">Kelola identitas, tipe, dan status akun.</p>
    </div>
    <a class="btn btn-primary rounded-pill px-4" href="index.php?page=accounts&amp;action=create">+ Tambah Akun</a>
</div>
<form class="row g-2 mb-4" method="get" action="index.php">
    <input type="hidden" name="page" value="accounts">
    <div class="col-12 col-sm">
        <label class="visually-hidden" for="search">Cari akun</label>
        <input class="form-control rounded-3" id="search" name="search" value="<?= h($search) ?>" placeholder="Cari nama, email, NIM/NIP, atau tipe akun…">
    </div>
    <div class="col-auto"><button class="btn btn-primary" type="submit">Cari</button></div>
    <?php if ($search !== ''): ?>
        <div class="col-auto"><a class="btn btn-outline-secondary" href="index.php?page=accounts">Reset</a></div>
    <?php endif; ?>
</form>
<section class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3 px-4">
        <strong>Daftar akun</strong>
        <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill px-3 py-2"><?= count($accounts) ?> akun<?= $search !== '' ? ' ditemukan' : '' ?></span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th class="p-3" scope="col">Nama</th><th class="p-3" scope="col">Email</th><th class="p-3" scope="col">Identitas</th><th class="p-3" scope="col">Tipe Akun</th><th class="p-3" scope="col">Status</th><th class="p-3" scope="col">Aksi</th></tr>
            </thead>
            <tbody>
            <?php foreach ($accounts as $account): ?>
                <tr>
                    <td class="p-3 text-break"><strong><?= h($account['name']) ?></strong></td>
                    <td class="p-3 text-break"><?= h($account['email']) ?></td>
                    <td class="p-3"><span class="badge text-bg-secondary me-1"><?= h($account['identification_type']) ?></span><?= h($account['identification_number']) ?></td>
                    <td class="p-3"><?= h($account['type_name']) ?></td>
                    <td class="p-3"><span class="badge <?= $account['status'] === 'Aktif' ? 'text-bg-success' : 'text-bg-secondary' ?>"><?= h($account['status']) ?></span></td>
                    <td class="p-3">
                        <div class="d-flex flex-wrap gap-2">
                            <a class="btn btn-outline-primary btn-sm" href="index.php?page=accounts&amp;action=edit&amp;id=<?= h($account['id']) ?>" aria-label="Ubah akun <?= h($account['name']) ?>">Ubah</a>
                            <?php if ($account['id'] !== $_SESSION['user']['id']): ?>
                                <form method="post" action="index.php?page=accounts&amp;action=delete&amp;id=<?= h($account['id']) ?>" onsubmit="return confirm('Hapus akun ini? Data akan diarsipkan dengan soft delete.')">
                                    <button class="btn btn-outline-danger btn-sm" type="submit" aria-label="Hapus akun <?= h($account['name']) ?>">Hapus</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$accounts): ?>
                <tr><td colspan="6" class="text-center text-body-secondary py-4">Belum ada akun<?= $search !== '' ? ' yang sesuai pencarian' : '' ?>.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
