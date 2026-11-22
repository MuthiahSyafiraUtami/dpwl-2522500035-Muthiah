<?php
require APPPATH . 'views/templates/header.php';
require APPPATH . 'views/templates/sidebar.php';

$pembayaran = $pembayaran ?? [];
$flash = $flash ?? null;
?>

<div class="content-wrapper">

    <section class="content-header">
        <h1>
            Verifikasi Pembayaran
            <small>Kelola bukti pembayaran penyewa</small>
        </h1>

        <ol class="breadcrumb">
            <li>
                <a href="<?= htmlspecialchars(
                    site_url('admin'),
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Verifikasi Pembayaran</li>
        </ol>
    </section>

    <section class="content">

        <?php if (!empty($flash)): ?>
            <div class="alert alert-<?= htmlspecialchars(
                $flash['type'] === 'success' ? 'success' : 'danger',
                ENT_QUOTES,
                'UTF-8'
            ) ?> alert-dismissible">
                <button type="button" class="close"
                    data-dismiss="alert">&times;</button>

                <?= htmlspecialchars(
                    $flash['message'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </div>
        <?php endif; ?>

        <div class="box box-primary">

            <div class="box-header with-border">
                <h3 class="box-title">
                    Daftar Pembayaran Menunggu Verifikasi
                </h3>
            </div>

            <div class="box-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kode Pembayaran</th>
                                <th>Kode Transaksi</th>
                                <th>Nama Penyewa</th>
                                <th>Nominal</th>
                                <th>Metode</th>
                                <th>Tanggal Upload</th>
                                <th>Bukti Transfer</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if (empty($pembayaran)): ?>

                                <tr>
                                    <td colspan="9" class="text-center">
                                        Belum ada pembayaran yang menunggu verifikasi.
                                    </td>
                                </tr>

                            <?php else: ?>

                                <?php foreach ($pembayaran as $i => $item): ?>

                                    <?php
                                    $namaFile = basename(
                                        (string) ($item['ft_byr'] ?? '')
                                    );

                                    $urlBukti = base_url(
                                        'uploads/bayar/' . rawurlencode($namaFile)
                                    );
                                    ?>

                                    <tr>
                                        <td><?= $i + 1 ?></td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $item['kode_bayar'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $item['kode_sewa'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $item['nm_lngkp'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>

                                            <br>

                                            <small>
                                                <?= htmlspecialchars(
                                                    $item['no_hp'],
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </small>
                                        </td>

                                        <td>
                                            Rp <?= number_format(
                                                (float) $item['nominal'],
                                                0,
                                                ',',
                                                '.'
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                strtoupper($item['mtode_byr']),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $item['tgl_wkt_byr'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </td>

                                        <td>
                                            <a href="<?= htmlspecialchars(
                                                $urlBukti,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>"
                                                target="_blank"
                                                class="btn btn-info btn-sm">
                                                <i class="fa fa-eye"></i>
                                                Lihat Bukti
                                            </a>
                                        </td>

                                        <td style="min-width: 150px;">

                                            <form method="POST"
                                                action="<?= htmlspecialchars(
                                                    site_url('admin/verifikasi-pembayaran/proses'),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>">

                                                <input type="hidden"
                                                    name="kode_bayar"
                                                    value="<?= htmlspecialchars(
                                                        $item['kode_bayar'],
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ) ?>">

                                                <button type="submit"
                                                    name="aksi"
                                                    value="terima"
                                                    class="btn btn-success btn-sm btn-block"
                                                    onclick="return confirm('Terima pembayaran ini?')">

                                                    <i class="fa fa-check"></i>
                                                    Terima
                                                </button>

                                                <button type="submit"
                                                    name="aksi"
                                                    value="tolak"
                                                    class="btn btn-danger btn-sm btn-block"
                                                    onclick="return confirm('Tolak pembayaran ini?')">

                                                    <i class="fa fa-times"></i>
                                                    Tolak
                                                </button>

                                            </form>

                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>
        </div>

    </section>
</div>
<?php require APPPATH . 'views/templates/footer.php'; ?>
</div>

</body>
</html>
