# CV + Katalog Sepatu (PHP)

Jalankan dari folder ini: `php -S localhost:8000` lalu buka http://localhost:8000
(atau taruh folder di htdocs XAMPP dan buka lewat localhost).

- index.php      : CV (Beranda, Tentang Kami, Skill, Experience, Katalog, Kontak)
- produk.php     : katalog produk (cari, filter merek, urutkan)
- keranjang.php  : keranjang belanja (session)
- aksi.php       : pemroses form keranjang dan pesan kontak
- data/produk.php: data produk (edit di sini untuk menambah produk)
- includes/      : header, footer, kartu produk, modal, fungsi
- css/style.css, js/script.js, images/*.svg

Pesan dari form kontak disimpan di data/pesan.csv (folder data harus bisa ditulis).
Harga produk hanya contoh/perkiraan.
