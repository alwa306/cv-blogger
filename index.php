<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';

$judul   = 'CV - Sandika Alwa | Mahasiswa Sistem Informasi';
$halaman = 'beranda';

/* Pratinjau katalog: 3 produk pertama yang stoknya masih ada */
$pratinjau = array_slice(
    array_values(array_filter(load_products(), fn($p) => $p['stok'] > 0)),
    0,
    3
);
$kembali = 'index.php';

require __DIR__ . '/includes/header.php';
?>

<main>

  <!-- ===== BERANDA / HERO ===== -->
  <section class="hero" id="beranda">
    <div class="container hero-inner">
      <div class="hero-teks">
        <p class="eyebrow">Curriculum Vitae</p>
        <h1>Sandika <span>Alwa</span></h1>
        <p class="hero-jabatan">Mahasiswa Sistem Informasi</p>
        <p class="lead">Mahasiswa aktif Universitas Gunadarma dengan fokus pada pengembangan web. Terus belajar dan terbiasa bekerja dalam tim.</p>
        <div class="hero-aksi">
          <a href="#kontak" class="btn btn-utama">Hubungi Saya</a>
          <a href="produk.php" class="btn btn-terang">Lihat Katalog</a>
          <button type="button" class="btn btn-garis-terang" data-cetak>Cetak / Simpan PDF</button>
        </div>
      </div>

      <ul class="hero-kartu">
        <li><span>Kampus</span><strong>Universitas Gunadarma</strong></li>
        <li><span>Program studi</span><strong>Sarjana Sistem Informasi</strong></li>
        <li><span>IPK</span><strong>&ge; 3.5</strong></li>
        <li><span>Domisili</span><strong>Pancoran Mas, Depok</strong></li>
      </ul>
    </div>
  </section>

  <!-- ===== TENTANG KAMI ===== -->
  <section class="section" id="tentang">
    <div class="container">
      <p class="eyebrow">Tentang Kami</p>
      <h2 class="judul-seksi">Profil Singkat</h2>

      <div class="dua-kolom">
        <div>
          <p class="isi-besar">
            Mahasiswa aktif di Universitas Gunadarma dengan fokus pada pengembangan web.
            Memiliki niat belajar dan tekad kuat untuk terus berkembang. Terbiasa bekerja dalam tim lintas fungsi
            dan memiliki kemampuan komunikasi yang baik untuk menjelaskan solusi teknis kepada pihak non-teknis.
          </p>
        </div>

        <div class="kartu-info">
          <h3>Pendidikan</h3>
          <p class="info-judul">Sarjana Sistem Informasi</p>
          <p class="info-sub">Universitas Gunadarma, 2024 - sekarang</p>
          <ul class="daftar">
            <li>Fokus pada pembelajaran sejak semester 1 sampai sekarang.</li>
            <li>Mempertahankan IPK &ge; 3.5.</li>
            <li>Mendapat nilai A di semua mata kuliah semester 4.</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== SKILL ===== -->
  <section class="section section-abu" id="skill">
    <div class="container">
      <p class="eyebrow">Skill</p>
      <h2 class="judul-seksi">Kemampuan Saya</h2>

      <div class="dua-kolom">
        <div class="kartu-info">
          <h3>Professional Skill</h3>
          <ul class="daftar">
            <li><strong>Komunikasi Efektif:</strong> mampu menjelaskan solusi teknis kepada tim non-teknis.</li>
            <li><strong>Kerja Sama Tim:</strong> terbiasa bekerja dalam tim lintas fungsi.</li>
            <li><strong>Kemampuan Adaptasi:</strong> cepat beradaptasi dengan teknologi baru.</li>
          </ul>
        </div>

        <div class="kartu-info">
          <h3>Technical Skill</h3>
          <p class="tag-judul">Bahasa Pemrograman</p>
          <div class="tags">
            <?php foreach (['Pascal', 'Python', 'C#', 'SQL', 'HTML', 'Java'] as $s): ?><span class="tag"><?= e($s) ?></span><?php endforeach; ?>
          </div>
          <p class="tag-judul">Desain</p>
          <div class="tags">
            <?php foreach (['Figma', 'CSS', 'Photoshop'] as $s): ?><span class="tag"><?= e($s) ?></span><?php endforeach; ?>
          </div>
          <p class="tag-judul">Lainnya</p>
          <div class="tags">
            <?php foreach (['Git', 'Qbasic', 'Lazarus'] as $s): ?><span class="tag"><?= e($s) ?></span><?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== EXPERIENCE ===== -->
  <section class="section" id="experience">
    <div class="container">
      <p class="eyebrow">Experience</p>
      <h2 class="judul-seksi">Pengalaman &amp; Portfolio</h2>

      <div class="timeline">
        <article class="timeline-item">
          <div class="timeline-head">
            <h3>Prestasi</h3>
            <span class="tanggal">2018 - 2024</span>
          </div>
          <p class="info-sub">Ponpes Ummul Quro Al-islami, Bogor</p>
          <ul class="daftar">
            <li>Menjadi anggota literatur sejak kelas 2 Mts hingga kelas 2 Ma.</li>
            <li>Menjadi Sekretaris sekaligus Wakil Ketua Perpustakaan.</li>
            <li>Mendapat rangking 3 saat kelas 2 Mts.</li>
            <li>Membantu sekolah dengan aktif dalam organisasi pondok.</li>
            <li>Menyelesaikan ujian praktek pidato, simulasi guru, dan imam.</li>
            <li>Menjadi anggota tim kreatif dalam acara pondok.</li>
            <li>Membuat desain dalam acara pondok.</li>
          </ul>
        </article>

        <article class="timeline-item">
          <div class="timeline-head">
            <h3>Tutorial Pembuatan Web</h3>
            <span class="tanggal">Portfolio</span>
          </div>
          <ul class="daftar">
            <li><strong>URL:</strong> <a href="https://youtu.be/iik25wqIuFo?si=A6CaZOJJNoGUF2Ud" target="_blank" rel="noopener">tutorial lengkap di YouTube</a></li>
            <li><strong>Tanggung jawab:</strong> membuat video dengan kreatif.</li>
            <li><strong>Fitur utama:</strong> mengetahui cara membuat web dari nol.</li>
            <li><strong>Hasil:</strong> ditonton sebanyak 15 juta kali di YouTube.</li>
          </ul>
        </article>
      </div>
    </div>
  </section>

  <!-- ===== PRATINJAU KATALOG ===== -->
  <section class="section section-abu" id="katalog">
    <div class="container">
      <p class="eyebrow">Katalog Produk</p>
      <h2 class="judul-seksi">Sepatu Branded Pilihan</h2>

      <div class="grid-produk">
        <?php foreach ($pratinjau as $p): ?>
          <?php include __DIR__ . '/includes/kartu_produk.php'; ?>
        <?php endforeach; ?>
      </div>

      <p class="tengah"><a class="btn btn-utama" href="produk.php">Lihat semua produk</a></p>
    </div>
  </section>

  <!-- ===== KONTAK ===== -->
  <section class="section" id="kontak">
    <div class="container">
      <p class="eyebrow">Kontak</p>
      <h2 class="judul-seksi">Mari Terhubung</h2>

      <div class="dua-kolom">
        <ul class="kontak-daftar">
          <li><span>Alamat</span><strong>Pancoran Mas, Depok</strong></li>
          <li><span>Telepon / WhatsApp</span><a href="https://wa.me/<?= WA_NUMBER ?>" target="_blank" rel="noopener">0857-3320-2006</a></li>
          <li><span>Email</span><a href="mailto:sandikaalwa306@gmail.com">sandikaalwa306@gmail.com</a></li>
        </ul>

        <form class="form-kontak" method="post" action="aksi.php">
          <?= csrf_field() ?>
          <input type="hidden" name="aksi" value="pesan">

          <label for="nama">Nama</label>
          <input type="text" id="nama" name="nama" maxlength="80" required>

          <label for="email">Email</label>
          <input type="email" id="email" name="email" required>

          <label for="pesan">Pesan</label>
          <textarea id="pesan" name="pesan" rows="4" maxlength="1000" required></textarea>

          <button type="submit" class="btn btn-utama">Kirim Pesan</button>
        </form>
      </div>
    </div>
  </section>

</main>

<?php include __DIR__ . '/includes/modal.php'; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
