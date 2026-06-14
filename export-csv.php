<?php
include 'setup.php';

if (!isset($_SESSION['admin'])) {
    exit("Akses ditolak.");
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=stok_produk_florist_'.date('Ymd').'.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('ID', 'Nama Bunga', 'Kategori', 'Harga', 'Stok', 'Status Stok', 'Tanggal Terdaftar'));

$rows = $conn->query("SELECT id, nama_bunga, kategori, harga, stok, status_stok, created_at FROM flowers ORDER BY id DESC");
while ($row = $rows->fetch_assoc()) {
    fputcsv($output, $row);
}
fclose($output);
exit;
?>