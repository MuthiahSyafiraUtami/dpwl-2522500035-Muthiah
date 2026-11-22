# pertemuan-10

### 1. Perubahan Database 

Pada tabel `t_sewa`, kolom `status_sewa` mengalami penambahan nilai ENUM `lunas`.

Nilai ENUM setelah perubahan:

- diajukan
- disetujui
- ditolak
- aktif
- selesai
- batal
- keranjang
- lunas

Perubahan dilakukan melalui phpMyAdmin pada database proyek.

### 2. Penambahan Method pada Pembayaran_model

File: application/models/Pembayaran_model.php

#### 2.1 getDaftarPelunasan()

Digunakan untuk mengambil daftar transaksi penyewaan yang memiliki kewajiban pelunasan, termasuk data penyewa, total biaya, total pembayaran valid, dan sisa pembayaran.

#### 2.2 getDetailPelunasan (string $kodeSewa)

Digunakan untuk mengambil detail transaksi penyewaan berdasarkan kode sewa, meliputi informasi penyewa, kendaraan, periode sewa, total biaya, riwayat pembayaran, dan sisa pelunasan.

#### 2.3 buatKodeBayarPelunasan (string $tanggalKode)
 
Digunakan untuk membuat kode pembayaran pelunasan secara otomatis dengan format PAY/YYYYMMDD/NN, menggunakan nomor urut berdasarkan tanggal.

#### 2.4 simpanPelunasan (string $kodeSewa, string $metodeBayar, string $namaFileBukti = null)

Digunakan untuk memproses dan menyimpan pembayaran pelunasan ke database. Method ini melakukan validasi transaksi, metode pembayaran, nominal pelunasan, dan mencegah pembayaran dilakukan lebih dari satu kali.

Setelah pelunasan berhasil disimpan, status transaksi penyewaan diperbarui menjadi lunas.