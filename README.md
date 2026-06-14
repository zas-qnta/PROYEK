🌸 PetalRegistry - Florist Admin System

PetalRegistry adalah aplikasi berbasis web yang dirancang untuk membantu pengelolaan stok, klasifikasi varian produk bunga, serta pencatatan tanda tangan digital serah terima secara asinkron. Sistem ini dikembangkan khusus dengan menerapkan tema visual **Marine Coastal Florist.

👥 Identitas Pengembang
Nama: Zaskia Qanita Najiyah
NIM: 2430511024
Tema Proyek:Marine Coastal Florist



✨ Fitur Utama Sistem

1. Autentikasi Hak Akses (Login System)
   -Mengamankan dashboard utama dari akses luar menggunakan validasi `session` PHP.
2. Dashboard Tema Kustom (Marine Coastal Florist)
   -Tampilan modern dengan bilah navigasi berwarna Pink kustom, dilengkapi ikon line-art bunga putih bertekstur garis kelopak yang elegan.
3. Komponen Multimedia Otomatis (HTML5 Native)
   -Pemutar video profil rangkaian toko berwujud persegi panjang rasio 16:9 yang otomatis berputar (*autoplay* & *looping*).
   -Pemutar audio jingle & backsound tema aktif yang mengalir tepat di bawah video secara vertikal.
4. Datatable Manajemen Stok Produk
   -Menampilkan data foto varian, nama bunga, kategori, variansi harga, hingga kuantitas unit gudang.
   -Sistem Gambar Kebal Error (Anti-Pecah): Dilengkapi logika toleransi otomatis untuk membaca ekstensi file gambar mentah database maupun format bungkusan JSON, serta memiliki auto-fallback SVG jika file fisik di folder `uploads` hilang.
   -Pewarnaan badge dinamis untuk membedakan status ketersediaan barang (`Ready Stock`, `Stok Tipis`, `Habis Total`).
5. Aksi CRUD Asinkron & TTD Digital
   -Integrasi form modal Bootstrap untuk Tambah data, Edit data, dan Detail data tanpa memuat ulang seluruh halaman.
   Fitur Tanda Tangan (Canvas Signature):Memungkinkan kurir atau penerima menggoreskan tanda tangan digital langsung pada kanvas HTML5 yang kemudian disimpan ke dalam basis data sebagai bukti sah serah terima barang.
6. Ekspor Laporan (Data Exporting)
   Export CSV:Mengunduh ringkasan data stok ke dalam berkas spreadsheet dalam satu klik.
   Export PDF:Mencetak berkas dokumen formal stok produk bunga (Tombol Danger Red bersebelahan dengan tombol CSV).

🛠️ Spesifikasi Teknologi & Stack

Backend / Server-side:PHP 8.1+ (Bebas dari *Deprecated Notice json_decode Null)
Database:MySQL / MariaDB via phpMyAdmin
Frontend Framework:Bootstrap 5.3 & Bootstrap Icons
Library Eksternal:jQuery 3.6.0 (Pengolah Ajax Request)
Lingkungan Lokal:Laragon

📁 Struktur Direktori Proyek

📁 PROYEK_2
├── 📁 assets
│   ├── 📄 1387951-hd_1920_1080_30fps.mp4             # Berkas Video Profil Toko
│   └── 📄 alanajordan-commercial-jingle-04-252796 (1).mp3 # Berkas Audio Jingle Theme
├── 📁 uploads                                         # Penyimpanan fisik berkas gambar bunga (.jfif, .jpg, .png)
├── 📄 setup.php                                       # Berkas koneksi database & session start
├── 📄 login.php                                       # Halaman masuk admin
├── 📄 logout.php                                      # Penghapus session akses
├── 📄 index.php                                       # Dashboard Utama & Datatable Produk
├── 📄 detail.php                                      # Injeksi Modal Detail Produk Tersemat Sistem
├── 📄 edit.php                                        # Proses Edit Data & Handler simpan TTD Digital via POST
├── 📄 tambah.php                                      # Komponen Modal Tambah Varian Bunga
├── 📄 hapus.php                                       # Aksi hapus baris data produk
├── 📄 export-csv.php                                  # Mesin ekspor file spreadsheet CSV
├── 📄 export-pdf.php                                  # Mesin pencetak dokumen PDF stok
└── 📄 README.md                                       # Dokumentasi teknis proyek
