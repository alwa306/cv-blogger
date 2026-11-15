<?php
/*
 * Satu kartu produk. Dipakai di produk.php dan di pratinjau index.php.
 * Variabel yang dibaca: $p (array produk)
 */
$sisa = stock_left($p);

if ($p['stok'] === 0) {
    $statusKelas = 'habis';
    $statusTeks  = 'Stok habis';
} elseif ($sisa === 0) {
    $statusKelas = 'habis';
    $statusTeks  = 'Semua stok ada di keranjang';
} elseif ($sisa <= 3) {
    $statusKelas = 'menipis';
    $statusTeks  = 'Stok menipis: ' . $sisa . ' pasang';
} else {
    $statusKelas = 'tersedia';
    $statusTeks  = 'Stok: ' . $sisa . ' pasang';
}

$pesanWa = 'Halo, saya ingin memesan ' . $p['nama'] . ' (' . rupiah($p['harga']) . ').';
$linkWa  = 'https://wa.me/' . WA_NUMBER . '?text=' . rawurlencode($pesanWa);

/* Data untuk jendela detail (dibaca oleh JavaScript) */
$dataModal = [
    'id'        => $p['id'],
    'nama'      => $p['nama'],
    'merek'     => $p['merek'],
    'kategori'  => $p['kategori'],
    'harga'     => rupiah($p['harga']),
    'deskripsi' => $p['deskripsi'],
    'gambar'    => $p['gambar'],
    'ukuran'    => $p['ukuran'],
    'spek'      => $p['spesifikasi'],
    'stok'      => $statusTeks,
    'wa'        => $linkWa,
];
?>
<article class="kartu <?= $p['stok'] === 0 ? 'kartu-habis' : '' ?>" data-merek="<?= e($p['merek']) ?>">
  <div class="kartu-gambar">
    <img src="<?= e($p['gambar']) ?>" alt="<?= e($p['nama']) ?>" loading="lazy" width="600" height="400">
    <span class="chip-merek"><?= e($p['merek']) ?></span>
    <button type="button" class="btn-suka" data-suka="<?= $p['id'] ?>" aria-label="Simpan ke favorit" aria-pressed="false">♥</button>
  </div>

  <div class="kartu-isi">
    <p class="kartu-kategori"><?= e($p['kategori']) ?> · ID <?= $p['id'] ?></p>
    <h3 class="kartu-nama"><?= e($p['nama']) ?></h3>
    <p class="kartu-deskripsi"><?= e($p['deskripsi']) ?></p>

    <span class="status status-<?= $statusKelas ?>"><?= e($statusTeks) ?></span>

    <p class="kartu-harga"><?= rupiah($p['harga']) ?></p>
    <p class="kartu-catatan">perkiraan harga</p>

    <div class="kartu-aksi">
      <button type="button" class="btn btn-garis btn-detail"
              data-produk="<?= e(json_encode($dataModal, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ?>">Detail</button>

      <form method="post" action="aksi.php">
        <?= csrf_field() ?>
        <input type="hidden" name="aksi" value="tambah">
        <input type="hidden" name="id" value="<?= $p['id'] ?>">
        <input type="hidden" name="kembali" value="<?= e($kembali ?? 'produk.php') ?>">
        <button type="submit" class="btn btn-utama" <?= $sisa < 1 ? 'disabled' : '' ?>>
          <?= $sisa < 1 ? 'Tidak tersedia' : '+ Keranjang' ?>
        </button>
      </form>

      <a class="btn btn-wa <?= $p['stok'] === 0 ? 'btn-nonaktif' : '' ?>" href="<?= e($linkWa) ?>" target="_blank" rel="noopener">WhatsApp</a>
    </div>
  </div>
</article>
