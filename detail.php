<?php
include 'setup.php';

if (isset($_GET['id'])):
    $id = intval($_GET['id']);
    $res = $conn->query("SELECT * FROM flowers WHERE id = $id");
    $data = $res->fetch_assoc();
    
    // Validasi pengecekan null gambar_files sebelum di-decode
    $gambar_raw = isset($data['gambar_files']) ? $data['gambar_files'] : '';
    $images = !empty($gambar_raw) ? json_decode($gambar_raw, true) : [];
    $jumlah_gambar = is_array($images) ? count($images) : 0;
?>
<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg" style="border-radius:16px; border:none;">
      <div class="modal-header border-0 px-4 pt-4 pb-0">
        <h6 class="modal-title fw-bold text-dark" style="font-size:15px;">Detail Produk: <?= htmlspecialchars($data['nama_bunga']); ?></h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body px-4 pt-3 pb-2" style="font-size:14px;">
         <div class="alert alert-danger text-center fw-bold py-2 mb-3" style="background-color: #ffebe9; color: #ff4d4f; border:none; border-radius:8px; font-size:13px;">
              Data Tersemat Sistem
         </div>
         <table class="table table-sm table-borderless m-0">
             <tr style="line-height:2.2;">
                 <td width="42%" class="text-secondary fw-medium">ID Register:</td>
                 <td class="text-dark fw-semibold">FLW-<?= $data['id']; ?></td>
             </tr>
             <tr style="line-height:2.2;">
                 <td class="text-secondary fw-medium">Nama Varian:</td>
                 <td class="text-dark"><?= htmlspecialchars($data['nama_bunga']); ?></td>
             </tr>
             <tr style="line-height:2.2;">
                 <td class="text-secondary fw-medium">Klasifikasi/Kategori:</td>
                 <td class="text-dark"><span class="badge bg-light text-dark border px-2 py-1"><?= htmlspecialchars($data['kategori']); ?></span></td>
             </tr>
             <tr style="line-height:2.2;">
                 <td class="text-secondary fw-medium">Nilai Valuasi Jual:</td>
                 <td class="text-danger fw-bold">Rp <?= number_format($data['harga'], 0, ',', '.'); ?></td>
             </tr>
             <tr style="line-height:2.2;">
                 <td class="text-secondary fw-medium">Kuantitas Gudang:</td>
                 <td class="text-dark fw-medium"><?= $data['stok']; ?> unit</td>
             </tr>
             <tr style="line-height:2.2;">
                 <td class="text-secondary fw-medium">Jumlah File Gambar:</td>
                 <td class="text-dark"><?= $jumlah_gambar; ?> Berkas Foto</td>
             </tr>
             <?php if(!empty($data['ttd_digital'])): ?>
             <tr>
                 <td class="text-secondary fw-medium pt-3">TTD Penerima:</td>
                 <td class="pt-2"><img src="<?= $data['ttd_digital']; ?>" alt="Signature" class="border rounded-3 bg-white p-1" width="160"></td>
             </tr>
             <?php endif; ?>
         </table>
      </div>
      <div class="modal-footer border-0 px-4 pb-4 pt-1">
        <button type="button" class="btn btn-dark px-4" data-bs-dismiss="modal" style="border-radius:8px; font-size:13px; background-color:#141414;">Tutup</button>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>