<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "marine_coastal_florist";

$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$conn->query("CREATE DATABASE IF NOT EXISTS $db");
$conn->select_db($db);

$table_sql = "CREATE TABLE IF NOT EXISTS flowers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_bunga VARCHAR(255) NOT NULL,
    kategori VARCHAR(100) NOT NULL,
    harga DECIMAL(12,2) NOT NULL,
    stok INT NOT NULL,
    status_stok VARCHAR(50) NOT NULL,
    gambar_files TEXT NULL,
    ttd_digital TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($table_sql);

// Memastikan data dummy awal menggunakan format string kosong '[]' bukan NULL
$check = $conn->query("SELECT id FROM flowers LIMIT 1");
if ($check->num_rows == 0) {
    $conn->query("INSERT INTO flowers (nama_bunga, kategori, harga, stok, status_stok, gambar_files) VALUES
    ('Mawar Merah Enchanted', 'Bouquet Wisuda', 150000, 10, 'Ready', '[]'),
    ('Anggrek Bulan Putih Premium', 'Bunga Meja', 450000, 0, 'Habis Total', '[]'),
    ('Papan Sukses & Bahagia 2x1.5m', 'Papan Ucapan', 750000, 5, 'Ready', '[]'),
    ('Tulip Ungu', 'Bouquet Wisuda', 5000000, 1, 'Ready', '[]'),
    ('Happy Wedding', 'Papan Ucapan', 10000000, 3, 'Stok Tipis', '[]')");
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>