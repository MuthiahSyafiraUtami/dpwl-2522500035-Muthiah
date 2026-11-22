<?php

$route = [];

$route['default_controller'] = 'home';
$route['info/(:any)'] = 'home/info/$1';

// $route['default_controller'] = 'home'; // Dimatikan pada P6 karena penulisan index.php dihilangkan pada URL aplikasi
$route['default_controller'] = 'Katalog_controller'; // karena penulisan index.php dihilangkan pada URL aplikasi
$route['info/(:any)'] = 'home/info/$1';

// Route autentikasi P3
$route['login'] = 'auth/login';
$route['auth/login'] = 'auth/login';
$route['auth/logout'] = 'auth/logout';

// Route halaman administrasi
$route['admin'] = 'admin/index';


// P4: BARU - semua proses CRUD admin dipindahkan di bawah /admin/madmin.
$route['admin/madmin'] = 'madmin_controller/index';
$route['admin/madmin/tambah'] = 'madmin_controller/tambah';
$route['admin/madmin/ubah/(:any)'] = 'madmin_controller/ubah/$1';
$route['admin/madmin/hapus/(:any)'] = 'madmin_controller/hapus/$1';

// Route P5
$route['admin/mobil'] = 'Mobil_controller/index';
$route['admin/mobil/tambah'] = 'Mobil_controller/tambah';
$route['admin/mobil/ubah/(:any)'] = 'Mobil_controller/ubah/$1';
$route['admin/mobil/hapus/(:any)'] = 'Mobil_controller/hapus/$1';

// Route P6
$route['katalog'] = 'Katalog_controller/index';
$route['katalog/detail/(:any)'] = 'Katalog_controller/detail/$1';
$route['auth/register'] = 'Auth/register';
$route['auth/login-penyewa'] = 'Auth/loginPenyewa';
$route['auth/logout-penyewa'] = 'Auth/logoutPenyewa';
$route['penyewa/profil'] = 'Penyewa_controller/profil';

// Route P7 - Transaksi dan Keranjang
$route['pembayaran/tambah'] = 'Pembayaran_controller/tambah';

// Route P7 - Transaksi, Keranjang, dan Checkout
$route['transaksi/tambah'] = 'Pembayaran_controller/tambah';
$route['transaksi/keranjang'] = 'Pembayaran_controller/keranjang';
$route['transaksi/perbarui-periode'] = 'Pembayaran_controller/perbaruiPeriode';
$route['transaksi/hapus'] = 'Pembayaran_controller/hapus';
$route['transaksi/hapus/(:any)'] = 'Pembayaran_controller/hapus/$1';
$route['transaksi/checkout'] = 'Pembayaran_controller/checkout';


$route['admin/penyewa'] = 'Penyewa_controller/index';
$route['admin/penyewa/tambah'] = 'Penyewa_controller/tambah';
$route['admin/penyewa/ubah/(:any)'] = 'Penyewa_controller/ubah/$1';
$route['admin/penyewa/hapus/(:any)'] = 'Penyewa_controller/hapus/$1';

// Route P9 - Pembayaran penyewa
$route['transaksi/pembayaran'] = 'Pembayaran_controller/pembayaran';

$route['transaksi/upload-bukti-pembayaran'] =
    'Pembayaran_controller/uploadbuktipembayaran';
    
// Route P9 - Verifikasi pembayaran admin
$route['admin/verifikasi-pembayaran'] =
    'Verifikasi_controller/index';

$route['admin/verifikasi-pembayaran/proses'] =
    'Verifikasi_controller/proses';

$route['admin/pembayaran/pelunasan'] = 'Pembayaran_controller/pelunasanIndex';
$route['admin/pembayaran/pelunasan/proses/(:any)'] = 'Pembayaran_controller/prosesPelunasan/$1';
$route['admin/pembayaran/dokumen/(:any)'] = 'Pembayaran_controller/dokumenTransaksi/$1';
$route['admin/pembayaran/pelunasan/(:any)'] = 'Pembayaran_controller/pelunasanDetail/$1';
