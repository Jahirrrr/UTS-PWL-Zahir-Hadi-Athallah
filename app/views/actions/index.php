<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h1 class="h2 fw-bold mb-2"><?= h($title) ?></h1>
        <p class="text-body-secondary mb-0">Kelola nama dan deskripsi jenis aksi.</p>
    </div>
    <a class="btn btn-primary rounded-pill px-4" href="index.php?page=actions&amp;action=create">+ Tambah Aksi</a>
</div>
<form class="row g-2 mb-4" method="get" action="index.php">
    <input type="hidden" name="page" value="actions">
    <div class="col-12 col-sm">
        <label class="visually-hidden" for="search">Cari jenis aksi</label>
        <input class="form-control rounded-3" id="search" name="search" value="<?= h($search) ?>" placeholder="Cari nama atau deskripsi jenis aksi…">
    </div>
    <div class="col-auto"><button class="btn btn-primary" type="submit">Cari</button></div>
    <?php if ($search !== ''): ?>
        <div class="col-auto"><a class="btn btn-outline-secondary" href="index.php?page=actions">Reset</a></div>
    <?php endif; ?>
</form>
<section class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3 px-4">
        <strong>Daftar jenis aksi</strong>
        <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill px-3 py-2"><?= count($actions) ?> data<?= $search !== '' ? ' ditemukan' : '' ?></span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th class="p-3" scope="col">Nama</th><th class="p-3" scope="col">Deskripsi</th><th class="p-3" scope="col">Dibuat</th><th class="p-3" scope="col">Aksi</th></tr>
            </thead>
            <tbody>
            <?php foreach ($actions as $item): ?>
                <tr>
                    <td class="p-3 text-break"><strong><?= h($item['name']) ?></strong></td>
                    <td class="p-3 text-break"><?= h($item['description']) ?></td>
                    <td class="p-3 text-nowrap"><?= h(date('d/m/Y H:i', strtotime($item['created_at']))) ?></td>
                    <td class="p-3">
                        <div class="d-flex flex-wrap gap-2">
                            <a class="btn btn-outline-primary btn-sm" href="index.php?page=actions&amp;action=edit&amp;id=<?= h($item['id']) ?>" aria-label="Ubah jenis aksi <?= h($item['name']) ?>">Ubah</a>
                            <form method="post" action="index.php?page=actions&amp;action=delete&amp;id=<?= h($item['id']) ?>" onsubmit="return confirm('Hapus jenis aksi ini? Data akan diarsipkan dengan soft delete.')">
                                <button class="btn btn-outline-danger btn-sm" type="submit" aria-label="Hapus jenis aksi <?= h($item['name']) ?>">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$actions): ?>
                <tr><td colspan="4" class="text-center text-body-secondary py-4">Belum ada jenis aksi<?= $search !== '' ? ' yang sesuai pencarian' : '' ?>.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
