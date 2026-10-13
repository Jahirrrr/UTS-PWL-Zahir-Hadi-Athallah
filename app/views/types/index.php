<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h1 class="h2 fw-bold mb-2"><?= h($title) ?></h1>
        <p class="text-body-secondary mb-0">Kelola nama dan deskripsi tipe akun.</p>
    </div>
    <a class="btn btn-primary rounded-pill px-4" href="index.php?page=types&amp;action=create">+ Tambah Tipe Akun</a>
</div>
<form class="row g-2 mb-4" method="get" action="index.php">
    <input type="hidden" name="page" value="types">
    <div class="col-12 col-sm">
        <label class="visually-hidden" for="search">Cari tipe akun</label>
        <input class="form-control rounded-3" id="search" name="search" value="<?= h($search) ?>" placeholder="Cari nama atau deskripsi tipe akun…">
    </div>
    <div class="col-auto"><button class="btn btn-primary" type="submit">Cari</button></div>
    <?php if ($search !== ''): ?>
        <div class="col-auto"><a class="btn btn-outline-secondary" href="index.php?page=types">Reset</a></div>
    <?php endif; ?>
</form>
<section class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3 px-4">
        <strong>Daftar tipe akun</strong>
        <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill px-3 py-2"><?= count($types) ?> data<?= $search !== '' ? ' ditemukan' : '' ?></span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th class="p-3" scope="col">Nama</th><th class="p-3" scope="col">Deskripsi</th><th class="p-3" scope="col">Dibuat</th><th class="p-3" scope="col">Aksi</th></tr>
            </thead>
            <tbody>
            <?php foreach ($types as $type): ?>
                <tr>
                    <td class="p-3 text-break"><strong><?= h($type['name']) ?></strong></td>
                    <td class="p-3 text-break"><?= h($type['description']) ?></td>
                    <td class="p-3 text-nowrap"><?= h(date('d/m/Y H:i', strtotime($type['created_at']))) ?></td>
                    <td class="p-3">
                        <div class="d-flex flex-wrap gap-2">
                            <a class="btn btn-outline-primary btn-sm" href="index.php?page=types&amp;action=edit&amp;id=<?= h($type['id']) ?>" aria-label="Ubah tipe akun <?= h($type['name']) ?>">Ubah</a>
                            <form method="post" action="index.php?page=types&amp;action=delete&amp;id=<?= h($type['id']) ?>" onsubmit="return confirm('Hapus tipe akun ini? Tipe yang masih digunakan tidak bisa dihapus.')">
                                <button class="btn btn-outline-danger btn-sm" type="submit" aria-label="Hapus tipe akun <?= h($type['name']) ?>">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$types): ?>
                <tr><td colspan="4" class="text-center text-body-secondary py-4">Belum ada tipe akun<?= $search !== '' ? ' yang sesuai pencarian' : '' ?>.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
