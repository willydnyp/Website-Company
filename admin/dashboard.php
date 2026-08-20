<?php
session_start();
require_once '../includes/functions.php';
requireLogin();

$page_title = 'Dashboard';
$active_menu = 'dashboard';

$totalMhs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM mahasiswa"))['c'];
$totalDosen = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM dosen"))['c'];
$totalFakultas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM fakultas"))['c'];
$totalBerita = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM berita"))['c'];
$totalGaleri = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM galeri"))['c'];

include 'includes/layout.php';
?>

<div class="row g-3">
  <div class="col-md-4 col-lg-2"><div class="card dash-card p-3 d-flex flex-row align-items-center gap-3"><div class="icon-box bg-primary"><i class="fa-solid fa-user-graduate"></i></div><div><h4 class="fw-bold mb-0"><?= $totalMhs ?></h4><small class="text-muted">Mahasiswa</small></div></div></div>
  <div class="col-md-4 col-lg-2"><div class="card dash-card p-3 d-flex flex-row align-items-center gap-3"><div class="icon-box bg-success"><i class="fa-solid fa-chalkboard-user"></i></div><div><h4 class="fw-bold mb-0"><?= $totalDosen ?></h4><small class="text-muted">Dosen</small></div></div></div>
  <div class="col-md-4 col-lg-2"><div class="card dash-card p-3 d-flex flex-row align-items-center gap-3"><div class="icon-box bg-warning"><i class="fa-solid fa-building-columns"></i></div><div><h4 class="fw-bold mb-0"><?= $totalFakultas ?></h4><small class="text-muted">Fakultas</small></div></div></div>
  <div class="col-md-4 col-lg-2"><div class="card dash-card p-3 d-flex flex-row align-items-center gap-3"><div class="icon-box bg-info"><i class="fa-solid fa-newspaper"></i></div><div><h4 class="fw-bold mb-0"><?= $totalBerita ?></h4><small class="text-muted">Berita</small></div></div></div>
  <div class="col-md-4 col-lg-2"><div class="card dash-card p-3 d-flex flex-row align-items-center gap-3"><div class="icon-box bg-danger"><i class="fa-solid fa-images"></i></div><div><h4 class="fw-bold mb-0"><?= $totalGaleri ?></h4><small class="text-muted">Galeri</small></div></div></div>
</div>

<?php include 'includes/footer.php'; ?>
