<?php
if (basename($_SERVER['PHP_SELF']) == 'tambah.php') {
    include 'setup.php';
}

if (isset($_POST['simpan_bunga'])) {
    $nama_bunga   = $_POST['nama_bunga'];
    $kategori     = $_POST['kategori'];
    $harga        = $_POST['harga'];
    $stok         = $_POST['stok'];
    $status_stok  = ($stok == 0) ? 'Habis Total' : (($stok <= 3) ? 'Stok Tipis' : 'Ready');

    $uploaded_files = [];
    if (!empty($_FILES['gambar_bunga']['name'][0])) {
        if (!is_dir('uploads')) mkdir('uploads', 0777, true);
        foreach ($_FILES['gambar_bunga']['tmp_name'] as $key => $tmp_name) {
            $file_name = time() . '_' . $_FILES['gambar_bunga']['name'][$key];
            if (move_uploaded_file($tmp_name, 'uploads/' . $file_name)) {
                $uploaded_files[] = $file_name;
            }
        }
    }
    $gambar_json = $conn->real_escape_string(json_encode($uploaded_files));

    $sql = "INSERT INTO flowers (nama_bunga, kategori, harga, stok, status_stok, gambar_files) 
            VALUES ('$nama_bunga', '$kategori', '$harga', '$stok', '$status_stok', '$gambar_json')";
    $conn->query($sql);
    header("Location: index.php");
    exit;
}
?>
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form action="tambah.php" method="POST" enctype="multipart/form-data" class="modal-content" style="border-radius:16px; border:none;">
      <div class="modal-header border-0 px-4 pt-4 pb-0">
        <h6 class="modal-title fw-bold text-dark" style="font-size:16px;">🌺 Tambah Data Bunga</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body px-4 py-3" style="font-size: 14px;">
        <div class="mb-3">
            [cite_start]<label class="form-label fw-semibold text-secondary mb-1">Nama Bunga </label>
            <input type="text" name="nama_bunga" class="form-control" required placeholder="Masukkan nama varian bunga...">
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold text-secondary mb-1">Kategori</label>
            <select name="kategori" class="form-select">
                <option value="Papan Ucapan">Papan Ucapan</option>
                <option value="Bunga Meja">Bunga Meja</option>
                <option value="Bouquet Wisuda">Bouquet Wisuda</option>
                <option value="Bouquet">Bouquet</option>
                <option value="Decor Wedding">Decor Wedding</option>

            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold text-secondary mb-1">Harga</label>
            <input type="number" name="harga" class="form-control" required placeholder="Nilai Rupiah...">
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold text-secondary mb-1">Stok Gudang</label>
            <input type="number" name="stok" class="form-control" required placeholder="Jumlah unit...">
        </div>
        <div class="mb-2">
            <label class="form-label fw-semibold text-secondary mb-1">Upload Foto Bunga (Multiple)</label>
            <input type="file" name="gambar_bunga[]" class="form-control" multiple>
        </div>
      </div>
      <div class="modal-footer border-0 px-4 pb-4 pt-1">
        <button type="button" class="btn btn-light border px-3" data-bs-dismiss="modal" style="border-radius:8px;">Batal</button>
        [cite_start]<button type="submit" name="simpan_bunga" class="btn btn-magenta-add px-4" style="border-radius:8px;">Simpan [cite: 25]</button>
      </div>
    </form>
  </div>
</div>