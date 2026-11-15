<?php
declare(strict_types=1);
/*
 * Pemroses semua form POST: keranjang dan pesan kontak.
 * Setelah selesai, pengguna dialihkan kembali (pola Post/Redirect/Get).
 */
require_once __DIR__ . '/includes/functions.php';

/* Hanya boleh kembali ke halaman milik situs ini */
$halamanBoleh = ['index.php', 'produk.php', 'keranjang.php'];

function kembali_ke(string $tujuan, array $boleh, string $anchor = ''): never
{
    $file = explode('#', explode('?', $tujuan)[0])[0];
    if (!in_array($file, $boleh, true)) {
        $tujuan = 'index.php';
    }
    header('Location: ' . $tujuan . $anchor);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$kembali = (string)($_POST['kembali'] ?? 'index.php');

if (!csrf_valid($_POST['csrf'] ?? null)) {
    flash_set('Sesi formulir tidak valid. Silakan coba lagi.', 'error');
    kembali_ke($kembali, $halamanBoleh);
}

$aksi = (string)($_POST['aksi'] ?? '');
$id   = (int)($_POST['id'] ?? 0);

switch ($aksi) {
    case 'tambah':
        $pesan = cart_add($id);
        flash_set($pesan, str_contains($pesan, 'tidak mencukupi') ? 'error' : 'ok');
        break;

    case 'kurang':
        cart_minus($id);
        break;

    case 'hapus':
        cart_remove($id);
        flash_set('Produk dihapus dari keranjang.');
        break;

    case 'kosongkan':
        cart_clear();
        flash_set('Keranjang dikosongkan.');
        break;

    case 'pesan':
        $nama  = trim((string)($_POST['nama'] ?? ''));
        $email = trim((string)($_POST['email'] ?? ''));
        $isi   = trim((string)($_POST['pesan'] ?? ''));

        if ($nama === '' || $isi === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            flash_set('Mohon isi nama, email yang valid, dan pesan.', 'error');
            kembali_ke('index.php', $halamanBoleh, '#kontak');
        }
        if (mb_strlen($nama) > 80 || mb_strlen($isi) > 1000) {
            flash_set('Nama atau pesan terlalu panjang.', 'error');
            kembali_ke('index.php', $halamanBoleh, '#kontak');
        }

        /* Simpan ke data/pesan.csv (butuh folder data bisa ditulis) */
        $berkas = __DIR__ . '/data/pesan.csv';
        $handle = @fopen($berkas, 'ab');
        if ($handle === false) {
            flash_set('Pesan belum bisa disimpan di server. Silakan hubungi lewat WhatsApp.', 'error');
            kembali_ke('index.php', $halamanBoleh, '#kontak');
        }
        flock($handle, LOCK_EX);
        fputcsv($handle, [date('Y-m-d H:i:s'), $nama, $email, $isi]);
        flock($handle, LOCK_UN);
        fclose($handle);

        flash_set('Terima kasih, ' . $nama . '! Pesan Anda sudah terkirim.');
        kembali_ke('index.php', $halamanBoleh, '#kontak');

    default:
        flash_set('Aksi tidak dikenal.', 'error');
}

kembali_ke($kembali, $halamanBoleh);
