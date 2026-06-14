<?php
include 'setup.php';

if (isset($_POST['action']) && $_POST['action'] == 'save_ttd') {
    $id = $_POST['id'];
    $ttd_base64 = $conn->real_escape_string($_POST['signature']);
    $conn->query("UPDATE flowers SET ttd_digital = '$ttd_base64' WHERE id = $id");
    echo "Success";
    exit;
}

if (isset($_POST['update_bunga'])) {
    $id           = $_POST['id'];
    $nama_bunga   = $_POST['nama_bunga'];
    $kategori     = $_POST['kategori'];
    $harga        = $_POST['harga'];
    $stok         = $_POST['stok'];
    $status_stok  = ($stok == 0) ? 'Habis Total' : (($stok <= 3) ? 'Stok Tipis' : 'Ready');

    if (!empty($_FILES['gambar_bunga']['name'][0])) {
        $uploaded_files = [];
        foreach ($_FILES['gambar_bunga']['tmp_name'] as $key => $tmp_name) {
            $file_name = time() . '_' . $_FILES['gambar_bunga']['name'][$key];
            if (move_uploaded_file($tmp_name, 'uploads/' . $file_name)) {
                $uploaded_files[] = $file_name;
            }
        }
        $gambar_json = $conn->real_escape_string(json_encode($uploaded_files));
        $conn->query("UPDATE flowers SET nama_bunga='$nama_bunga', kategori='$kategori', harga='$harga', stok='$stok', status_stok='$status_stok', gambar_files='$gambar_json' WHERE id=$id");
    } else {
        $conn->query("UPDATE flowers SET nama_bunga='$nama_bunga', kategori='$kategori', harga='$harga', stok='$stok', status_stok='$status_stok' WHERE id=$id");
    }
    header("Location: index.php");
    exit;
}

if (isset($_GET['id'])):
    $id = intval($_GET['id']);
    $res = $conn->query("SELECT * FROM flowers WHERE id = $id");
    $data = $res->fetch_assoc();
?>
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form action="edit.php" method="POST" enctype="multipart/form-data" class="modal-content" style="border-radius:16px; border:none;">
      <div class="modal-header border-0 px-4 pt-4 pb-0">
        <h6 class="modal-title fw-bold text-dark" style="font-size:16px;">✏️ Perbarui Data Bunga</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body px-4 py-3" style="font-size:14px;">
        <input type="hidden" name="id" value="<?= $data['id']; ?>">
        <div class="mb-3">
            <label class="form-label fw-semibold text-secondary mb-1">Nama Bunga</label>
            <input type="text" name="nama_bunga" class="form-control" value="<?= htmlspecialchars($data['nama_bunga']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold text-secondary mb-1">Kategori</label>
            <select name="kategori" class="form-select">
                <option value="Papan Ucapan" <?= $data['kategori'] == 'Papan Ucapan' ? 'selected' : ''; ?>>Papan Ucapan</option>
                <option value="Bunga Meja" <?= $data['kategori'] == 'Bunga Meja' ? 'selected' : ''; ?>>Bunga Meja</option>
                <option value="Bouquet Wisuda" <?= $data['kategori'] == 'Bouquet Wisuda' ? 'selected' : ''; ?>>Bouquet Wisuda</option>
                <option value="Bouquet " <?= $data['kategori'] == 'Bouquet' ? 'selected' : ''; ?>>Bouquet</option>
                <option value="Decor Wedding" <?= $data['kategori'] == 'Decor Wedding' ? 'selected' : ''; ?>>Decor Wedding</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold text-secondary mb-1">Harga Jual</label>
            <input type="number" name="harga" class="form-control" value="<?= $data['harga']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold text-secondary mb-1">Stok Gudang</label>
            <input type="number" name="stok" class="form-control" value="<?= $data['stok']; ?>" required>
        </div>
        <div class="mb-2">
            <label class="form-label fw-semibold text-secondary mb-1">Ganti Berkas Gambar (Opsional)</label>
            <input type="file" name="gambar_bunga[]" class="form-control" multiple>
        </div>
      </div>
      <div class="modal-footer border-0 px-4 pb-4 pt-1">
        <button type="button" class="btn btn-light border px-3" data-bs-dismiss="modal" style="border-radius:8px;">Batal</button>
        <button type="submit" name="update_bunga" class="btn btn-magenta-add px-4" style="border-radius:8px;">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>