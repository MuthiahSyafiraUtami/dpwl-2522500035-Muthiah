
<?php
require APPPATH . 'views/katalog/header.php';

$e = static function ($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};

require APPPATH . 'views/katalog/navbar.php';

$formatRupiah = static function ($nilai): string {
    return 'Rp ' . number_format((float) $nilai, 0, ',', '.');
};

$pembayaran = is_array($pembayaran ?? null) ? $pembayaran : [];
?>

<section class="bg-success py-4">
    <div class="container">
        <h1 class="h2 text-white mt-3">Pembayaran Saya</h1>
        <p class="text-white mb-0">
            Informasi pembayaran uang muka transaksi penyewaan kendaraan.
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <?php if (!empty($flash)): ?>
            <div class="alert alert-<?= $e($flash['type'] === 'success' ? 'success' : 'danger') ?>">
                <?= $e($flash['message'] ?? '') ?></div>
            <?php endif; ?>

        <?php if ($pembayaran === []): ?>
            <div class="alert alert-info">
                Belum ada data pembayaran.
            </div>
        <?php else: ?>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Kode Pembayaran</th>
                            <th>Kode Transaksi</th>
                            <th>Jenis</th>
                            <th>Nominal</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Status</th>
                            <th>Bukti Transfer</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($pembayaran as $i => $item): ?>
                            <?php
                            $status = $item['sttus_byr'] ?? 'pending';

                            $warnaStatus = [
                                'pending' => 'warning',
                                'valid' => 'success',
                                'invalid' => 'danger'
                            ][$status] ?? 'secondary';
                            ?>

                            <tr>
                                <td><?= $i + 1 ?></td>

                                <td><?= $e($item['kode_bayar']) ?></td>

                                <td><?= $e($item['kode_sewa']) ?></td>

                                <td>
                                    <?= $e(strtoupper($item['jns_byr'] ?? '-')) ?>
                                </td>

                                <td class="text-nowrap">
                                    <?= $e($formatRupiah($item['nominal'])) ?>
                                </td>

                                <td>
                                    <?= $e($item['tgl_wkt_byr']) ?>
                                </td>

                                <td>
                                    <span class="badge bg-<?= $e($warnaStatus) ?>">
                                        <?= $e(strtoupper($status)) ?>
                                    </span>
                                </td>

                                <td style="min-width: 230px;">
                                    <?php if (!empty($item['ft_byr'])): ?>
                                        <span class="text-success d-block mb-2">
                                            Sudah diunggah
                                        </span>
                                        
                                    <a href="<?= $e(base_url('uploads/bayar/' . rawurlencode($item['ft_byr']))) ?>" target="_blank" class="btn btn-sm btn-info mb-2">
                                        Lihat Bukti
                                    </a>
                                    
                                    <?php else: ?>
                                        <span class="text-danger d-block mb-2">
                                            Belum diunggah
                                        </span>
                                        
                                    <?php endif; ?>

                                    <?php if (($item['sttus_byr'] ?? '') === 'pending'): ?>
                                        <form action="<?= $e(site_url('transaksi/upload-bukti-pembayaran')) ?>" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="kode_bayar" value="<?= $e($item['kode_bayar']) ?>">
                                            <input type="file" name="ft_byr" class="form-control form-control-sm mb-2" accept=".jpg,.jpeg,.png,.webp,.pdf" required>
                                            
                                            <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-upload"></i><?= !empty($item['ft_byr']) ? 'Ganti Bukti' : 'Upload Bukti' ?></button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>

        <a href="<?= $e(site_url('katalog')) ?>"
           class="btn btn-outline-secondary mt-3">
            <i class="fas fa-arrow-left me-1"></i>
            Kembali ke Katalog
        </a>

    </div>
</section>

<?php require APPPATH . 'views/katalog/footer.php'; ?>
