<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';

$judul   = 'Keranjang - Sandika Alwa';
$halaman = 'keranjang';

/* Ubah isi session menjadi daftar baris yang siap ditampilkan */
$baris = [];
foreach (cart_get() as $id => $qty) {
    $p = find_product((int)$id);
    if ($p !== null) {
        $baris[] = ['p' => $p, 'qty' => $qty, 'subtotal' => $p['harga'] * $qty];
    }
}

/* Ringkasan pesanan untuk tombol WhatsApp */
$teksWa = "Halo, saya ingin memesan:\n";
foreach ($baris as $b) {
    $teksWa .= '- ' . $b['p']['nama'] . ' x' . $b['qty'] . ' = ' . rupiah($b['subtotal']) . "\n";
}
$teksWa .= 'Total: ' . rupiah(cart_total());
$linkWa  = 'https://wa.me/' . WA_NUMBER . '?text=' . rawurlencode($teksWa);

require __DIR__ . '/includes/header.php';
?>

<main>
  <section class="page-hero">
    <div class="container">
      <p class="eyebrow">Belanja</p>
      <h1>Keranjang Anda</h1>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <?php if (!$baris): ?>
        <div class="kosong">
          <p>Keranjang masih kosong.</p>
          <a class="btn btn-utama" href="produk.php">Lihat katalog</a>
        </div>
      <?php else: ?>
        <div class="keranjang">
          <?php foreach ($baris as $b): $p = $b['p']; ?>
            <div class="baris">
              <img src="<?= e($p['gambar']) ?>" alt="<?= e($p['nama']) ?>" width="120" height="80">
              <div class="baris-info">
                <h3><?= e($p['nama']) ?></h3>
                <p><?= e($p['merek']) ?> · <?= rupiah($p['harga']) ?></p>
              </div>

              <div class="qty">
                <form method="post" action="aksi.php">
                  <?= csrf_field() ?>
                  <input type="hidden" name="aksi" value="kurang">
                  <input type="hidden" name="id" value="<?= $p['id'] ?>">
                  <input type="hidden" name="kembali" value="keranjang.php">
                  <button type="submit" aria-label="Kurangi">−</button>
                </form>
                <span><?= $b['qty'] ?></span>
                <form method="post" action="aksi.php">
                  <?= csrf_field() ?>
                  <input type="hidden" name="aksi" value="tambah">
                  <input type="hidden" name="id" value="<?= $p['id'] ?>">
                  <input type="hidden" name="kembali" value="keranjang.php">
                  <button type="submit" aria-label="Tambah" <?= stock_left($p) < 1 ? 'disabled' : '' ?>>+</button>
                </form>
              </div>

              <p class="baris-subtotal"><?= rupiah($b['subtotal']) ?></p>

              <form method="post" action="aksi.php">
                <?= csrf_field() ?>
                <input type="hidden" name="aksi" value="hapus">
                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                <input type="hidden" name="kembali" value="keranjang.php">
                <button type="submit" class="btn-hapus" aria-label="Hapus">Hapus</button>
              </form>
            </div>
          <?php endforeach; ?>

          <div class="total">
            <span>Total</span>
            <strong><?= rupiah(cart_total()) ?></strong>
          </div>

          <div class="total-aksi">
            <form method="post" action="aksi.php">
              <?= csrf_field() ?>
              <input type="hidden" name="aksi" value="kosongkan">
              <input type="hidden" name="kembali" value="keranjang.php">
              <button type="submit" class="btn btn-garis">Kosongkan</button>
            </form>
            <a class="btn btn-utama" href="produk.php">Lanjut belanja</a>
            <a class="btn btn-wa" href="<?= e($linkWa) ?>" target="_blank" rel="noopener">Pesan via WhatsApp</a>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
