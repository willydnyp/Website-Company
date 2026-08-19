<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'db_universitas';

$koneksi = mysqli_connect($host, $user, $pass, $dbname);
if (!$koneksi) {
    die('Koneksi database gagal: ' . mysqli_connect_error());
}
mysqli_set_charset($koneksi, 'utf8mb4');

define('BASE_URL', '/Website Company/'); // sesuaikan jika nama folder project berbeda

function clean($koneksi, $str) {
    return mysqli_real_escape_string($koneksi, trim(htmlspecialchars($str ?? '')));
}

// Untuk konten kaya teks (hasil editor bold/italic/list, dsb) - simpan sebagai HTML
// yang sudah difilter, bukan di-escape penuh seperti clean().
function cleanRichText($koneksi, $html) {
    $html = trim($html ?? '');
    $tagDiizinkan = '<p><br><b><strong><i><em><u><s><strike><ul><ol><li><a><h2><h3><blockquote><span>';
    $html = strip_tags($html, $tagDiizinkan);
    $html = preg_replace('/\son\w+\s*=\s*"[^"]*"/i', '', $html);
    $html = preg_replace("/\son\w+\s*=\s*'[^']*'/i", '', $html);
    $html = preg_replace('/(href|src)\s*=\s*"\s*javascript:[^"]*"/i', '$1="#"', $html);
    return mysqli_real_escape_string($koneksi, $html);
}

function getProfil() {
    require __DIR__ . '/konfigurasi.php';
    return $profil;
}

function formatTanggalIndo($tanggal) {
    $bulan = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni',
              '07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
    $p = explode('-', $tanggal);
    if (count($p) < 3) return $tanggal;
    return $p[2] . ' ' . $bulan[$p[1]] . ' ' . $p[0];
}

function catatPengunjung($koneksi) {
    if (!isset($_SESSION['visited'])) {
        $ip = clean($koneksi, $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
        mysqli_query($koneksi, "INSERT INTO pengunjung (ip_address, tanggal) VALUES ('$ip', CURDATE())");
        $_SESSION['visited'] = true;
    }
}

function isLoggedIn() { return isset($_SESSION['admin_id']); }

function requireLogin() {
    if (!isLoggedIn()) { header('Location: ' . BASE_URL . 'login.php'); exit; }
}

function fotoUrl($foto, $prefix = '') {
    $foto = trim($foto ?? '');
    if ($foto === '') return null;
    if (preg_match('#^https?://#i', $foto)) return $foto;
    return $prefix . ltrim($foto, '/');
}
