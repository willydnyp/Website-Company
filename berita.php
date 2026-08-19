<?php
session_start();
require_once 'includes/functions.php';
$profil = getProfil();
$page_title = 'Berita';
$active = 'berita';
$show_navbar = true;

$halaman = max(1, (int)($_GET['halaman'] ?? 1));
$perHalaman = 6;
$offset = ($halaman - 1) * $perHalaman;

$total = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM berita"))['c'];
$totalHalaman = ceil($total / $perHalaman);

$beritaList = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY tanggal DESC, id DESC LIMIT $perHalaman OFFSET $offset");

include 'includes/header.php';
?>

<div class="page-banner text-center">
  <div class="container">
    <h1 class="fw-bold">Berita &amp; Informasi</h1>
    <nav class="breadcrumb-custom justify-content-center d-flex gap-2 mt-2">
      <a href="index.php">Beranda</a> / <span class="active">Berita</span>
    </nav>
  </div>
</div>

<section>
  <div class="container">
    <div class="row g-4">
      <?php if ($total == 0): ?>
        <div class="col-12 text-center text-muted py-5">Belum ada berita yang dipublikasikan.</div>
      <?php endif; ?>
      <?php while ($b = mysqli_fetch_assoc($beritaList)):
        $fotoSrc = fotoUrl($b['foto']) ?: 'assets/img/logo.png';
      ?>
      <div class="col-md-6 col-lg-4">
        <div class="card-custom h-100 d-flex flex-column">
          <img src="<?= htmlspecialchars($fotoSrc) ?>" alt="<?= htmlspecialchars($b['judul']) ?>" style="height:200px;object-fit:cover;">
          <div class="p-3 d-flex flex-column flex-grow-1">
            <p class="small text-muted mb-1"><i class="fa-regular fa-calendar me-1"></i><?= htmlspecialchars(formatTanggalIndo($b['tanggal'])) ?></p>
            <h6 class="fw-bold"><?= htmlspecialchars($b['judul']) ?></h6>
            <p class="small text-muted mb-3"><?= htmlspecialchars(mb_strimwidth(strip_tags($b['isi']), 0, 110, '...')) ?></p>
            <a href="berita_detail.php?id=<?= $b['id'] ?>" class="small mt-auto">Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>

    <?php if ($totalHalaman > 1): ?>
    <nav class="mt-4">
      <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $totalHalaman; $i++): ?>
          <li class="page-item <?= $i == $halaman ? 'active' : '' ?>"><a class="page-link" href="?halaman=<?= $i ?>"><?= $i ?></a></li>
        <?php endfor; ?>
      </ul>
    </nav>
    <?php endif; ?>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
