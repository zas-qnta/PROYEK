<?php
include 'setup.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM flowers WHERE nama_bunga LIKE '%$search%' OR kategori LIKE '%$search%' ORDER BY id DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Petal Registry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { background-color: #fafafa; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; }
        .navbar-brand { font-size: 1.15rem; letter-spacing: -0.3px; }
        
        /* Badges Style */
        .badge-ready { background-color: #e2f6ec; color: #15803d; font-weight: 500; border-radius: 6px; }
        .badge-habis { background-color: #ffebe9; color: #ff4d4f; font-weight: 500; border-radius: 6px; }
        .badge-tipis { background-color: #fffbe6; color: #d46b08; font-weight: 500; border-radius: 6px; }
        
        /* Action Buttons minimal round circle shape */
        .btn-action { width: 32px; height: 32px; padding: 0; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 14px; border: none; margin: 0 2px; transition: all 0.2s; }
        .btn-action-view { background-color: #e6f7ff; color: #1890ff; }
        .btn-action-edit { background-color: #fff7e6; color: #fa8c16; }
        .btn-action-ttd { background-color: #f9f0ff; color: #722ed1; }
        .btn-action-delete { background-color: #fff1f0; color: #f5222d; }
        .btn-action:hover { opacity: 0.8; transform: scale(1.05); }

        /* Search input style */
        .search-container { position: relative; max-width: 300px; }
        .search-input { border-radius: 20px; padding-left: 35px; background-color: #fff; border: 1px solid #d9d9d9; font-size: 14px; }
        .search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #bfbfbf; }
        
        .btn-magenta-add { background-color: #e91e63; color: white; border-radius: 8px; font-size: 14px; font-weight: 500; }
        .btn-magenta-add:hover { background-color: #d81b60; color: white; }
        .btn-success-csv { background-color: #107c41; color: white; border-radius: 8px; font-size: 14px; font-weight: 500; }
        
        .card-table { border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.02); background: white; }
        #signature-canvas { border: 1px solid #e8e8e8; background: #fafafa; border-radius: 8px; cursor: crosshair; }
        
        /* Table Header Color */
        .table th { font-weight: 600; color: #8c8c8c; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #f0f0f0; }
        .table td { border-bottom: 1px solid #fbfbfb; padding: 14px 8px; color: #262626; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand px-4 py-2 shadow-sm" style="background-color: #e91e63;">
    <a class="navbar-brand fw-bold d-flex align-items-center gap-2 text-decoration-none" href="#">
         <i class="bi bi-flower1 text-white" style="font-size: 1.4rem; line-height: 1;"></i> 
         <span class="text-white">PetalRegistry</span>
    </a>
    <div class="ms-auto text-white small d-flex align-items-center gap-3">
         <span>Hi, <strong class="text-white"><?= htmlspecialchars($_SESSION['admin']); ?></strong></span>
         <a href="logout.php" class="btn btn-sm btn-outline-light py-0 px-2" style="font-size: 12px; border-radius: 6px;">Keluar</a>
    </div>
</nav>

<div class="row mb-4 justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="bg-white p-4 rounded-4 shadow-sm border border-light d-flex flex-column gap-3">
                
                <div>
                    <video width="100%" controls autoplay loop class="rounded-3 border bg-black" style="aspect-ratio: 16 / 9; object-fit: cover;">
                        <source src="assets/13300755_3840_2160_30fps.mp4" type="video/mp4">
                        
                    </video>
                </div>
                
                <hr class="my-1" style="color: #f0f0f0;">

                <div>
                    <h6 class="fw-bold text-muted small mb-1"><i class="bi bi-music-note-beamed"></i> Audio Jingle & Theme</h6>
                    <audio controls autoplay loop class="w-100">
                        <source src="assets/alanajordan-commercial-jingle-04-252796 (1).mp3" type="audio/mpeg">
                    </audio>
                </div>

            </div>
        </div>
    </div>

    <div class="card card-table">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <h5 class="fw-bold m-0 text-dark d-flex align-items-center gap-2">
                     <i class="bi bi-grid-1x2 text-danger"></i> Datatable Stok Produk
                </h5>
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <form action="" method="GET" class="m-0 search-container">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" name="search" class="form-control search-input" placeholder="Cari nama bunga atau kategori..." value="<?= htmlspecialchars($search); ?>">
                    </form>
                    
                    <a href="export-csv.php" class="btn btn-success-csv px-3"><i class="bi bi-file-earmark-spreadsheet"></i> Export CSV</a>
                    
                    <a href="export-pdf.php" target="_blank" class="btn btn-danger px-3" style="background-color: #dc3545; border: none; border-radius: 8px; font-size: 14px; font-weight: 500;">
                        <i class="bi bi-file-earmark-pdf"></i> Export PDF
                    </a>
                    
                    <button class="btn btn-magenta-add px-3" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="bi bi-plus-lg"></i> Tambah Data Bunga</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th width="10%">Foto</th>
                            <th width="30%">Nama Bunga</th>
                            <th width="18%">Kategori</th>
                            <th width="18%">Harga Variance</th>
                            <th width="14%">Status Stok</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 14px;">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): 
                                // 1. Bersihkan data mentah dari database
                                $gambar_raw = isset($row['gambar_files']) ? trim($row['gambar_files']) : '';
                                $display_img = '';
                                $file_name = '';

                                // 2. Ekstrak nama file dari JSON atau string biasa
                                if (!empty($gambar_raw)) {
                                    if (strpos($gambar_raw, '[') === 0 || strpos($gambar_raw, '{') === 0) {
                                        $images = json_decode($gambar_raw, true);
                                        $file_name = (is_array($images) && isset($images[0])) ? $images[0] : '';
                                    } else {
                                        $file_name = $gambar_raw;
                                    }
                                }

                                // 3. Logika Toleransi Ekstensi (Membantu deteksi .jfif, .jpg, dll)
                                if (!empty($file_name)) {
                                    $path_tanpa_ekstensi = 'uploads/' . pathinfo($file_name, PATHINFO_FILENAME);
                                    
                                    // Daftar ekstensi yang akan dicoba dicek di folder uploads
                                    $ekstensi_dicoba = ['jfif', 'jpg', 'jpeg', 'png', 'webp', 'JFIF', 'JPG', 'PNG'];
                                    
                                    foreach ($ekstensi_dicoba as $ext) {
                                        if (file_exists($path_tanpa_ekstensi . '.' . $ext)) {
                                            $display_img = $path_tanpa_ekstensi . '.' . $ext;
                                            break; // Hentikan pencarian jika file fisik ketemu
                                        }
                                    }
                                }

                                // 4. Fallback Terakhir jika file benar-benar tidak ada di laptop
                                if (empty($display_img)) {
                                    $display_img = "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='42' height='42' fill='%23bfbfbf' class='bi bi-image' viewBox='0 0 16 16'><path d='M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z'/><path d='M2.003 22a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V4a1 1 0 0 1 1-1h12z'/></svg>";
                                }
                                
                                $badge_class = 'badge-ready';
                                if($row['status_stok'] == 'Habis Total') $badge_class = 'badge-habis';
                                if($row['status_stok'] == 'Stok Tipis') $badge_class = 'badge-tipis';
                            ?>
                            <tr>
                                <td><img src="<?= $display_img; ?>" width="42" height="42" class="rounded-3 border object-fit-cover" alt="Bunga"></td>
                                <td class="fw-semibold text-dark"><?= htmlspecialchars($row['nama_bunga']); ?></td>
                                <td class="text-secondary"><?= htmlspecialchars($row['kategori']); ?></td>
                                <td class="fw-medium text-dark">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                                <td>
                                    <span class="badge <?= $badge_class; ?> px-2 py-1.5 shadow-sm small">
                                         <?= htmlspecialchars($row['status_stok']); ?> (<?= $row['stok']; ?>)
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <button class="btn-action btn-action-view btn-view" data-id="<?= $row['id']; ?>" title="Lihat Detail"><i class="bi bi-eye"></i></button>
                                        <button class="btn-action btn-action-edit btn-edit" data-id="<?= $row['id']; ?>" title="Edit Data"><i class="bi bi-pencil"></i></button>
                                        <button class="btn-action btn-action-ttd btn-canvas" data-id="<?= $row['id']; ?>" title="Isi TTD"><i class="bi bi-vector-pen"></i></button>
                                        <a href="hapus.php?id=<?= $row['id']; ?>" class="btn-action btn-action-delete" onclick="return confirm('Hapus data produk bunga ini?')" title="Hapus"><i class="bi bi-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data produk bunga ditemukan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'tambah.php'; ?>
<div id="modalContainerEdit"></div>
<div id="modalContainerDetail"></div>

<div class="modal fade" id="modalCanvas" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 16px; border:none; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
      <div class="modal-header border-0 pb-0 px-4 pt-4">
        <h6 class="modal-title fw-bold text-dark d-flex align-items-center gap-2" style="font-size: 16px;">
             ✍️ TTD Digital Penerima/Kurir
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body px-4 pt-2">
         <p class="text-muted mb-3" style="font-size: 13px;">Goreskan tanda tangan kurir atau serah terima di bawah ini:</p>
         <canvas id="signature-canvas" width="450" height="220" class="w-100"></canvas>
         <input type="hidden" id="ttd_flower_id">
      </div>
      <div class="modal-footer border-0 px-4 pb-4 pt-2 d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-sm btn-light border px-3 py-2" id="clear-canvas" style="border-radius:8px; font-size:13px;">Batal</button>
        <button type="button" class="btn btn-sm btn-magenta-add px-4 py-2" id="save-canvas" style="border-radius:8px; font-size:13px;">Simpan TTD</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Event View (Modal Detail)
$(document).on('click', '.btn-view', function(){
    const id = $(this).data('id');
    $.get('detail.php?id=' + id, function(data){
        $('#modalContainerDetail').html(data);
        $('#modalDetail').modal('show');
    });
});

// Event Edit (Modal Edit Form)
$(document).on('click', '.btn-edit', function(){
    const id = $(this).data('id');
    $.get('edit.php?id=' + id, function(data){
        $('#modalContainerEdit').html(data);
        $('#modalEdit').modal('show');
    });
});

// Canvas Signature Realization Handler
const canvas = document.getElementById('signature-canvas');
const ctx = canvas.getContext('2d');
let drawing = false;

$(document).on('click', '.btn-canvas', function(){
    $('#ttd_flower_id').val($(this).data('id'));
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    $('#modalCanvas').modal('show');
});

canvas.addEventListener('mousedown', () => { drawing = true; ctx.beginPath(); });
canvas.addEventListener('mouseup', () => drawing = false);
canvas.addEventListener('mousemove', (e) => {
    if (!drawing) return;
    const r = canvas.getBoundingClientRect();
    ctx.lineWidth = 3; ctx.lineCap = 'round'; ctx.strokeStyle = '#262626';
    ctx.lineTo(e.clientX - r.left, e.clientY - r.top); ctx.stroke();
});

$('#clear-canvas').click(() => ctx.clearRect(0, 0, canvas.width, canvas.height));

$('#save-canvas').click(function(){
    const id = $('#ttd_flower_id').val();
    const dataURL = canvas.toDataURL('image/png');
    $.post('edit.php', { action: 'save_ttd', id: id, signature: dataURL }, function(){
        alert("Tanda tangan kurir berhasil disimpan ke dalam basis data produk!");
        $('#modalCanvas').modal('hide');
        location.reload();
    });
});
</script>
</body>
</html>