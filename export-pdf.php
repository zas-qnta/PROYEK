<?php
include 'setup.php';

if (!isset($_SESSION['admin'])) {
    exit("Akses ditolak. Silakan login terlebih dahulu.");
}

// Pastikan file fpdf.php sudah ada di folder yang sama
if (!file_exists('fpdf.php')) {
    die("Error: File 'fpdf.php' tidak ditemukan. Silakan unduh library FPDF dan letakkan di folder proyek Anda.");
}

require('fpdf.php');

class PDF extends FPDF {
    // Page header
    function Header() {
        // Logo atau Simbol Emoticon diganti teks formal
        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(233, 30, 99); // Warna Magenta khas Petal Registry (#e91e63)
        $this->Cell(0, 10, 'PETAL REGISTRY - FLORIST ADMIN SYSTEM', 0, 1, 'C');
        
        $this->SetFont('Arial', 'I', 10);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0, 5, 'Tema: Marine Coastal Florist | Laporan Stok Gudang Real-time', 0, 1, 'C');
        
        // Garis pembatas double
        $this->Ln(3);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Line(10, $this->GetY()+1, 200, $this->GetY()+1);
        $this->Ln(5);
    }

    // Page footer
    function Footer() {
        // Posisi 1.5 cm dari bawah
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128, 128, 128);
        // Nomor halaman
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo() . ' / {nb}', 0, 0, 'C');
    }
}

// Instansiasi class FPDF (Kertas A4, Potrait)
$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();

// Informasi metadata laporan
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(50, 50, 50);
$pdf->Cell(40, 6, 'Dicetak Oleh', 0, 0);
$pdf->Cell(5, 6, ':', 0, 0);
$pdf->Cell(0, 6, $_SESSION['admin'], 0, 1); // Zaskia Qanita Najiyah

$pdf->Cell(40, 6, 'Tanggal Cetak', 0, 0);
$pdf->Cell(5, 6, ':', 0, 0);
$pdf->Cell(0, 6, date('d F Y H:i') . ' WIB', 0, 1);
$pdf->Ln(5);

// Desain Header Tabel Laporan
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(240, 240, 240); // Background abu-abu terang mirip UI Datatable
$pdf->SetTextColor(40, 40, 40);

// Judul kolom (Total lebar area A4 aman adalah ~190mm)
$pdf->Cell(12, 8, 'ID', 1, 0, 'C', true);
$pdf->Cell(65, 8, 'Nama Varian Bunga', 1, 0, 'L', true);
$pdf->Cell(40, 8, 'Kategori', 1, 0, 'L', true);
$pdf->Cell(38, 8, 'Harga Jual', 1, 0, 'R', true);
$pdf->Cell(15, 8, 'Stok', 1, 0, 'C', true);
$pdf->Cell(20, 8, 'Status', 1, 1, 'C', true);

// Penarikan data dari database
$pdf->SetFont('Arial', '', 9);
$pdf->SetTextColor(0, 0, 0);

$query = "SELECT id, nama_bunga, kategori, harga, stok, status_stok FROM flowers ORDER BY id DESC";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(12, 8, 'FLW-' . $row['id'], 1, 0, 'C');
        $pdf->Cell(65, 8, ' ' . $row['nama_bunga'], 1, 0, 'L');
        $pdf->Cell(40, 8, ' ' . $row['kategori'], 1, 0, 'L');
        $pdf->Cell(38, 8, 'Rp ' . number_format($row['harga'], 0, ',', '.') . ' ', 1, 0, 'R');
        $pdf->Cell(15, 8, $row['stok'], 1, 0, 'C');
        
        // Memberikan warna teks khusus pada status stok agar mirip visual badge di web UI
        if ($row['status_stok'] == 'Habis Total') {
            $pdf->SetTextColor(255, 77, 79); // Merah
        } elseif ($row['status_stok'] == 'Stok Tipis') {
            $pdf->SetTextColor(212, 107, 8); // Oranye
        } else {
            $pdf->SetTextColor(21, 128, 61); // Hijau
        }
        
        $pdf->Cell(20, 8, $row['status_stok'], 1, 1, 'C');
        $pdf->SetTextColor(0, 0, 0); // Kembalikan ke hitam untuk baris berikutnya
    }
} else {
    $pdf->Cell(190, 10, 'Tidak ada data produk ditemukan.', 1, 1, 'C');
}

// Output PDF langsung unduh/buka di browser
$pdf->Output('I', 'Laporan_Stok_Petal_Registry_' . date('Ymd') . '.pdf');
exit;
?>