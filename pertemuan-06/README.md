# pertemuan-06

## 1. Tahapan Pengembangan

### Tahap Persiapan — Pemeriksaan Proyek P5

**Kegiatan:**
- Memeriksa struktur folder dan berkas aplikasi dari proyek P5.
- Melanjutkan pengembangan aplikasi yang sudah dibuat sebelumnya.
- Mempertahankan struktur MVC dan fitur P5 yang masih digunakan.

**Berkas/komponen terkait:** Struktur aplikasi, konfigurasi, model, controller, view, dan basis data dari proyek P5.

**Pengujian:** Memeriksa aplikasi dan fitur P5 yang diperlukan untuk pengembangan P6.

**Hasil aktual:** Pengembangan P6 dilakukan dengan melanjutkan proyek P5 yang sudah tersedia.

### Tahap A — Integrasi TemplateMo

**Kegiatan:**
- Menyiapkan aset TemplateMo Zay Shop.
- Mengintegrasikan tampilan template ke dalam aplikasi.
- Menyesuaikan header, navigasi, footer, CSS, JavaScript, gambar, dan webfonts sesuai kebutuhan.

**Berkas/komponen terkait:**
- `assets/zay/`
- View antarmuka aplikasi.

**Pengujian:** Memeriksa tampilan halaman, aset template, dan navigasi aplikasi.

**Hasil aktual:** Template berhasil diintegrasikan dan tampilan aplikasi dapat ditampilkan.

### Tahap B — Katalog Kendaraan Berbasis MVC

**Kegiatan:**
- Mengambil data kendaraan dari basis data.
- Menghubungkan model, controller, route, dan view untuk halaman katalog.
- Menampilkan informasi kendaraan, harga sewa, status, dan foto.

**Berkas/komponen terkait:**
- `application/models/Mobil_model.php`
- `application/controllers/Katalog_controller.php`
- `application/config/routes.php`
- `application/views/katalog/header.php`
- `application/views/katalog/navbar.php`
- `application/views/katalog/footer.php`
- `application/views/katalog/index.php`

**Pengujian:** Membuka halaman katalog dan memeriksa data kendaraan, harga sewa, status, serta foto yang ditampilkan.

**Hasil aktual:** Daftar kendaraan berhasil ditampilkan pada halaman katalog. Kendala unggah foto Honda Brio yang ditemukan selama pengujian telah diperbaiki dan proses unggah berhasil dilakukan.

### Tahap C — Detail Kendaraan

**Kegiatan:**
- Menambahkan route untuk halaman detail kendaraan.
- Menambahkan method detail pada controller katalog.
- Menampilkan informasi dan foto kendaraan yang dipilih.

**Berkas/komponen terkait:**
- `application/config/routes.php`
- `application/controllers/Katalog_controller.php`
- `application/views/katalog/detail.php`

**Pengujian:** Memilih foto atau nama kendaraan pada katalog dan memeriksa informasi yang ditampilkan pada halaman detail.

**Hasil aktual:** Informasi detail kendaraan berhasil ditampilkan saat kendaraan dipilih.

### Tahap D — Registrasi Akun Penyewa

**Kegiatan:**
- Menambahkan route untuk registrasi penyewa.
- Membuat model penyewa untuk mengelola data penyewa.
- Menghubungkan proses registrasi dengan controller dan view formulir.

**Berkas/komponen terkait:**
- `application/config/routes.php`
- `application/models/Penyewa_model.php`
- `application/controllers/Auth.php`
- View registrasi penyewa.

**Pengujian:** Menguji fitur registrasi penyewa pada aplikasi.

**Hasil aktual:** Fitur registrasi penyewa berhasil dijalankan.

### Tahap E — Login, Sesi, dan Logout Penyewa

**Kegiatan:**
- Menambahkan route login dan logout penyewa.
- Menghubungkan proses login dengan data akun penyewa.
- Mengatur sesi setelah login dan proses logout untuk mengakhiri sesi.

**Berkas/komponen terkait:**
- `application/config/routes.php`
- `application/controllers/Auth.php`
- `application/models/Penyewa_model.php`
- View login penyewa.

**Pengujian:** Menguji proses login dan logout penyewa pada aplikasi.

**Hasil aktual:** Fitur login dan logout penyewa berhasil dijalankan.

### Tahap F — Profil dan Pembaruan Data Penyewa

**Kegiatan:**
- Menambahkan route dan controller untuk halaman profil penyewa.
- Menghubungkan data profil dengan model penyewa.
- Membuat formulir untuk memperbarui data profil.

**Berkas/komponen terkait:**
- `application/config/routes.php`
- `application/controllers/Penyewa_controller.php`
- `application/models/Penyewa_model.php`
- `application/views/penyewa/profil.php`

**Pengujian:** Membuka halaman profil dan menguji pembaruan data penyewa.

**Hasil aktual:** Data profil penyewa dapat ditampilkan dan diperbarui.

### Tahap G — Menghilangkan `index.php` dari URL

**Kegiatan:**
- Mengatur `.htaccess` agar URL dapat diakses tanpa menuliskan `index.php`.
- Menyesuaikan cara aplikasi membaca URL pada front controller.
- Mengubah konfigurasi `index_page`.
- Menyesuaikan helper `site_url()`.
- Menyesuaikan route untuk halaman utama aplikasi.

**Berkas/komponen terkait:**
- `.htaccess`
- `index.php`
- `application/config/config.php`
- `application/helpers/url_helper.php`
- `application/config/routes.php`

**Pengujian:** Mengakses halaman aplikasi tanpa `index.php` dan memeriksa apakah halaman dapat dibuka dengan benar.

**Hasil aktual:** Aplikasi dapat diakses menggunakan URL tanpa menuliskan `index.php`.

## 2. Catatan Kendala dan Perbaikan

### Kendala Unggah Foto Kendaraan Honda Brio

Saat melakukan pengunggahan data dan foto kendaraan Honda Brio, sistem menampilkan pesan **“Jenis mobil tidak valid.”** sehingga proses pengunggahan tidak dapat dilanjutkan.

### Penyebab Kendala

Kendala disebabkan oleh kesalahan penulisan (*typo*) pada jenis mobil di bagian validasi dalam `Mobil_controller`. Akibatnya, nilai jenis mobil yang dikirimkan tidak sesuai dengan nilai yang diperiksa oleh sistem.

Kode validasi yang terkait dengan kendala tersebut adalah:

```php
if (!in_array($data['jns_mobil'] ?? '', ['SUV', 'MPV', 'City Car'], true)) {
    return 'Jenis mobil tidak valid.';
}
```

### Perbaikan yang Dilakukan

Memperbaiki kesalahan penulisan jenis mobil pada bagian validasi di `Mobil_controller` agar sesuai dengan nilai jenis mobil yang digunakan dalam aplikasi.

### Hasil Perbaikan

Setelah kesalahan penulisan diperbaiki, proses pengunggahan kendaraan Honda Brio berhasil dilakukan kembali.

**Status:** Kendala berhasil diperbaiki dan proses unggah kendaraan berhasil diuji kembali.

## 3. Rekapitulasi Status Pengujian

| Fitur | Status | Hasil Pengujian |
|---|---|---|
| Integrasi TemplateMo | Berhasil | Template berhasil diintegrasikan dan tampilan aplikasi dapat ditampilkan. |
| Katalog kendaraan | Berhasil | Daftar kendaraan berhasil ditampilkan pada halaman katalog. |
| Detail kendaraan | Berhasil | Informasi detail kendaraan berhasil ditampilkan saat kendaraan dipilih. |
| Registrasi penyewa | Berhasil | Fitur registrasi penyewa berhasil dijalankan. |
| Login dan logout penyewa | Berhasil | Fitur login dan logout penyewa berhasil dijalankan. |
| Profil dan pembaruan data | Berhasil | Data profil penyewa dapat ditampilkan dan diperbarui. |
| URL tanpa `index.php` | Berhasil | Aplikasi dapat diakses menggunakan URL tanpa menuliskan `index.php`. |
| Unggah foto kendaraan Honda Brio | Berhasil setelah perbaikan | Kesalahan penulisan jenis mobil pada validasi telah diperbaiki dan proses unggah berhasil dilakukan kembali. |

## 4. Kesimpulan

Pengembangan P6 merupakan lanjutan dari proyek P5 pada aplikasi penyewaan kendaraan. Pengembangan mencakup integrasi template, pembuatan katalog dan detail kendaraan, fitur registrasi serta login dan logout penyewa, pengelolaan profil, dan pengaturan URL agar dapat diakses tanpa menuliskan `index.php`.

Berdasarkan pengujian yang dilakukan, fitur-fitur aplikasi berhasil dijalankan sesuai fungsinya. Pada proses unggah foto kendaraan Honda Brio, ditemukan kendala berupa pesan “Jenis mobil tidak valid.” Kendala tersebut disebabkan oleh kesalahan penulisan jenis mobil pada bagian validasi di `Mobil_controller`. Setelah kesalahan penulisan diperbaiki, proses unggah kendaraan berhasil dilakukan kembali.