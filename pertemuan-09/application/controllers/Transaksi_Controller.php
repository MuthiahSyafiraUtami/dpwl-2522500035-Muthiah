<?php
require_once APPPATH . 'models/Transaksi_model.php';
class Transaksi_controller extends Controller
{
private Transaksi_model $transaksiModel;
public function __construct()
{
$this->transaksiModel = new Transaksi_model();
}
public function tambah(): void
{
$userPlg = $this->wajibLoginPenyewa();
$this->wajibMetode('POST');
$noPlat = trim((string) ($_POST['no_plat'] ?? ''));
$asal = (string) ($_POST['return_to'] ?? 'katalog');
$asal = $asal === 'detail' ? 'detail' : 'katalog';
if ($noPlat === '') {
$this->redirectTambahDenganPesan(
$asal,
$noPlat,
'error',
'Kendaraan wajib dipilih terlebih dahulu.'
);
}
try {
$this->transaksiModel->tambahKeKeranjang(
$userPlg,
$noPlat
);
$this->redirectTambahDenganPesan(
$asal,
$noPlat,
'success',
'Mobil berhasil ditambahkan ke keranjang.'
);
} catch (InvalidArgumentException $e) {
$this->redirectTambahDenganPesan(
$asal,
$noPlat,
'error',
$e->getMessage()
);
} catch (Throwable $e) {
error_log(
'Tambah keranjang gagal: ' . $e->getMessage()
);
$this->redirectTambahDenganPesan(
$asal,
$noPlat,
'error',
$this->pesanBisnisAman($e->getMessage())
);
}
}
private function wajibLoginPenyewa(): string
{
$userPlg = trim(
(string) ($_SESSION['penyewa_user_plg'] ?? '')
);
if ($userPlg === '') {
$_SESSION['flash_penyewa_nav'] =
'Silakan login terlebih dahulu untuk mengakses transaksi.';
header('Location: ' . site_url('auth/login-penyewa'));
exit;
}
return $userPlg;
}
private function wajibMetode(string $metodeDiizinkan): void
{
$metodeAktif = strtoupper(
(string) ($_SERVER['REQUEST_METHOD'] ?? 'GET')
);
if ($metodeAktif !== $metodeDiizinkan) {
http_response_code(405);
header('Allow: ' . $metodeDiizinkan);
exit('Method Not Allowed');
}
}
private function redirectTambahDenganPesan(
string $asal,
string $noPlat,
string $jenis,
string $pesan
): never {
$_SESSION['flash_transaksi'] = [
'type' => $jenis,
'message' => $pesan
];
if ($asal === 'detail' && $noPlat !== '') {
$uri = 'katalog/detail/' . rawurlencode($noPlat);
} else {
$uri = 'katalog';
}
header('Location: ' . site_url($uri));
exit;
}
private function pesanBisnisAman(string $pesan): string
{
$pesanDikenal = [
'Kendaraan tidak berstatus tersedia.',
'Kendaraan sudah ada dalam keranjang ini.',
'Kendaraan tidak ditemukan.',
'Nomor transaksi harian telah mencapai batas 99.',
'Kunci proses tidak diperoleh. Silakan coba lagi.'
];
return in_array($pesan, $pesanDikenal, true)
? $pesan
: 'Permintaan transaksi belum berhasil. Periksa data dan coba kembali.';
}

public function keranjang(string $kodeSewa = ''): void
{
$userPlg = $this->wajibLoginPenyewa();
$this->wajibMetode('GET');
$kodeSewa = trim($kodeSewa !== '' ? $kodeSewa : (string) ($_GET['kode_sewa'] ?? ''));
if ($kodeSewa === '') {
try {
$kodeSewa = $this->transaksiModel
->getKodeKeranjangAktif($userPlg);
if ($kodeSewa === null || $kodeSewa === '') {
$_SESSION['flash_transaksi'] = [
'type' => 'info',
'message' => 'Keranjang Anda masih kosong.'
];
header('Location: ' . site_url('katalog'));
exit;
}
} catch (Throwable $e) {
error_log(
'Pencarian keranjang aktif gagal: ' . $e->getMessage()
);
http_response_code(500);
exit('Keranjang belum dapat ditemukan. Silakan coba kembali.');
}
}
try {
$keranjang = $this->transaksiModel->getKeranjang($kodeSewa, $userPlg);
if ($keranjang === null) {
http_response_code(404);
exit('Keranjang tidak ditemukan atau bukan milik akun ini.');
}
$flash = $_SESSION['flash_transaksi'] ?? null;
unset($_SESSION['flash_transaksi']);
$this->view('transaksi/keranjang', [
'keranjang' => $keranjang,
'flash' => $flash,
'jumlahKeranjang' => $this->transaksiModel->getJumlahMobilKeranjang($userPlg)
]);
} catch (Throwable $e) {
error_log('Tampilan keranjang gagal: ' . $e->getMessage());
http_response_code(500);
exit('Keranjang belum dapat ditampilkan. Silakan coba kembali.');
}
}
public function perbaruiPeriode(): void
{
$userPlg = $this->wajibLoginPenyewa();
$this->wajibMetode('POST');
$kodeSewa = trim((string) ($_POST['kode_sewa'] ?? ''));
$tglMulai = trim((string) ($_POST['tgl_mulai'] ?? ''));
$tglSelesai = trim((string) ($_POST['tgl_selesai'] ?? ''));
$wktAmbil = trim((string) ($_POST['wkt_ambil'] ?? ''));
if ($kodeSewa === '') {
http_response_code(400);
exit('Kode transaksi wajib diisi.');
}
try {
$this->transaksiModel->perbaruiPeriodeKeranjang(
$kodeSewa,
$userPlg,
$tglMulai,
$tglSelesai,
$wktAmbil
);
$this->redirectDenganPesan(
'transaksi/keranjang?kode_sewa=' . rawurlencode($kodeSewa),
'success',
'Periode dan waktu pengambilan berhasil diperbarui.'
);
} catch (InvalidArgumentException $e) {
$this->redirectDenganPesan(
'transaksi/keranjang?kode_sewa=' . rawurlencode($kodeSewa),
'error',
$e->getMessage()
);
} catch (Throwable $e) {
error_log('Pembaruan periode keranjang gagal: ' . $e->getMessage());
$this->redirectDenganPesan(
'transaksi/keranjang?kode_sewa=' . rawurlencode($kodeSewa),
'error',
$this->pesanBisnisAman($e->getMessage())
);
}
}
public function hapus(): void
{
$userPlg = $this->wajibLoginPenyewa();
$this->wajibMetode('POST');
$kodeSewa = trim((string) ($_POST['kode_sewa'] ?? ''));
$noPlat = trim((string) ($_POST['no_plat'] ?? ''));
if ($kodeSewa === '' || $noPlat === '') {
http_response_code(400);
exit('Kode transaksi dan kendaraan wajib diisi.');
}
try {
$berhasil = $this->transaksiModel->hapusDariKeranjang(
$kodeSewa,
$userPlg,
$noPlat
);
$this->redirectDenganPesan(
'transaksi/keranjang?kode_sewa=' . rawurlencode($kodeSewa),
$berhasil ? 'success' : 'error',
$berhasil
? 'Kendaraan berhasil dihapus dari keranjang.'
: 'Kendaraan tidak ditemukan dalam keranjang atau keranjang tidak dapat diubah.'
);
} catch (Throwable $e) {
error_log('Hapus item keranjang gagal: ' . $e->getMessage());
$this->redirectDenganPesan(
'transaksi/keranjang?kode_sewa=' . rawurlencode($kodeSewa),
'error',
'Kendaraan belum berhasil dihapus. Silakan coba kembali.'
);
}
}
public function checkout(): void
{
$userPlg = $this->wajibLoginPenyewa();
$metode = strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'));
if ($metode === 'GET') {
$this->wajibMetode('GET');
$kodeSewa = trim((string) ($_GET['kode_sewa'] ?? ''));
if ($kodeSewa === '') {
$this->redirectDenganPesan(
'transaksi/keranjang',
'error',
'Kode transaksi tidak ditemukan. Periksa kembali keranjang Anda.'
);
}
try {
$keranjang = $this->transaksiModel->getKeranjang($kodeSewa, $userPlg);
if ($keranjang === null) {
http_response_code(404);
exit('Keranjang tidak ditemukan, bukan milik akun ini, atau tidak lagi berstatus
keranjang.');
}
if (empty($keranjang['detail'])) {
$this->redirectDenganPesan(
'transaksi/keranjang?kode_sewa=' . rawurlencode($kodeSewa),
'error',
'Keranjang kosong. Tambahkan kendaraan sebelum checkout.'
);
}
$total = (int) ($keranjang['total'] ?? 0);
$dp = (int) round($total * 30 / 100);
$sisa = $total - $dp;
$this->view('transaksi/konfirmasi', [
'keranjang' => $keranjang,
'total' => $total,
'dp' => $dp,
'sisa' => $sisa,
'jumlahKeranjang' => $this->transaksiModel->getJumlahMobilKeranjang($userPlg)
]);
return;
} catch (Throwable $e) {
error_log('Tampilan konfirmasi checkout gagal: ' . $e->getMessage());
http_response_code(500);
exit('Konfirmasi checkout belum dapat ditampilkan. Silakan coba kembali.');
}
}
$this->wajibMetode('POST');
$kodeSewa = trim((string) ($_POST['kode_sewa'] ?? ''));
if ($kodeSewa === '') {
http_response_code(400);
exit('Kode transaksi wajib diisi.');
}
try {
// Model memvalidasi ulang pemilik, status keranjang, detail, periode,
// dan ketersediaan kendaraan di dalam transaksi database.
$berhasil = $this->transaksiModel->checkout($kodeSewa, $userPlg);
if (!$berhasil) {
$this->redirectDenganPesan(
'transaksi/keranjang?kode_sewa=' . rawurlencode($kodeSewa),
'error',
'Checkout belum berhasil. Periksa kembali keranjang Anda.'
);
}
$_SESSION['flash_penyewa_nav'] =
'Checkout berhasil. Transaksi diajukan dan menunggu persetujuan admin.';
header('Location: ' . site_url('katalog'));
exit;
} catch (Throwable $e) {
error_log('Checkout transaksi gagal: ' . $e->getMessage());
$this->redirectDenganPesan(
'transaksi/keranjang?kode_sewa=' . rawurlencode($kodeSewa),
'error',
$this->pesanBisnisAman($e->getMessage())
);
}
}
private function redirectDenganPesan(
string $uri,
string $jenis,
string $pesan
): never {
$_SESSION['flash_transaksi'] = [
'type' => $jenis,
'message' => $pesan
];
header('Location: ' . site_url($uri));
exit;
}


public function pembayaran(): void
{
    $userPlg = $this->wajibLoginPenyewa();
    $this->wajibMetode('GET');

    try {
        // Ambil data pembayaran milik penyewa yang sedang login.
        $pembayaran = $this->transaksiModel
            ->getPembayaranPenyewa($userPlg);

        // Ambil pesan notifikasi.
        $flash = $_SESSION['flash_transaksi'] ?? null;
        unset($_SESSION['flash_transaksi']);

        // Tampilkan halaman pembayaran.
        $this->view('transaksi/pembayaran', [
            'pembayaran' => $pembayaran,
            'flash' => $flash
        ]);

    } catch (Throwable $e) {
        error_log(
            'Tampilan pembayaran penyewa gagal: ' . $e->getMessage()
        );

        http_response_code(500);
        exit('Halaman pembayaran belum dapat ditampilkan. Silakan coba kembali.');
    }
}


public function uploadBuktiPembayaran(): void
{
    $userPlg = $this->wajibLoginPenyewa();
    $this->wajibMetode('POST');

    $kodeBayar = trim((string) ($_POST['kode_bayar'] ?? ''));

    if ($kodeBayar === '') {
        $this->redirectDenganPesan(
            'transaksi/pembayaran',
            'error',
            'Kode pembayaran tidak ditemukan.'
        );
    }

    $file = $_FILES['ft_byr'] ?? null;

    if (
        !$file ||
        ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE
    ) {
        $this->redirectDenganPesan(
            'transaksi/pembayaran',
            'error',
            'Silakan pilih bukti pembayaran terlebih dahulu.'
        );
    }

    try {
        // Pastikan pembayaran merupakan milik penyewa yang login.
        $pembayaran = $this->transaksiModel
            ->getDetailPembayaranPenyewa($kodeBayar, $userPlg);

        if ($pembayaran === null) {
            http_response_code(404);
            exit('Pembayaran tidak ditemukan atau bukan milik akun Anda.');
        }

        if ($pembayaran['sttus_byr'] !== 'pending') {
            $this->redirectDenganPesan(
                'transaksi/pembayaran',
                'error',
                'Pembayaran yang sudah diverifikasi tidak dapat diubah.'
            );
        }

        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            throw new InvalidArgumentException('Upload bukti pembayaran gagal.');
        }

        if (
            !isset($file['tmp_name'], $file['size']) ||
            !is_uploaded_file($file['tmp_name']) ||
            (int) $file['size'] < 1 ||
            (int) $file['size'] > 5 * 1024 * 1024
        ) {
            throw new InvalidArgumentException(
                'Ukuran bukti pembayaran harus lebih dari 0 byte dan maksimal 5 MB.'
            );
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);

        $allowed = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'application/pdf' => 'pdf',
        ];

        if (!isset($allowed[$mime])) {
            throw new InvalidArgumentException(
                'Format bukti pembayaran harus JPG, PNG, WEBP, atau PDF.'
            );
        }

        // Validasi tambahan untuk file gambar.
        if (
            str_starts_with($mime, 'image/') &&
            @getimagesize($file['tmp_name']) === false
        ) {
            throw new InvalidArgumentException('File gambar tidak valid.');
        }

        $uploadDir = dirname(APPPATH)
            . DIRECTORY_SEPARATOR . 'uploads'
            . DIRECTORY_SEPARATOR . 'bayar'
            . DIRECTORY_SEPARATOR;

        if (
            !is_dir($uploadDir) &&
            !mkdir($uploadDir, 0755, true) &&
            !is_dir($uploadDir)
        ) {
            throw new RuntimeException('Folder upload bukti pembayaran gagal dibuat.');
        }

        if (!is_writable($uploadDir)) {
            throw new RuntimeException('Folder upload bukti pembayaran tidak dapat ditulis.');
        }

        $namaFile = 'bukti_' . date('YmdHis') . '_'
            . bin2hex(random_bytes(8)) . '.' . $allowed[$mime];

        $tujuan = $uploadDir . $namaFile;

        if (!move_uploaded_file($file['tmp_name'], $tujuan)) {
            throw new RuntimeException('File bukti pembayaran gagal disimpan.');
        }

        try {
            $berhasil = $this->transaksiModel->simpanBuktiPembayaran(
                $kodeBayar,
                $userPlg,
                $namaFile
            );
        } catch (Throwable $e) {
            @unlink($tujuan);
            throw $e;
        }

        if (!$berhasil) {
            @unlink($tujuan);

            $this->redirectDenganPesan(
                'transaksi/pembayaran',
                'error',
                'Bukti tidak tersimpan. Periksa kembali status pembayaran.'
            );
        }

        $this->redirectDenganPesan(
            'transaksi/pembayaran',
            'success',
            'Bukti pembayaran berhasil diunggah dan menunggu verifikasi admin.'
        );

    } catch (InvalidArgumentException $e) {
        $this->redirectDenganPesan(
            'transaksi/pembayaran',
            'error',
            $e->getMessage()
        );
    } catch (Throwable $e) {
        error_log('Upload bukti pembayaran gagal: ' . $e->getMessage());

        $this->redirectDenganPesan(
            'transaksi/pembayaran',
            'error',
            'Bukti pembayaran gagal diunggah. Silakan coba kembali.'
        );
    }
}
}