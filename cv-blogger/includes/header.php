<?php
/*
 * Header bersama (kepala HTML + bilah navigasi).
 * Variabel yang dibaca: $judul (judul tab), $halaman ('beranda' | 'katalog' | 'keranjang')
 */
require_once __DIR__ . '/functions.php';

$judul   = $judul   ?? 'CV - Sandika Alwa';
$halaman = $halaman ?? 'beranda';
$flash   = flash_get();
$jumlahKeranjang = cart_count();

/* Di halaman selain beranda, tautan anchor harus menuju index.php */
$base = $halaman === 'beranda' ? '' : 'index.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($judul) ?></title>
  <meta name="description" content="CV online Sandika Alwa, mahasiswa Sistem Informasi Universitas Gunadarma, dilengkapi katalog sepatu branded.">

  <!-- Font: Plus Jakarta Sans (judul) dan Inter (isi) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="css/style.css">
  <script src="js/script.js" defer></script>
</head>
<body class="halaman-<?= e($halaman) ?>">

<header class="navbar" id="navbar">
  <div class="container navbar-inner">
    <a href="index.php" class="brand">SANDIKA<span>.</span>ALWA</a>

    <button class="nav-toggle" id="navToggle" aria-label="Buka menu" aria-expanded="false" aria-controls="navMenu">
      <span></span><span></span><span></span>
    </button>

    <nav class="nav-menu" id="navMenu" aria-label="Navigasi utama">
      <a href="<?= $base ?>#beranda"    data-spy="beranda">Beranda</a>
      <a href="<?= $base ?>#tentang"    data-spy="tentang">Tentang Kami</a>
      <a href="<?= $base ?>#skill"      data-spy="skill">Skill</a>
      <a href="<?= $base ?>#experience" data-spy="experience">Experience</a>
      <a href="produk.php" class="<?= $halaman === 'katalog' ? 'aktif' : '' ?>">Katalog</a>
      <a href="<?= $base ?>#kontak"     data-spy="kontak">Kontak</a>
      <a href="keranjang.php" class="nav-cart <?= $halaman === 'keranjang' ? 'aktif' : '' ?>" aria-label="Keranjang">
        Keranjang
        <?php if ($jumlahKeranjang > 0): ?>
          <span class="badge"><?= $jumlahKeranjang ?></span>
        <?php endif; ?>
      </a>
    </nav>
  </div>
</header>

<?php if ($flash): ?>
  <div class="toast toast-<?= e($flash['tipe']) ?>" role="status"><?= e($flash['pesan']) ?></div>
<?php endif; ?>
