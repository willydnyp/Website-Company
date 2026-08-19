<?php
session_start();
require_once 'includes/functions.php';
$profil = getProfil();
$page_title = 'Pengumuman';
$active = 'pengumuman';
$show_navbar = true;

$halaman = max(1, (int)($_GET['halaman'] ?? 1));
$perHalaman = 8;
$offset = ($halaman - 1) * $perHalaman;

$total = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM pengumuman"))['c'];
$totalHalaman = ceil($total / $perHalaman);

$pengumumanList = mysqli_query($koneksi, "SELECT * FROM pengumuman ORDER BY tanggal DESC, id DESC LIMIT $perHalaman OFFSET $offset");

include 'includes/header.php';
?>

<div class="page-banner text-center">
  <div class="container">
    <h1 class="fw-bold">Pengumuman</h1>
    <nav class="breadcrumb-custom justify-content-center d-flex gap-2 mt-2">
      <a href="index.php">Beranda</a> / <span class="active">Pengumuman</span>
    </nav>
  </div>
</div>

<section>
  <div class="container">
    <?php if ($total == 0): ?>
      <div class="text-center text-muted py-5">Belum ada pengumuman yang dipublikasikan.</div>
    <?php endif; ?>
    <div class="row g-3">
      <?php while ($p = mysqli_fetch_assoc($pengumumanList)): ?>
      <div class="col-12">
        <div class="pengumuman-card p-4 d-flex flex-column flex-md-row gap-3 align-items-md-center">
          <div class="icon-box bg-primary flex-shrink-0"><i class="fa-solid fa-bullhorn"></i></div>
          <div class="flex-grow-1">
            <span class="badge bg-warning text-dark mb-2"><?= htmlspecialchars($p['kategori']) ?></span>
            <h5 class="fw-bold mb-2"><?= htmlspecialchars($p['judul']) ?></h5>
            <p class="text-muted mb-2"><?= htmlspecialchars(strip_tags($p['isi'])) ?></p>
            <p class="small text-muted mb-0"><i class="fa-regular fa-calendar me-1"></i><?= htmlspecialchars(formatTanggalIndo($p['tanggal'])) ?></p>
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
