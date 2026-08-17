<?php
session_start();
require_once 'includes/functions.php';
$profil = getProfil();
$page_title = 'Tentang Kami';
$active = 'tentang';
$show_navbar = true;
include 'includes/header.php';
?>

<div class="page-banner text-center">
  <div class="container">
    <h1 class="fw-bold">Tentang Kami</h1>
    <nav class="breadcrumb-custom justify-content-center d-flex gap-2 mt-2">
      <a href="index.php">Beranda</a> / <span class="active">Tentang Kami</span>
    </nav>
  </div>
</div>

<section>
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-6">
        <h6 class="text-primary fw-bold text-uppercase">Sejarah</h6>
        <h2 class="section-title mb-3">Perjalanan Kami</h2>
        <p><?= nl2br(htmlspecialchars($profil['sejarah'])) ?></p>
      </div>
      <div class="col-lg-6">
        <img src="<?= htmlspecialchars($profil['foto_sejarah']) ?>" class="img-fluid rounded-4 shadow" alt="sejarah">
      </div>
    </div>
  </div>
</section>

<section class="bg-light-blue">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-4">
        <div class="stat-card text-start h-100">
          <i class="fa-solid fa-eye mb-2"></i>
          <h5 class="fw-bold">Visi</h5>
          <p class="small text-muted mb-0"><?= nl2br(htmlspecialchars($profil['visi'])) ?></p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat-card text-start h-100">
          <i class="fa-solid fa-bullseye mb-2"></i>
          <h5 class="fw-bold">Misi</h5>
          <p class="small text-muted mb-0"><?= nl2br(htmlspecialchars($profil['misi'])) ?></p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat-card text-start h-100">
          <i class="fa-solid fa-flag-checkered mb-2"></i>
          <h5 class="fw-bold">Tujuan</h5>
          <p class="small text-muted mb-0"><?= nl2br(htmlspecialchars($profil['tujuan'])) ?></p>
        </div>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-lg-6">
        <h6 class="text-primary fw-bold text-uppercase">Nilai Nilai</h6>
        <h2 class="section-title mb-3">Nilai-Nilai Universitas</h2>
        <p><?= nl2br(htmlspecialchars($profil['nilai_nilai'])) ?></p>
      </div>
      <div class="col-lg-6">
        <h6 class="text-primary fw-bold text-uppercase">Organisasi</h6>
        <h2 class="section-title mb-3">Struktur Organisasi</h2>
        <img src="<?= htmlspecialchars($profil['foto_struktur']) ?>" class="img-fluid rounded-4 shadow" alt="struktur organisasi">
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
