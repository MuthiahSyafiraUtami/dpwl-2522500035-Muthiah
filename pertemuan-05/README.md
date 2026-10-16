# pertemuan-05

# README Pertemuan 05 — Manajemen Kendaraan

## 1. Deskripsi

Pertemuan 05 merupakan pengembangan lanjutan aplikasi penyewaan kendaraan menggunakan Model-View-Controller. Pada pertemuan ini, aplikasi dikembangkan untuk mengelola data kendaraan melalui fitur CRUD, yaitu **Create, Read, Update, dan Delete**.

Fitur Manajemen Kendaraan digunakan untuk menampilkan daftar kendaraan, menambahkan data kendaraan baru, mengubah data kendaraan yang sudah tersimpan, serta menghapus data kendaraan beserta berkas foto yang terkait.

## 2. Fitur yang Diimplementasikan

Fitur yang dikembangkan pada halaman Manajemen Kendaraan meliputi:

1. **READ** — Menampilkan daftar kendaraan dari tabel `t_mobil`.
2. **INSERT** — Menambahkan data kendaraan baru melalui formulir.
3. **UPDATE** — Mengubah informasi kendaraan yang telah tersimpan.
4. **DELETE** — Menghapus data kendaraan berdasarkan nomor polisi (`no_plat`).
5. **Pengelolaan foto kendaraan** — Menangani berkas foto kendaraan yang tersimpan di folder `uploads/mobil/`.
6. **Validasi dan pesan notifikasi** — Menangani input serta menampilkan informasi hasil operasi kepada pengguna.
7. **Keamanan penghapusan** — Membatasi proses penghapusan agar hanya dapat dilakukan menggunakan metode HTTP POST.

## 3. Perubahan Berkas

Berkas berikut merupakan bagian yang berkaitan dengan implementasi Manajemen Kendaraan. Penjelasan ini mengacu pada struktur dan fungsi kode yang digunakan dalam pengerjaan.

| Berkas | Perubahan atau fungsi |
|---|---|
| `application/config/routes.php` | Mengatur rute untuk halaman Manajemen Kendaraan dan proses tambah, ubah, serta hapus data kendaraan. |
| `application/models/Mobil_model.php` | Menangani operasi data kendaraan pada basis data, meliputi pengambilan daftar data, penambahan, pencarian berdasarkan nomor polisi, perubahan, dan penghapusan data. |
| `application/controllers/Mobil_controller.php` | Mengatur alur halaman Manajemen Kendaraan, validasi input, proses tambah dan ubah data, pengunggahan foto, serta penghapusan data dan foto kendaraan. |
| `application/views/admin/mobil_view.php` | Menampilkan tabel daftar kendaraan serta formulir tambah dan ubah kendaraan. Halaman ini juga menyediakan aksi untuk menghapus data kendaraan. |
| `application/views/templates/sidebar.php` | Menambahkan menu Manajemen Kendaraan pada navigasi aplikasi agar halaman dapat diakses melalui sidebar. |
| `pertemuan-05/README.md` | Mendokumentasikan fitur yang dibuat, perubahan berkas, kendala selama pengerjaan, dan hasil pengujian aplikasi. |

## 4. Implementasi DELETE Data Kendaraan

Fitur DELETE digunakan untuk menghapus data kendaraan berdasarkan nomor polisi. Proses penghapusan tidak hanya melibatkan data pada tabel `t_mobil`, tetapi juga foto kendaraan yang terkait.

Alur penghapusan data kendaraan:

1. Pengguna memilih kendaraan yang ingin dihapus melalui tombol Hapus.
2. Aplikasi meminta konfirmasi penghapusan.
3. Controller memeriksa permintaan dan memastikan metode HTTP yang digunakan adalah POST.
4. Controller mengambil informasi foto kendaraan sebelum menghapus data dari basis data.
5. Model menjalankan proses penghapusan data kendaraan.
6. Jika penghapusan data pada basis data berhasil, aplikasi melanjutkan penghapusan berkas foto yang terkait.
7. Aplikasi menampilkan pesan sesuai hasil proses penghapusan.

Apabila data kendaraan tidak ditemukan atau operasi penghapusan gagal, aplikasi menangani kondisi tersebut melalui mekanisme pesan yang sesuai. Berkas foto tidak boleh dihapus apabila penghapusan data pada basis data gagal, agar foto yang masih terkait dengan data tersimpan tetap tersedia.

## 5. Kendala dan Perbaikan

Selama pengerjaan, terdapat dua kendala yang perlu dicatat.

### 5.1. Halaman sempat menampilkan layar putih

Saat menambahkan kode pada `application/views/admin/mobil_view.php`, terjadi kesalahan penempatan kode sehingga halaman Manajemen Kendaraan menampilkan layar putih dan daftar kendaraan tidak terlihat.

Kendala tersebut berkaitan dengan penempatan kode pada bagian tampilan. Setelah bagian kode diperiksa dan diperbaiki, pengerjaan dilanjutkan pada fitur Manajemen Kendaraan.

### 5.2. Validasi pada fitur Ubah Kendaraan

Fitur Ubah Kendaraan sempat tidak berjalan sesuai harapan karena terdapat kesalahan penulisan kode (*typo*). Akibatnya, aplikasi menampilkan notifikasi:

- “Jenis mobil tidak valid”
- “Transmisi tidak valid”

Setelah kesalahan penulisan tersebut diperbaiki, fitur Ubah Kendaraan dapat berjalan sesuai harapan dan proses perubahan data dapat dilakukan.

## 6. Pemeriksaan Kode

Bagian ini menjelaskan hal-hal yang perlu diperiksa pada implementasi kode berdasarkan kebutuhan Modul P5. Pemeriksaan kode berbeda dari pengujian langsung pada aplikasi.

| Aspek pemeriksaan | Hal yang diperiksa |
|---|---|
| Routing | Rute Manajemen Kendaraan dan aksi tambah, ubah, serta hapus mengarah ke proses yang sesuai. |
| Model | Operasi basis data untuk mengambil, menambah, mengubah, mencari, dan menghapus data kendaraan tersedia. |
| Controller | Proses validasi, penanganan hasil operasi basis data, dan pengelolaan foto kendaraan ditangani. |
| Metode HTTP | Proses DELETE hanya menerima permintaan POST dan permintaan dengan metode lain ditolak. |
| Penghapusan foto | Foto kendaraan dihapus setelah penghapusan data pada basis data berhasil, bukan sebelumnya. |
| Penanganan kesalahan | Kondisi kendaraan tidak ditemukan dan kegagalan penghapusan ditangani oleh aplikasi. |
| Tampilan | Tabel kendaraan, formulir, tombol aksi, dan pesan notifikasi tersedia pada halaman Manajemen Kendaraan. |

Pemeriksaan kode di atas merupakan daftar aspek yang diperiksa berdasarkan kebutuhan fitur. Hasil pemeriksaan setiap aspek harus disesuaikan dengan kode akhir yang digunakan.

## 7. Hasil Pengujian Aktual

Berdasarkan pengujian yang dilaporkan selama pengerjaan, fitur-fitur berikut dapat dijalankan. Pada fitur Ubah Kendaraan, keberhasilan diperoleh setelah kesalahan penulisan kode diperbaiki.

| No. | Skenario pengujian | Hasil aktual |
|---|---|---|
| 1 | Menu Manajemen Kendaraan dapat dibuka | **Berhasil.** Halaman Manajemen Kendaraan dapat dibuka. |
| 2 | Daftar kendaraan tampil | **Berhasil.** Daftar data kendaraan dapat ditampilkan. |
| 3 | Tambah kendaraan | **Berhasil.** Data kendaraan baru dapat ditambahkan. |
| 4 | Ubah kendaraan | **Berhasil setelah perbaikan.** Sebelumnya muncul notifikasi “Jenis mobil tidak valid” dan “Transmisi tidak valid” akibat typo. Setelah diperbaiki, proses ubah data berjalan sesuai harapan. |
| 5 | Hapus kendaraan | **Berhasil.** Proses penghapusan data kendaraan dapat dilakukan. |
| 6 | Hapus kendaraan yang tidak ditemukan | **Berhasil berdasarkan pengujian yang dilaporkan.** Skenario penghapusan terhadap kendaraan yang tidak ditemukan dapat ditangani. |
| 7 | Penghapusan gagal | **Berhasil berdasarkan pengujian yang dilaporkan.** Skenario kegagalan penghapusan dapat ditangani oleh aplikasi. |
| 8 | Akses hapus menggunakan metode selain POST | **Berhasil berdasarkan pengujian yang dilaporkan.** Permintaan penghapusan dengan metode selain POST ditangani oleh aplikasi. |
| 9 | Fitur READ, INSERT, dan UPDATE tetap berfungsi setelah DELETE | **Berhasil.** Fitur menampilkan, menambahkan, dan mengubah data kendaraan tetap dapat digunakan setelah implementasi DELETE. |

**Catatan pengujian:** Hasil di atas mengikuti keterangan pengujian yang disampaikan selama pengerjaan. Pemeriksaan khusus terhadap terhapusnya setiap berkas foto, kondisi kegagalan SQL, serta respons HTTP secara rinci perlu dicatat tersendiri jika pengujian tersebut dilakukan.

## 8. Kesimpulan

Implementasi Manajemen Kendaraan pada Pertemuan 05 mencakup fitur READ, INSERT, UPDATE, dan DELETE. Proses pengembangan sempat mengalami kendala berupa kesalahan penempatan kode pada tampilan dan typo pada validasi fitur Ubah Kendaraan. Setelah perbaikan, fitur Ubah Kendaraan kembali dapat digunakan.

Berdasarkan hasil pengujian yang dilaporkan, fitur utama Manajemen Kendaraan dapat dijalankan. Dokumentasi ini mencatat perubahan berkas, alur implementasi DELETE, kendala yang ditemukan, dan hasil pengujian untuk mendukung evaluasi pengerjaan sesuai Modul P5.