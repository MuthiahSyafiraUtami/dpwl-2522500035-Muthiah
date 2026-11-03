# pertemuan-07
# P7 — Implementasi Keranjang Transaksi pada Sistem Rental Kendaraan

## A. Deskripsi dan Tujuan Praktikum

Praktikum P7 membahas implementasi transaksi pada sistem rental kendaraan menggunakan pola Header-Detail, mulai dari penambahan kendaraan ke keranjang hingga proses konfirmasi dan checkout.

**Tujuan Praktikum:**
1. Memahami penerapan pola Header-Detail pada transaksi.
2. Mengimplementasikan fitur keranjang untuk menyimpan kendaraan pilihan penyewa.
3. Mengintegrasikan pengelolaan keranjang, konfirmasi transaksi, dan checkout ke dalam sistem rental kendaraan.
## B. Membuat Fondasi Model dan Controller Transaksi

### B.1. Model Transaksi

**File:** `application/models/Transaksi_model.php`

Model dibuat untuk mengelola data transaksi. Implementasi mencakup pembuatan kode sewa berformat `INV/YYYYMMDD/NN`, penguncian menggunakan `GET_LOCK`, pelepasan kunci menggunakan `RELEASE_LOCK`, serta pengelolaan data melalui database.

### B.2. Controller Transaksi

**File:** `application/controllers/Transaksi_controller.php`

Controller dibuat untuk menangani proses transaksi, termasuk validasi login penyewa, metode permintaan, nomor polisi kendaraan, pengalihan halaman, dan notifikasi.

### B.3. Routing

**File:** `application/config/routes.php`

Menambahkan route `transaksi/tambah` yang mengarah ke method `tambah()` pada `Transaksi_controller`.

**Hasil pengujian:** Fondasi model, controller, dan route berhasil disiapkan.

## C. Integrasi Tombol Tambah ke Keranjang

### C.1. Halaman Detail Kendaraan

**File:** `application/views/katalog/detail.php`

Menyesuaikan form tambah ke keranjang berdasarkan ketersediaan kendaraan dan status login penyewa. Form mengirimkan `no_plat` serta parameter `return_to=detail` melalui metode POST.

### C.2. Halaman Katalog Kendaraan

**File:** `application/views/katalog/index.php`

Menyesuaikan tombol tambah ke keranjang pada kartu kendaraan, mengatur tombol berdasarkan ketersediaan, serta mengirimkan `no_plat` dan `return_to=katalog`.

**Hasil pengujian:** Form dan tombol tambah ke keranjang berhasil diintegrasikan pada katalog dan detail kendaraan.

## D. Integrasi Navigasi dan Jumlah Keranjang

### D.1. Penyesuaian Navbar

**File:** `application/views/katalog/navbar.php`

Menambahkan tautan menuju `transaksi/keranjang`, menampilkan jumlah kendaraan melalui `$jumlahKeranjang`, serta menampilkan notifikasi transaksi.

### D.2. Fungsi Penghitungan Keranjang

**File:** `application/models/Transaksi_model.php`

Menambahkan method `getJumlahMobilKeranjang(string $userPlg): int` untuk menghitung kendaraan pada keranjang aktif penyewa melalui tabel `t_pilih` dan `t_sewa`.

### D.3. Integrasi Katalog Controller

**File:** `application/controllers/Katalog_controller.php`

Menambahkan pemanggilan dan inisialisasi `Transaksi_model`, kemudian mengirimkan jumlah keranjang ke halaman katalog dan detail kendaraan. Jumlah bernilai `0` jika penyewa belum login.

### D.4. Integrasi Penyewa Controller

**File:** `application/controllers/Penyewa_controller.php`

Menambahkan integrasi `Transaksi_model` agar jumlah keranjang tetap ditampilkan pada navbar halaman profil penyewa.

Perubahan meliputi:
1. Memanggil `Transaksi_model.php` menggunakan `require_once`.
2. Menambahkan dan menginisialisasi properti `$transaksiModel`.
3. Menghitung jumlah keranjang pada method `profil()` melalui `getJumlahMobilKeranjang($userPlg)`.
4. Mengirimkan `$jumlahKeranjang` ke view `penyewa/profil`.
5. Mempertahankan data jumlah keranjang saat validasi formulir gagal.
6. Memperbarui `renderProfilError()` agar jumlah keranjang tetap dikirim ketika pembaruan profil mengalami kesalahan.

**Pengujian:**
- Memeriksa navbar dan notifikasi pada katalog.
- Memastikan tautan keranjang mengarah ke halaman yang sesuai.
- Memeriksa jumlah keranjang pada profil penyewa.
- Menguji pembaruan profil menggunakan data valid dan tidak valid.
- Memastikan halaman katalog dan detail tetap berjalan.

**Hasil pengujian:** Seluruh skenario berhasil.

## E. Mengintegrasikan Proses Penambahan Kendaraan ke Keranjang

### E.1. Method `tambahKeKeranjang()`

**File:** `application/models/Transaksi_model.php`

Model dikembangkan menggunakan pola Header-Detail: informasi transaksi disimpan pada `t_sewa`, sedangkan kendaraan pilihan disimpan pada `t_pilih`.

Implementasi meliputi:
- Helper `namaKunciKeranjang()` untuk mengidentifikasi kunci keranjang penyewa.
- Helper `kunciKendaraan()` untuk memeriksa dan mengunci data kendaraan.
- Helper `hitungHariSewa()` untuk validasi tanggal dan durasi sewa.
- Helper `normalisasiWaktu()` untuk validasi waktu pengambilan.
- Method `tambahKeKeranjang()` untuk mencari atau membuat keranjang dan menyimpan kendaraan pilihan.
- Prepared statement MySQLi, transaksi database, penguncian, dan penanganan kesalahan untuk menjaga konsistensi data.

**Pengujian:**
1. Pemeriksaan sintaks PHP menggunakan `php -l`: **Berhasil**.
2. Menambahkan kendaraan ke keranjang: **Berhasil**.
3. Menambahkan kendaraan yang sama untuk kedua kalinya: **Berhasil dicegah**.

**Kesimpulan:** Proses penambahan kendaraan ke keranjang berjalan sesuai hasil pengujian.

## F. Implementasi Keranjang dan Checkout

### F.1. Membuat Halaman Isi Keranjang

**File:** `application/views/transaksi/keranjang.php`

Halaman menampilkan kode transaksi, status sewa, periode penyewaan, waktu pengambilan, daftar kendaraan, foto, harga per hari, durasi, subtotal, total biaya, dan notifikasi.

Disediakan formulir pembaruan periode, penghapusan kendaraan, serta tombol menuju checkout. Data ditampilkan dengan bantuan `htmlspecialchars()`, sedangkan JavaScript digunakan untuk membantu validasi periode dan waktu pengambilan minimal dua jam dari waktu sekarang.

**Pengujian:** Pemeriksaan sintaks PHP berhasil tanpa kesalahan.

### F.2. Menambahkan Method Keranjang pada Controller Transaksi

**File yang diperbarui:**
- `application/controllers/Transaksi_controller.php`
- `application/models/Transaksi_model.php`
- `application/config/routes.php`

Method controller yang ditambahkan:
- `keranjang()` untuk menampilkan keranjang penyewa.
- `perbaruiPeriode()` untuk memperbarui periode dan waktu pengambilan.
- `hapus()` untuk menghapus kendaraan dari keranjang.
- `checkout()` untuk menampilkan konfirmasi dan memproses pengajuan transaksi.
- `redirectDenganPesan()` untuk mengatur pengalihan halaman dan notifikasi.

Method model yang ditambahkan:
- `validasiWaktuMulai()`
- `perbaruiPeriodeKeranjang()`
- `getKeranjang()`
- `hapusDariKeranjang()`
- `checkout()`
- `getKodeKeranjangAktif()`

Route yang digunakan:

```php
$route['transaksi/tambah'] = 'Transaksi_controller/tambah';
$route['transaksi/keranjang'] = 'Transaksi_controller/keranjang';
$route['transaksi/perbarui-periode'] = 'Transaksi_controller/perbaruiPeriode';
$route['transaksi/hapus'] = 'Transaksi_controller/hapus';
$route['transaksi/hapus/(:any)'] = 'Transaksi_controller/hapus/$1';
$route['transaksi/checkout'] = 'Transaksi_controller/checkout';
```

**Pengujian:**

| No. | Skenario Pengujian | Hasil |
|---|---|---|
| 1 | Menampilkan keranjang aktif milik penyewa | Berhasil |
| 2 | Mengarahkan penyewa tanpa keranjang ke katalog dengan notifikasi | Berhasil |
| 3 | Menampilkan jumlah kendaraan yang sesuai pada navbar | Berhasil |
| 4 | Memperbarui periode dan waktu pengambilan | Berhasil |
| 5 | Menghapus kendaraan dari keranjang | Berhasil |
| 6 | Memeriksa sintaks `Transaksi_model.php` | Berhasil |

**Kesimpulan:** Fitur keranjang, pembaruan periode, dan penghapusan kendaraan berjalan sesuai hasil pengujian.

### F.3. Implementasi Halaman Konfirmasi Transaksi

#### F.3.1. Membuat View Konfirmasi

**File:** `application/views/transaksi/konfirmasi.php`

Halaman konfirmasi menampilkan kode transaksi, periode sewa, waktu pengambilan, daftar kendaraan, harga, durasi, subtotal, total biaya, DP sebesar 30%, dan sisa pembayaran.

Disediakan tombol **Kembali ke Keranjang** dan **Konfirmasi dan Ajukan Transaksi**.

**Hasil pengujian:** Halaman konfirmasi berhasil ditampilkan melalui checkout.

#### F.3.2. Pengujian Halaman Konfirmasi

| No. | Skenario Pengujian | Hasil |
|---|---|---|
| 1 | Membuka halaman konfirmasi melalui checkout | Berhasil |
| 2 | Menampilkan kode transaksi dan periode sewa | Berhasil |
| 3 | Menampilkan waktu pengambilan kendaraan | Berhasil |
| 4 | Menampilkan daftar kendaraan dan rincian biaya | Berhasil |
| 5 | Menampilkan total biaya penyewaan | Berhasil |
| 6 | Menghitung DP 30% dan sisa pembayaran | Berhasil |
| 7 | Kembali ke keranjang dengan transaksi yang sama | Berhasil |
| 8 | Membatasi akses berdasarkan kepemilikan dan status keranjang | Berhasil |

**Kesimpulan:** Halaman konfirmasi dan seluruh skenario pengujian berhasil.

#### F.3.3. Pengujian Proses Checkout

| No. | Skenario Pengujian | Hasil |
|---|---|---|
| 1 | Membuka halaman konfirmasi transaksi | Berhasil |
| 2 | Mengonfirmasi dan mengajukan transaksi | Berhasil |
| 3 | Menampilkan notifikasi menunggu persetujuan admin | Berhasil |
| 4 | Mengubah status `t_sewa` dari `keranjang` menjadi `diajukan` | Berhasil |
| 5 | Menyimpan catatan pembayaran pada `t_bayar` | Berhasil |
| 6 | Mencatat jenis pembayaran `dp` dan metode `transfer` | Berhasil |
| 7 | Menyimpan nominal DP sebesar 30% dari total sewa | Berhasil |
| 8 | Mencatat status pembayaran `pending` | Berhasil |
| 9 | Mencegah transaksi yang sudah diajukan untuk diajukan kembali | Berhasil |

**Kesimpulan:** Proses checkout berhasil. Transaksi diajukan kepada admin dan catatan pembayaran DP tersimpan dengan status `pending`. Checkout merupakan pengajuan transaksi, bukan bukti pembayaran lunas atau persetujuan admin.

## G. Kesimpulan

Seluruh pengujian P7 berhasil, dan fitur keranjang hingga checkout telah terintegrasi dengan baik ke dalam sistem rental kendaraan.
