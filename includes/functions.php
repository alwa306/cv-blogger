<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Nomor WhatsApp (format internasional tanpa +) untuk tombol "Pesan via WhatsApp" */
const WA_NUMBER = '6285733202006';

/* ---------- Helper umum ---------- */

/** Escape output agar aman dari XSS. */
function e(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

/** Format angka menjadi Rupiah, contoh: Rp 1.549.000 */
function rupiah(int $angka): string
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

/* ---------- Data produk ---------- */

function load_products(): array
{
    static $produk = null;
    if ($produk === null) {
        $produk = require __DIR__ . '/../data/produk.php';
    }
    return $produk;
}

function find_product(int $id): ?array
{
    foreach (load_products() as $p) {
        if ($p['id'] === $id) {
            return $p;
        }
    }
    return null;
}

/** Daftar merek unik (untuk tombol filter). */
function product_brands(): array
{
    $merek = array_unique(array_column(load_products(), 'merek'));
    sort($merek);
    return $merek;
}

/* ---------- Keranjang (disimpan di session) ---------- */

function cart_get(): array
{
    return $_SESSION['cart'] ?? [];
}

function cart_qty(int $id): int
{
    return (int)(cart_get()[$id] ?? 0);
}

function cart_count(): int
{
    return array_sum(cart_get());
}

/** Sisa stok = stok gudang dikurangi jumlah yang sudah masuk keranjang. */
function stock_left(array $produk): int
{
    return max(0, $produk['stok'] - cart_qty($produk['id']));
}

function cart_add(int $id): string
{
    $p = find_product($id);
    if ($p === null) {
        return 'Produk tidak ditemukan.';
    }
    if (stock_left($p) < 1) {
        return 'Stok ' . $p['nama'] . ' tidak mencukupi.';
    }
    $_SESSION['cart'][$id] = cart_qty($id) + 1;
    return $p['nama'] . ' ditambahkan ke keranjang.';
}

function cart_minus(int $id): void
{
    $qty = cart_qty($id) - 1;
    if ($qty <= 0) {
        unset($_SESSION['cart'][$id]);
    } else {
        $_SESSION['cart'][$id] = $qty;
    }
}

function cart_remove(int $id): void
{
    unset($_SESSION['cart'][$id]);
}

function cart_clear(): void
{
    unset($_SESSION['cart']);
}

function cart_total(): int
{
    $total = 0;
    foreach (cart_get() as $id => $qty) {
        $p = find_product((int)$id);
        if ($p !== null) {
            $total += $p['harga'] * $qty;
        }
    }
    return $total;
}

/* ---------- Keamanan form & notifikasi ---------- */

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function csrf_valid(?string $token): bool
{
    return is_string($token) && hash_equals($_SESSION['csrf'] ?? '', $token);
}

function flash_set(string $pesan, string $tipe = 'ok'): void
{
    $_SESSION['flash'] = ['pesan' => $pesan, 'tipe' => $tipe];
}

function flash_get(): ?array
{
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $f;
}
