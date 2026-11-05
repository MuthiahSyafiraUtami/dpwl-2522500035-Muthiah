<?php
require APPPATH . '/views/templates/header.php';
require APPPATH . '/views/templates/sidebar.php';

$penyewa = $penyewa ?? [];
$flash = $flash ?? null;
$mode = $mode ?? null;
$penyewa_dipilih = $penyewa_dipilih ?? null;
$flashClass = (($flash['type'] ?? '') === 'success')
    ? 'alert-success'
    : 'alert-danger';
$error = $error ?? null;
?>
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            Manajemen Data Penyewa
            <small>Kelola data penyewa</small>
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
            <li class="active">Manajemen Penyewa</li>
        </ol>
    </section>

    <section class="content">

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Data Penyewa</h3>

                <div class="box-tools">
                    <a href="<?= htmlspecialchars(
                        site_url('admin/penyewa/tambah'),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Tambah Penyewa
                    </a>
                </div>
            </div>

            <div class="box-body">
                <div class="table-responsive">

                    <table class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>NIK</th>
                                <th>Nama Lengkap</th>
                                <th>No. HP</th>
                                <th>Alamat</th>
                                <th>Foto KTP</th>
                                <th>Foto SIM A</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (empty($penyewa)): ?>
                                <tr>
                                    <td colspan="9" class="text-center">
                                        Data penyewa belum tersedia.
                                    </td>
                                </tr>

                            <?php else: ?>
                                <?php foreach ($penyewa as $i => $p): ?>
                                    <tr>
                                        <td><?= (int) $i + 1 ?></td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $p['user_plg'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </td>

                                        <td>••••••••</td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $p['nik'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $p['nm_lngkp'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $p['no_hp'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $p['almt_lngkp'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $p['ft_ktp'] ?? '-',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $p['ft_sim_a'] ?? '-',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
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

<?php
require APPPATH . '/views/templates/footer.php';
?>
<?php
require APPPATH . '/views/templates/footer.php';
?>