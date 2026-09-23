# pertemuan-01
1. kesinambungan PWD–DPW–DPWL;

    Jawaban :    
    
    *PWD* (Pemrograman Web Dasar) merupakan dasar untuk memahami pembuatan web, seperti HTML, CSS, PHP dasar, form, serta koneksi database.

    *DPW* (Desain dan Pemrograman Web) melanjutkan konsep PWD dengan membangun web yang lebih terstruktur dan terhubung dengan database. Pada tahap ini, mahasiswa mulai menerapkan pengolahan data seperti tambah, tampil, ubah, dan hapus (CRUD).

    *DPWL* (Desain dan Pemrograman Web Lanjutan) merupakan pengembangan dari DPW. Aplikasi yang sebelumnya dibuat dengan PHP terstruktur mulai dikembangkan menggunakan konsep yang lebih terorganisasi, salah satunya arsitektur MVC (Model–View–Controller).

    *Jadi, kesinambungannya adalah:*

    PWD → dasar pemrograman web → DPW → pengembangan aplikasi web + database → DPWL → pengembangan aplikasi yang lebih terstruktur menggunakan MVC.

2. perbedaan PHP terstruktur dan MVC;
    
    Jawaban: 

    PHP Terstruktur :

    - Kode program dibuat sesuai dengan kebutuhan fitur dan prosesnya
    - Bagian logika, tampilan, dan database masih bisa bercampur
    - Lebih sederhana dan cocok untuk aplikasi yang tidak terlalu kompleks
    - Jika program semakin besar, kode bisa lebih sulit untuk dikelola
    - Contohnya dalam satu file PHP terdapat HTML, query database, dan proses CRUD

    MVC :

    - Kode program dibagi menjadi Model, View, dan Controller
    - Bagian logika, tampilan, dan database dipisahkan
    - Lebih cocok digunakan untuk aplikasi yang lebih kompleks
    - Lebih mudah dikelola dan dikembangkan karena setiap bagian memiliki tugas masing-masing
    - Model mengurus database, View mengurus tampilan, dan Controller mengatur proses program

     Jadi, PHP terstruktur lebih sederhana karena kode program masih bisa berada dalam satu bagian, sedangkan MVC memisahkan program menjadi Model, View, dan Controller supaya lebih teratur dan mudah dikelola.

3. fungsi Model, View, dan Controller;

    Jawaban :
    
    A. Model

    Model berfungsi untuk mengatur data dan hubungan dengan database. Model digunakan untuk melakukan proses seperti:

    - mengambil data pasien;
    - menambahkan data pasien;
    - mengubah data pasien;
    - menghapus data pasien.

    B. View

    View berfungsi untuk mengatur tampilan yang dilihat oleh pengguna. Contohnya:

    - halaman daftar pasien;
    - form tambah pasien;
    - tabel data pasien;
    - tombol edit dan hapus.

    C. Controller

    Controller berfungsi untuk mengatur proses dalam aplikasi dan menjadi penghubung antara Model dan View. Controller menerima request dari pengguna, kemudian menentukan proses yang harus dilakukan, mengambil data dari Model, dan mengirimkannya ke View untuk ditampilkan.

    *Jadi, secara sederhana:*

    - Model = mengurus data
    - View = mengurus tampilan
    - Controller = mengatur proses dan menghubungkan Model dengan View

4. alur request–response MVC;
    
    Jawaban :
    
    Alur request–response pada MVC dapat digambarkan seperti berikut:

    User → Request → Controller → Model → Database → Model → Controller → View → Response → User

    *Contohnya ketika user ingin melihat daftar pasien :*

       1. User membuka halaman daftar pasien.
       2. Browser mengirim request ke aplikasi.
       3. Controller menerima request tersebut.
       4. Controller meminta data pasien kepada Model.
       5. Model mengambil data pasien dari database.
       6. Database mengembalikan data kepada Model.
       7. Model mengirimkan data tersebut kepada Controller.
       8. Controller meneruskan data ke View.
       9. View menampilkan data pasien dalam bentuk halaman web.
       10. Halaman tersebut dikirim kembali kepada user sebagai response.

    Jadi, Controller mengatur jalannya proses, Model mengambil atau mengolah data, dan View menampilkan hasilnya kepada user.

5. pemetaan satu atau beberapa bagian/fitur aplikasi DPW ke Model, Controller, dan View disertai alasan; dan
    
    Jawaban :
    
    Contohnya pada fitur data pasien dalam aplikasi DPW:

    A. Model 
    
    *contoh :*  
    
    PasienModel
    
    *Alasan :*

    Digunakan untuk mengatur data pasien yang berhubungan dengan database, seperti menampilkan, menambah, mengubah, dan menghapus data.

    B. Controller
    
    *contoh :*  
    
    PasienController
    
    *Alasan :*

    Digunakan untuk menerima request dari user dan mengatur proses yang harus dilakukan terhadap data pasien.

     C. View
    
    *contoh :*  
    
    pasien/index.php, pasien/tambah.php, pasien/edit.php
    
    *Alasan :*

    Digunakan untuk menampilkan data pasien dan menyediakan form untuk menambah atau mengubah data.

6. kesimpulan P1.

    Jawaban :

    PWD, DPW, dan DPWL saling berhubungan dalam pembelajaran pemrograman web. PWD menjadi dasar untuk memahami pemrograman web, kemudian DPW melanjutkan pembelajaran dengan membuat aplikasi web yang menggunakan database. Setelah itu, DPWL mengembangkan pembelajaran tersebut dengan menggunakan konsep yang lebih terstruktur, salah satunya adalah MVC.

    Dalam MVC terdapat tiga bagian utama, yaitu Model yang mengatur data, View yang mengatur tampilan, dan Controller yang mengatur proses serta menghubungkan Model dengan View. Dengan adanya pembagian tersebut, program menjadi lebih rapi, teratur, dan lebih mudah untuk dikembangkan maupun diperbaiki.