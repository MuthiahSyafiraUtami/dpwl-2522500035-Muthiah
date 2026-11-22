
<?php
require APPPATH . '/views/templates/header.php';
require APPPATH . '/views/templates/sidebar.php';

$penyewa = $penyewa ?? [];
$flash = $flash ?? null;
$mode = $mode ?? null;
$penyewa_dipilih = $penyewa_dipilih ?? null;
$error = $error ?? null;

$flashClass = (($flash['type'] ?? '') === 'success')
    ? 'alert-success'
    : 'alert-danger';
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

        <?php if (!empty($flash)): ?>
            <div class="alert <?= $flashClass ?> alert-dismissible">
                <button type="button" class="close"
                    data-dismiss="alert" aria-hidden="true">&times;</button>

                <?= htmlspecialchars(
                    $flash['message'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>


        <!-- FORM TAMBAH PENYEWA -->
        <?php if ($mode === 'tambah'): ?>

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Tambah Penyewa</h3>
                </div>

                <div class="box-body">
                    <form method="post"
                        action="<?= htmlspecialchars(
                            site_url('admin/penyewa/tambah'),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                        enctype="multipart/form-data">

                        <div class="form-group">
                            <label>Username Penyewa</label>
                            <input type="text" name="user_plg"
                                class="form-control"
                                placeholder="Masukkan username penyewa"
                                maxlength="15" required>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="sandi"
                                class="form-control"
                                placeholder="Masukkan password" required>
                        </div>

                        <div class="form-group">
                            <label>NIK</label>
                            <input type="text" name="nik"
                                class="form-control"
                                placeholder="Masukkan NIK"
                                maxlength="16" required>
                        </div>

                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nm_lngkp"
                                class="form-control"
                                placeholder="Masukkan nama lengkap"
                                maxlength="100" required>
                        </div>

                        <div class="form-group">
                            <label>Nomor HP</label>
                            <input type="text" name="no_hp"
                                class="form-control"
                                placeholder="Masukkan nomor HP"
                                maxlength="15" required>
                        </div>

                        <div class="form-group">
                            <label>Alamat Lengkap</label>
                            <textarea name="almt_lngkp"
                                class="form-control"
                                placeholder="Masukkan alamat lengkap"
                                maxlength="300" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>Foto KTP</label>
                            <input type="file" name="ft_ktp"
                                class="form-control"
                                accept=".jpg,.jpeg,.png,.webp">
                        </div>

                        <div class="form-group">
                            <label>Foto SIM A</label>
                            <input type="file" name="ft_sim_a"
                                class="form-control"
                                accept=".jpg,.jpeg,.png,.webp">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Simpan
                        </button>

                        <a href="<?= htmlspecialchars(
                            site_url('admin/penyewa'),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>" class="btn btn-default">
                            Kembali
                        </a>

                    </form>
                </div>
            </div>


        <!-- FORM UBAH PENYEWA -->
        <?php elseif (
            $mode === 'ubah' &&
            !empty($penyewa_dipilih)
        ): ?>

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Ubah Data Penyewa</h3>
                </div>

                <div class="box-body">
                    <form method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label>Username Penyewa</label>
                            <input type="text" class="form-control"
                                value="<?= htmlspecialchars(
                                    $penyewa_dipilih['user_plg'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"
                                readonly>
                        </div>

                        <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password" name="sandi"
                                class="form-control"
                                placeholder="Kosongkan jika tidak ingin mengganti password">
                        </div>

                        <div class="form-group">
                            <label>NIK</label>
                            <input type="text" name="nik"
                                class="form-control"
                                maxlength="16" required
                                value="<?= htmlspecialchars(
                                    $penyewa_dipilih['nik'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>">
                        </div>

                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nm_lngkp"
                                class="form-control"
                                maxlength="100" required
                                value="<?= htmlspecialchars(
                                    $penyewa_dipilih['nm_lngkp'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>">
                        </div>

                        <div class="form-group">
                            <label>Nomor HP</label>
                            <input type="text" name="no_hp"
                                class="form-control"
                                maxlength="15" required
                                value="<?= htmlspecialchars(
                                    $penyewa_dipilih['no_hp'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>">
                        </div>

                        <div class="form-group">
                            <label>Alamat Lengkap</label>
                            <textarea name="almt_lngkp"
                                class="form-control"
                                maxlength="300"
                                required><?= htmlspecialchars(
                                    $penyewa_dipilih['almt_lngkp'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Foto KTP Saat Ini</label>
                            <p>
                                <?= htmlspecialchars(
                                    $penyewa_dipilih['ft_ktp'] ?? '-',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </p>
                            <input type="file" name="ft_ktp"
                                class="form-control"
                                accept=".jpg,.jpeg,.png,.webp">
                        </div>

                        <div class="form-group">
                            <label>Foto SIM A Saat Ini</label>
                            <p>
                                <?= htmlspecialchars(
                                    $penyewa_dipilih['ft_sim_a'] ?? '-',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </p>
                            <input type="file" name="ft_sim_a"
                                class="form-control"
                                accept=".jpg,.jpeg,.png,.webp">
                        </div>

                        <button type="submit" class="btn btn-warning">
                            <i class="fa fa-save"></i> Simpan Perubahan
                        </button>

                        <a href="<?= htmlspecialchars(
                            site_url('admin/penyewa'),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>" class="btn btn-default">
                            Batal
                        </a>

                    </form>
                </div>
            </div>


        <!-- TABEL DATA PENYEWA -->
        <?php else: ?>

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
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (empty($penyewa)): ?>
                                    <tr>
                                        <td colspan="10" class="text-center">
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

                                            <td>
                                                <a href="<?= htmlspecialchars(
                                                    site_url(
                                                        'admin/penyewa/ubah/' .
                                                        rawurlencode(
                                                            (string) $p['user_plg']
                                                        )
                                                    ),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>"
                                                    class="btn btn-warning btn-xs">
                                                    <i class="fa fa-edit"></i> Ubah
                                                </a>

                                                <form method="post"
                                                    action="<?= htmlspecialchars(
                                                        site_url(
                                                            'admin/penyewa/hapus/' .
                                                            rawurlencode(
                                                                (string) $p['user_plg']
                                                            )
                                                        ),
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ) ?>"
                                                    style="display:inline;"
                                                    onsubmit="return confirm('Yakin ingin menghapus data penyewa ini?')">

                                                    <button type="submit"
                                                        class="btn btn-danger btn-xs">
                                                        <i class="fa fa-trash"></i> Hapus
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

        <?php endif; ?>

    </section>
</div>

<?php
require APPPATH . '/views/templates/footer.php';
?>
