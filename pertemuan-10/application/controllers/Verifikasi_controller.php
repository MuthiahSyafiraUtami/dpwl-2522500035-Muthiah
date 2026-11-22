
<?php

require_once APPPATH . 'models/Pembayaran_model.php';

class Verifikasi_controller extends Controller
{
    private Pembayaran_model $transaksiModel;

    public function __construct()
    {
        require_once APPPATH . 'helpers/auth_helper.php';
        require_once APPPATH . 'helpers/flash_helper.php';

        $this->transaksiModel = new Pembayaran_model();
    }

    public function index(): void
    {
        require_admin_login();

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            exit('Metode request tidak diizinkan.');
        }

        try {
            $pembayaran = $this->transaksiModel
                ->getPembayaranMenungguVerifikasi();

            $this->view('admin/verifikasi_pembayaran_view', [
                'pembayaran' => $pembayaran,
                'flash' => get_flash_message()
            ]);

        } catch (Throwable $e) {
            error_log('Daftar verifikasi gagal: ' . $e->getMessage());

            http_response_code(500);
            exit('Daftar pembayaran belum dapat ditampilkan.');
        }
    }

    public function proses(): void
    {
        require_admin_login();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Metode request tidak diizinkan.');
        }

        $kodeBayar = trim((string) ($_POST['kode_bayar'] ?? ''));
        $aksi = trim((string) ($_POST['aksi'] ?? ''));

        try {
            if ($kodeBayar === '') {
                throw new InvalidArgumentException(
                    'Kode pembayaran wajib diisi.'
                );
            }

            $this->transaksiModel->verifikasiPembayaran(
                $kodeBayar,
                $aksi
            );

            set_flash_message(
                'success',
                $aksi === 'terima'
                    ? 'Pembayaran berhasil diterima.'
                    : 'Pembayaran berhasil ditolak.'
            );

        } catch (InvalidArgumentException $e) {
            set_flash_message('danger', $e->getMessage());

        } catch (Throwable $e) {
            error_log('Proses verifikasi gagal: ' . $e->getMessage());

            set_flash_message(
                'danger',
                'Verifikasi gagal diproses. Silakan coba kembali.'
            );
        }

        header('Location: ' . site_url('admin/verifikasi-pembayaran'));
        exit;
    }
}
