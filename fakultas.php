<?php
session_start();
require_once 'includes/functions.php';
$profil = getProfil();
$page_title = 'Fakultas';
$active = 'fakultas';
$show_navbar = true;
$fakultasList = mysqli_query($koneksi, "SELECT * FROM fakultas ORDER BY id ASC");
$totalFakultasRow = mysqli_num_rows($fakultasList);
include 'includes/header.php';
?>

<div class="page-banner text-center">
  <div class="container">
    <h1 class="fw-bold">Fakultas</h1>
    <nav class="breadcrumb-custom justify-content-center d-flex gap-2 mt-2">
      <a href="index.php">Beranda</a> / <span class="active">Fakultas</span>
    </nav>
  </div>
</div>

<section>
  <div class="container">
    <div class="row g-4 <?= $totalFakultasRow < 4 ? 'justify-content-center' : '' ?>">
      <?php $i = 0; while ($f = mysqli_fetch_assoc($fakultasList)):
        $fotoSrc = fotoUrl($f['foto']);
        $i++;
      ?>
      <div class="col-md-6 col-lg-3">
        <div class="card-custom">
          <img src="<?= htmlspecialchars($fotoSrc) ?>" alt="<?= htmlspecialchars($f['nama_fakultas']) ?>">
          <div class="p-3">
            <h6 class="fw-bold"><?= htmlspecialchars($f['nama_fakultas']) ?></h6>
            <p class="small text-muted mb-2"><i class="fa-solid fa-user-tie me-1"></i>Dekan: <?= htmlspecialchars($f['nama_dekan']) ?></p>
            <p class="small"><?= nl2br(htmlspecialchars($f['deskripsi'])) ?></p>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>