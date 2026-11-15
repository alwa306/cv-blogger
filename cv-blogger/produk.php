<?php
declare(strict_types=1);
/* Halaman katalog produk: pencarian, filter merek, dan pengurutan dilakukan di PHP. */
require_once __DIR__ . '/includes/functions.php';

$judul   = 'Katalog Sepatu - Sandika Alwa';
$halaman = 'katalog';

/* ---- Baca parameter filter dari URL (?q=...&merek=...&urut=...) ---- */
$q     = trim((string)($_GET['q'] ?? ''));
$merek = (string)($_GET['merek'] ?? '');
$urut  = (string)($_GET['urut'] ?? 'default');

$daftarMerek = product_brands();
if (!in_array($merek, $daftarMerek, true)) {
    $merek = '';
}

$produk = load_products();

if ($merek !== '') {
    $produk = array_filter($produk, fn($p) => $p['merek'] === $merek);
}
if ($q !== '') {
    $produk = array_filter($produk, fn($p) =>
        stripos($p['nama'] . ' ' . $p['merek'] . ' ' . $p['kategori'], $q) !== false
    );
}

switch ($urut) {
    case 'termurah':
        usort($produk, fn($a, $b) => $a['harga'] <=> $b['harga']);
        break;
    case 'termahal':
        usort($produk, fn($a, $b) => $b['harga'] <=> $a['harga']);
        break;
    case 'stok':
        usort($produk, fn($a, $b) => $b['stok'] <=> $a['stok']);
        break;
    default:
        $produk = array_values($produk);
}

$totalStok  = array_sum(array_column(load_products(), 'stok'));
$kembali    = 'produk.php' . ($_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '');

/** Bangun URL filter sambil mempertahankan parameter lain. */
function url_filter(array $ubah): string
{
    $param = array_merge($_GET, $ubah);
    $param = array_filter($param, fn($v) => $v !== '' && $v !== null);
    return 'produk.php' . ($param ? '?' . http_build_query($param) : '');
}

require __DIR__ . '/includes/header.php';
?>

<main>
  <section class="page-hero">
    <div class="container">
      <p class="eyebrow">Tugas Web PHP</p>
      <h1>Katalog Sepatu Branded</h1>
      <p class="lead">Contoh katalog sepatu untuk tugas kuliah. Data produk bukan milik pribadi dan harga hanya perkiraan.</p>
      <ul class="hero-stats">
        <li><strong><?= count(load_products()) ?></strong> produk</li>
        <li><strong><?= count($daftarMerek) ?></strong> merek</li>
        <li><strong><?= $totalStok ?></strong> pasang tersedia</li>
      </ul>
    </div>
  </section>

  <section class="section">
    <div class="container">

      <form class="filter-bar" method="get" action="produk.php">
        <label class="visually-hidden" for="q">Cari sepatu</label>
        <input type="search" id="q" name="q" value="<?= e($q) ?>" placeholder="Cari nama, merek, atau kategori...">
        <?php if ($merek !== ''): ?>
          <input type="hidden" name="merek" value="<?= e($merek) ?>">
        <?php endif; ?>

        <label class="visually-hidden" for="urut">Urutkan</label>
        <select id="urut" name="urut" onchange="this.form.submit()">
          <option value="default"  <?= $urut === 'default'  ? 'selected' : '' ?>>Urutkan: Default</option>
          <option value="termurah" <?= $urut === 'termurah' ? 'selected' : '' ?>>Harga termurah</option>
          <option value="termahal" <?= $urut === 'termahal' ? 'selected' : '' ?>>Harga termahal</option>
          <option value="stok"     <?= $urut === 'stok'     ? 'selected' : '' ?>>Stok terbanyak</option>
        </select>
        <button type="submit" class="btn btn-utama">Cari</button>
      </form>

      <div class="chips" role="group" aria-label="Filter merek">
        <a href="<?= e(url_filter(['merek' => ''])) ?>" class="chip <?= $merek === '' ? 'aktif' : '' ?>">Semua</a>
        <?php foreach ($daftarMerek as $m): ?>
          <a href="<?= e(url_filter(['merek' => $m])) ?>" class="chip <?= $merek === $m ? 'aktif' : '' ?>"><?= e($m) ?></a>
        <?php endforeach; ?>
      </div>

      <p class="hasil-info">Menampilkan <strong><?= count($produk) ?></strong> produk<?= $merek !== '' ? ' untuk merek ' . e($merek) : '' ?><?= $q !== '' ? ' dengan kata kunci "' . e($q) . '"' : '' ?>.</p>

      <?php if (count($produk) === 0): ?>
        <div class="kosong">
          <p>Produk tidak ditemukan.</p>
          <a class="btn btn-utama" href="produk.php">Reset filter</a>
        </div>
      <?php else: ?>
        <div class="grid-produk">
          <?php foreach ($produk as $p): ?>
            <?php include __DIR__ . '/includes/kartu_produk.php'; ?>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

    </div>
  </section>
</main>

<?php include __DIR__ . '/includes/modal.php'; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
