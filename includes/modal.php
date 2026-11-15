<!-- Jendela detail produk (diisi oleh js/script.js) -->
<div class="modal" id="modal" hidden>
  <div class="modal-latar" data-tutup></div>
  <div class="modal-kotak" role="dialog" aria-modal="true" aria-labelledby="mdNama">
    <button type="button" class="modal-tutup" data-tutup aria-label="Tutup">×</button>
    <div class="modal-gambar"><img id="mdGambar" src="" alt=""></div>
    <div class="modal-isi">
      <p class="kartu-kategori" id="mdKategori"></p>
      <h2 id="mdNama"></h2>
      <p class="modal-harga" id="mdHarga"></p>
      <p id="mdDeskripsi"></p>

      <h4>Ukuran tersedia</h4>
      <div class="ukuran" id="mdUkuran"></div>

      <h4>Spesifikasi</h4>
      <dl class="spek" id="mdSpek"></dl>

      <p class="status" id="mdStok"></p>

      <div class="modal-aksi">
        <form method="post" action="aksi.php">
          <?= csrf_field() ?>
          <input type="hidden" name="aksi" value="tambah">
          <input type="hidden" name="id" id="mdId" value="">
          <input type="hidden" name="kembali" value="<?= e($kembali ?? 'produk.php') ?>">
          <button type="submit" class="btn btn-utama">+ Keranjang</button>
        </form>
        <a class="btn btn-wa" id="mdWa" href="#" target="_blank" rel="noopener">Pesan via WhatsApp</a>
      </div>
    </div>
  </div>
</div>
