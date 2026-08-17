<?php
session_start();
require_once 'includes/functions.php';
$profil = getProfil();
$page_title = 'Galeri';
$active = 'galeri';
$show_navbar = true;
$galeriList = mysqli_query($koneksi, "SELECT * FROM galeri ORDER BY id DESC");
include 'includes/header.php';
?>

<div class="page-banner text-center">
  <div class="container">
    <h1 class="fw-bold">Galeri Kampus</h1>
    <nav class="breadcrumb-custom justify-content-center d-flex gap-2 mt-2">
      <a href="index.php">Beranda</a> / <span class="active">Galeri</span>
    </nav>
  </div>
</div>

<section>
  <div class="container">
    <div class="row g-3">
      <?php $i = 0; while ($g = mysqli_fetch_assoc($galeriList)):
        $fotoSrc = fotoUrl($g['foto']);
        $i++;
      ?>
      <div class="col-6 col-md-4">
        <div class="gallery-item">
          <img src="<?= htmlspecialchars($fotoSrc) ?>" alt="<?= htmlspecialchars($g['judul']) ?>">
          <div class="gallery-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
        </div>
        <p class="text-center small text-muted mt-1 mb-0"><?= htmlspecialchars($g['judul']) ?></p>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<div class="modal fade" id="lightboxModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-transparent border-0">
      <button type="button" class="btn-close btn-close-white ms-auto me-2 mt-2" data-bs-dismiss="modal"></button>
      <img id="lightboxImg" src="" class="img-fluid rounded-4" alt="preview">
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>