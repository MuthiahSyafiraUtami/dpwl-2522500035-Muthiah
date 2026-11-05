
<?php
require_once APPPATH . 'models/Penyewa_model.php';
require_once APPPATH . 'models/Transaksi_model.php';

class Penyewa_controller extends Controller
{
    private Penyewa_model $model;
    private Transaksi_model $transaksiModel;

  public function __construct()
{
    require_once APPPATH . 'helpers/auth_helper.php';
    require_once APPPATH . 'helpers/flash_helper.php';

    $this->model = new Penyewa_model();
    $this->transaksiModel = new Transaksi_model();
}
// UTS: menampilkan halaman manajemen data penyewa
public function index(): void
{
    require_admin_login();

    try {
        $dataPenyewa = $this->model->getAll();

        $this->view('admin/penyewa_view', [
    'username' => $_SESSION['admin_username'],
    'penyewa' => $dataPenyewa,
    'flash' => get_flash_message(),
    'mode' => null,
    'penyewa_dipilih' => null,
    'error' => null
]);

    } catch (Throwable $e) {
        error_log(
            'Pengambilan data penyewa gagal: ' . $e->getMessage()
        );

        http_response_code(500);
        exit('Data penyewa belum dapat ditampilkan.');
    }
}


public function tambah(): void
{
    require_admin_login();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'user_plg' => trim($_POST['user_plg'] ?? ''),
            'sandi' => password_hash(
                $_POST['sandi'] ?? '',
                PASSWORD_DEFAULT
            ),
            'nik' => trim($_POST['nik'] ?? ''),
            'nm_lngkp' => trim($_POST['nm_lngkp'] ?? ''),
            'no_hp' => trim($_POST['no_hp'] ?? ''),
            'almt_lngkp' => trim($_POST['almt_lngkp'] ?? ''),
            'ft_ktp' => null,
            'ft_sim_a' => null
        ];

        if (!preg_match('/^[0-9]{16}$/', $data['nik'])) {
            set_flash_message(
                'error',
                'NIK harus terdiri dari tepat 16 digit angka.'
            );
            header('Location: ' . site_url('admin/penyewa'));
            exit;
        }

        $uploadedFiles = [];

        try {
            // Upload foto KTP
            $uploadKtp = $this->uploadFotoPenyewa('ft_ktp');

            if (!$uploadKtp['success']) {
                throw new RuntimeException($uploadKtp['error']);
            }

            $data['ft_ktp'] = $uploadKtp['filename'];

            if ($uploadKtp['filename'] !== null) {
                $uploadedFiles[] = $uploadKtp['filename'];
            }

            // Upload foto SIM A
            $uploadSim = $this->uploadFotoPenyewa('ft_sim_a');

            if (!$uploadSim['success']) {
                throw new RuntimeException($uploadSim['error']);
            }

            $data['ft_sim_a'] = $uploadSim['filename'];

            if ($uploadSim['filename'] !== null) {
                $uploadedFiles[] = $uploadSim['filename'];
            }

            // Simpan data ke database
            $success = $this->model->createAdmin($data);

            if (!$success) {
                throw new RuntimeException(
                    'Data penyewa gagal ditambahkan.'
                );
            }

            set_flash_message(
                'success',
                'Data penyewa berhasil ditambahkan.'
            );

        } catch (Throwable $e) {
            // Hapus foto baru jika proses gagal
            $this->hapusFotoPenyewa($uploadedFiles);

            error_log('Tambah penyewa gagal: ' . $e->getMessage());

            set_flash_message(
                'error',
                $e->getMessage()
            );
        }

        header('Location: ' . site_url('admin/penyewa'));
        exit;
    }

    $this->view('admin/penyewa_view', [
        'username' => $_SESSION['admin_username'],
        'penyewa' => $this->model->getAll(),
        'flash' => null,
        'mode' => 'tambah',
        'penyewa_dipilih' => null,
        'error' => null,
    ]);
}


// UTS: mengubah data penyewa melalui admin
// UTS: mengubah data penyewa melalui admin
public function ubah(string $userPlg): void
{
    require_admin_login();

    $userPlg = rawurldecode($userPlg);

    try {
        $penyewaLama = $this->model->getProfil($userPlg);

        if ($penyewaLama === null) {
            set_flash_message('error', 'Data penyewa tidak ditemukan.');
            header('Location: ' . site_url('admin/penyewa'));
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = trim($_POST['sandi'] ?? '');

            $data = [
                'sandi' => $password !== ''
                    ? password_hash($password, PASSWORD_DEFAULT)
                    : null,
                'nik' => trim($_POST['nik'] ?? ''),
                'nm_lngkp' => trim($_POST['nm_lngkp'] ?? ''),
                'no_hp' => trim($_POST['no_hp'] ?? ''),
                'almt_lngkp' => trim($_POST['almt_lngkp'] ?? ''),
                'ft_ktp' => $penyewaLama['ft_ktp'],
                'ft_sim_a' => $penyewaLama['ft_sim_a']
            ];

            $error = $this->validateProfilInput(
                $data['nik'],
                $data['nm_lngkp'],
                $data['no_hp'],
                $data['almt_lngkp']
            );

            if ($error !== null) {
                set_flash_message('error', $error);
                header('Location: ' . site_url('admin/penyewa'));
                exit;
            }

            if ($password !== '' && (strlen($password) < 8 || strlen($password) > 72)) {
                set_flash_message('error', 'Password harus 8 sampai 72 byte.');
                header('Location: ' . site_url('admin/penyewa'));
                exit;
            }

            $uploadedFiles = [];

            try {
                $uploadKtp = $this->uploadFotoPenyewa('ft_ktp');

                if (!$uploadKtp['success']) {
                    throw new RuntimeException($uploadKtp['error']);
                }

                if ($uploadKtp['filename'] !== null) {
                    $uploadedFiles[] = $uploadKtp['filename'];
                    $data['ft_ktp'] = $uploadKtp['filename'];
                }

                $uploadSim = $this->uploadFotoPenyewa('ft_sim_a');

                if (!$uploadSim['success']) {
                    throw new RuntimeException($uploadSim['error']);
                }

                if ($uploadSim['filename'] !== null) {
                    $uploadedFiles[] = $uploadSim['filename'];
                    $data['ft_sim_a'] = $uploadSim['filename'];
                }

                $success = $this->model->updateAdmin($userPlg, $data);

                if (!$success) {
                    throw new RuntimeException('Data penyewa gagal diubah.');
                }

                // Hapus foto lama setelah database berhasil diperbarui.
                $fotoLama = [];

                if ($uploadKtp['filename'] !== null && !empty($penyewaLama['ft_ktp'])) {
                    $fotoLama[] = ['ft_ktp', $penyewaLama['ft_ktp']];
                }

                if ($uploadSim['filename'] !== null && !empty($penyewaLama['ft_sim_a'])) {
                    $fotoLama[] = ['ft_sim_a', $penyewaLama['ft_sim_a']];
                }

                $this->hapusFotoPenyewa($fotoLama);

                set_flash_message('success', 'Data penyewa berhasil diubah.');

            } catch (Throwable $e) {
                $this->hapusFotoPenyewa($uploadedFiles);
                throw $e;
            }

            header('Location: ' . site_url('admin/penyewa'));
            exit;
        }

        $this->view('admin/penyewa_view', [
            'username' => $_SESSION['admin_username'],
            'penyewa' => $this->model->getAll(),
            'flash' => null,
            'mode' => 'ubah',
            'penyewa_dipilih' => $penyewaLama,
            'error' => null
        ]);

    } catch (Throwable $e) {
        error_log('Ubah penyewa gagal: ' . $e->getMessage());

        set_flash_message('error', 'Data penyewa gagal diproses.');
        header('Location: ' . site_url('admin/penyewa'));
        exit;
    }
}
// UTS: menghapus data penyewa melalui admin
public function hapus(string $userPlg): void
{
    require_admin_login();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit('Metode request tidak diizinkan.');
    }

    $userPlg = rawurldecode($userPlg);

    try {
        $penyewa = $this->model->getProfil($userPlg);

        if ($penyewa === null) {
            set_flash_message(
                'danger',
                'Data penyewa tidak ditemukan.'
            );
        } else {
            $success = $this->model->deleteAdmin($userPlg);

            set_flash_message(
                $success ? 'success' : 'danger',
                $success
                    ? 'Data penyewa berhasil dihapus.'
                    : 'Data penyewa gagal dihapus.'
            );
        }
    } catch (Throwable $e) {
        error_log('Hapus penyewa gagal: ' . $e->getMessage());

        set_flash_message(
            'danger',
            'Data penyewa gagal dihapus.'
        );
    }

    header('Location: ' . site_url('admin/penyewa'));
    exit;
}
  public function profil(): void
  {
    if (empty($_SESSION['penyewa_user_plg'])) {
      $_SESSION['flash_penyewa_nav'] =
        'Silakan login terlebih dahulu untuk mengakses profil.';

      header('Location: ' . site_url('auth/login-penyewa'));
      exit;
    }

    $userPlg = (string) $_SESSION['penyewa_user_plg'];

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      try {
        $profil = $this->model->getProfil($userPlg);

        if ($profil === null) {
          unset($_SESSION['penyewa_user_plg']);

          $_SESSION['flash_penyewa_nav'] =
            'Data akun tidak ditemukan. Silakan login kembali.';

          header('Location: ' . site_url('auth/login-penyewa'));
          exit;
        }

        $flash = $_SESSION['flash_profil_penyewa'] ?? null;
        unset($_SESSION['flash_profil_penyewa']);

        $this->view('penyewa/profil', [
          'profil' => $profil,
          'flash' => $flash,
          'error' => null,
          'old' => []
        ]);

        return;
      } catch (Throwable $e) {
        error_log('Pengambilan profil penyewa gagal: ' . $e->getMessage());

        http_response_code(500);
        exit('Profil belum dapat ditampilkan. Silakan coba kembali.');
      }
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      http_response_code(405);
      header('Allow: GET, POST');
      exit('Method Not Allowed');
    }

    $nik = trim((string) ($_POST['nik'] ?? ''));
    $nama = trim((string) ($_POST['nm_lngkp'] ?? ''));
    $noHp = trim((string) ($_POST['no_hp'] ?? ''));
    $alamat = trim((string) ($_POST['almt_lngkp'] ?? ''));
    $passwordSaatIni = (string) ($_POST['password_saat_ini'] ?? '');
    $passwordBaru = (string) ($_POST['password_baru'] ?? '');
    $konfirmasiPassword = (string) (
      $_POST['konfirmasi_password'] ?? ''
    );

    $old = [
      'nik' => $nik,
      'nm_lngkp' => $nama,
      'no_hp' => $noHp,
      'almt_lngkp' => $alamat
    ];

    $error = $this->validateProfilInput($nik, $nama, $noHp, $alamat);

    try {
      $profil = $this->model->getProfil($userPlg);

      if ($profil === null) {
        unset($_SESSION['penyewa_user_plg']);

        $_SESSION['flash_penyewa_nav'] =
          'Data akun tidak ditemukan. Silakan login kembali.';

        header('Location: ' . site_url('auth/login-penyewa'));
        exit;
      }

      $passwordHashBaru = null;

      $inginGantiPassword =
        $passwordSaatIni !== '' ||
        $passwordBaru !== '' ||
        $konfirmasiPassword !== '';

      if ($inginGantiPassword) {
        if (
          $passwordSaatIni === '' ||
          $passwordBaru === '' ||
          $konfirmasiPassword === ''
        ) {
          $error = 'Untuk mengganti password, ketiga kolom password wajib diisi.';
        } elseif (strlen($passwordBaru) < 8) {
          $error = 'Password baru minimal 8 karakter.';
        } elseif (strlen($passwordBaru) > 72) {
          $error = 'Password baru maksimal 72 byte.';
        } elseif ($passwordBaru !== $konfirmasiPassword) {
          $error = 'Konfirmasi password baru tidak sama.';
        } elseif (!$this->model->verifikasiPassword(
          $userPlg,
          $passwordSaatIni
        )) {
          $error = 'Password saat ini tidak sesuai.';
        } else {
          $passwordHashBaru = password_hash(
            $passwordBaru,
            PASSWORD_DEFAULT
          );

          if ($passwordHashBaru === false) {
            throw new RuntimeException(
              'Pembuatan hash password baru gagal.'
            );
          }
        }
      }
      $jumlahKeranjang = $this->transaksiModel->getJumlahMobilKeranjang($userPlg);

if ($error !== null) {
    $this->view('penyewa/profil', [
        'profil' => $profil,
        'flash' => null,
        'error' => $error,
        'old' => $old,
        'jumlahKeranjang' => $jumlahKeranjang
    ]);

    return;
}

      $uploadedFiles = [];

      $uploadKtp = $this->uploadFotoPenyewa('ft_ktp');

      if (!$uploadKtp['success']) {
        $this->renderProfilError(
          $profil,
          $old,
          $uploadKtp['error']
        );
        return;
      }

      if ($uploadKtp['filename'] !== null) {
        $uploadedFiles[] = $uploadKtp['filename'];
      }

      $uploadSim = $this->uploadFotoPenyewa('ft_sim_a');

      if (!$uploadSim['success']) {
        $this->hapusFotoPenyewa($uploadedFiles);

        $this->renderProfilError(
          $profil,
          $old,
          $uploadSim['error']
        );
        return;
      }

      if ($uploadSim['filename'] !== null) {
        $uploadedFiles[] = $uploadSim['filename'];
      }

      // Foto lama dipertahankan jika tidak ada file baru.
      $ftKtpBaru = $uploadKtp['filename']
        ?? ($profil['ft_ktp'] ?? null);

      $ftSimBaru = $uploadSim['filename']
        ?? ($profil['ft_sim_a'] ?? null);

      $success = $this->model->updateProfil(
        $userPlg,
        $nik,
        $nama,
        $noHp,
        $alamat,
        $ftKtpBaru,
        $ftSimBaru,
        $passwordHashBaru
      );

      if (!$success) {
        $this->hapusFotoPenyewa($uploadedFiles);

        $this->renderProfilError(
          $profil,
          $old,
          'Profil gagal diperbarui. Periksa kembali data Anda.'
        );

        return;
      }

      // Hapus foto lama hanya setelah database berhasil diperbarui.
      $fotoLama = [];

      if (
        $uploadKtp['filename'] !== null &&
        !empty($profil['ft_ktp'])
      ) {
        $fotoLama[] = [
          'ft_ktp',
          $profil['ft_ktp']
        ];
      }

      if (
        $uploadSim['filename'] !== null &&
        !empty($profil['ft_sim_a'])
      ) {
        $fotoLama[] = [
          'ft_sim_a',
          $profil['ft_sim_a']
        ];
      }

      $this->hapusFotoPenyewa($fotoLama);

      $_SESSION['flash_profil_penyewa'] =
        'Profil berhasil diperbarui.';

      header('Location: ' . site_url('penyewa/profil'));
      exit;
    } catch (Throwable $e) {
      error_log('Update profil penyewa gagal: ' . $e->getMessage());

      if (!empty($uploadedFiles)) {
        $this->hapusFotoPenyewa($uploadedFiles);
      }

      $this->renderProfilError(
        $profil ?? [],
        $old,
        'Profil belum berhasil diperbarui. Silakan coba kembali.'
      );
    }
  }

  private function validateProfilInput(
    string $nik,
    string $nama,
    string $noHp,
    string $alamat
  ): ?string {
    if (!preg_match('/\A[0-9]{16}\z/', $nik)) {
      return 'NIK wajib terdiri dari tepat 16 digit angka.';
    }

    if (
      $nama === '' ||
      mb_strlen($nama) > 100 ||
      !preg_match(
        "/\A[\p{L}\p{M}]+(?:[ .'-][\p{L}\p{M}]+)*\z/u",
        $nama
      )
    ) {
      return 'Nama lengkap wajib diisi, maksimal 100 karakter, dan hanya berisi huruf serta pemisah nama yang wajar.';
    }

    if (
      $noHp === '' ||
      strlen($noHp) > 15 ||
      !preg_match('/\A[0-9+(). -]+\z/', $noHp) ||
      !preg_match('/[0-9]/', $noHp)
    ) {
      return 'Nomor HP wajib diisi, maksimal 15 karakter, dan hanya boleh berisi angka serta tanda +, titik, kurung, spasi, atau tanda hubung.';
    }

    if (
      $alamat === '' ||
      mb_strlen($alamat) > 300 ||
      preg_match('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', $alamat)
    ) {
      return 'Alamat wajib diisi, maksimal 300 karakter, dan tidak boleh mengandung karakter kontrol.';
    }

    return null;
  }

  private function renderProfilError(
    array $profil,
    array $old,
    string $error
  ): void {
    $userPlg = trim((string) ($_SESSION['penyewa_user_plg'] ?? ''));
    $jumlahKeranjang = $userPlg === ''
    ? 0
    : $this->transaksiModel->getJumlahMobilKeranjang($userPlg);
  
  $this->view('penyewa/profil', [
      'profil' => $profil,
      'flash' => null,
      'error' => $error,
      'old' => $old
    ]);
  }

  private function uploadFotoPenyewa(string $field): array
  {
    if (!in_array($field, ['ft_ktp', 'ft_sim_a'], true)) {
      return [
        'success' => false,
        'filename' => null,
        'error' => 'Field foto tidak valid.'
      ];
    }

    if (
      !isset($_FILES[$field]) ||
      ($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE)
      === UPLOAD_ERR_NO_FILE
    ) {
      return [
        'success' => true,
        'filename' => null,
        'error' => null
      ];
    }

    $file = $_FILES[$field];

    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
      return [
        'success' => false,
        'filename' => null,
        'error' => 'Unggah foto gagal. Periksa ukuran file dan konfigurasi PHP.'
      ];
    }

    if (
      !isset($file['tmp_name'], $file['size']) ||
      !is_uploaded_file($file['tmp_name']) ||
      (int) $file['size'] < 1 ||
      (int) $file['size'] > 5 * 1024 * 1024
    ) {
      return [
        'success' => false,
        'filename' => null,
        'error' => 'Foto harus berukuran lebih dari 0 byte dan maksimal 5 MB.'
      ];
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);

    $allowed = [
      'image/jpeg' => 'jpg',
      'image/png' => 'png',
      'image/webp' => 'webp'
    ];

    if (
      !isset($allowed[$mime]) ||
      @getimagesize($file['tmp_name']) === false
    ) {
      return [
        'success' => false,
        'filename' => null,
        'error' => 'Format foto harus JPEG, PNG, atau WEBP yang valid.'
      ];
    }

    $projectRoot = dirname(APPPATH);
    $uploadDir = $projectRoot . DIRECTORY_SEPARATOR . 'uploads'
      . DIRECTORY_SEPARATOR . 'penyewa' . DIRECTORY_SEPARATOR;

    if (
      !is_dir($uploadDir) &&
      !mkdir($uploadDir, 0755, true) &&
      !is_dir($uploadDir)
    ) {
      return [
        'success' => false,
        'filename' => null,
        'error' => 'Folder penyimpanan foto penyewa tidak dapat dibuat.'
      ];
    }

    if (!is_writable($uploadDir)) {
      return [
        'success' => false,
        'filename' => null,
        'error' => 'Folder penyimpanan foto penyewa tidak dapat ditulis.'
      ];
    }

    try {
      $filename = $field . '_' . date('YmdHis') . '_'
        . bin2hex(random_bytes(8)) . '.' . $allowed[$mime];
    } catch (Throwable $e) {
      return [
        'success' => false,
        'filename' => null,
        'error' => 'Nama file foto gagal dibuat.'
      ];
    }

    if (!move_uploaded_file(
      $file['tmp_name'],
      $uploadDir . $filename
    )) {
      return [
        'success' => false,
        'filename' => null,
        'error' => 'Foto gagal dipindahkan ke folder penyimpanan.'
      ];
    }

    return [
      'success' => true,
      'filename' => $filename,
      'error' => null
    ];
  }

  private function hapusFotoPenyewa(array $files): void
  {
    $uploadDir = dirname(APPPATH) . DIRECTORY_SEPARATOR . 'uploads'
      . DIRECTORY_SEPARATOR . 'penyewa' . DIRECTORY_SEPARATOR;

    foreach ($files as $item) {
      if (is_array($item)) {
        [$field, $filename] = $item;
      } else {
        // File baru yang diunggah pada request ini.
        $filename = $item;
        $field = is_string($filename)
          ? (str_starts_with($filename, 'ft_ktp_') ? 'ft_ktp' : 'ft_sim_a')
          : '';
      }

      if (
        !in_array($field, ['ft_ktp', 'ft_sim_a'], true) ||
        !is_string($filename)
      ) {
        continue;
      }

      // Nama file baru dan pola file lama yang telah ada di data.
      $pattern = '/^' . preg_quote($field, '/') .
        '_\d{10,14}_[a-f0-9]{12,16}\.(jpg|jpeg|png|webp)$/';

      if (!preg_match($pattern, $filename)) {
        continue;
      }

      $path = $uploadDir . $filename;

      if (is_file($path)) {
        @unlink($path);
      }
    }
  }
}
