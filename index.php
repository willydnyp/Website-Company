<?php
session_start();
require_once 'includes/functions.php';
catatPengunjung($koneksi);

$profil = getProfil();
$page_title = 'Beranda';
$active = 'beranda';
$show_navbar = true;

$totalMhs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM mahasiswa"))['c'];
$totalDosen = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM dosen"))['c'];
$totalFakultas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM fakultas"))['c'];

$fakultasList = mysqli_query($koneksi, "SELECT * FROM fakultas LIMIT 4");
$totalFakultasRow = mysqli_num_rows($fakultasList);
$galeriList = mysqli_query($koneksi, "SELECT * FROM galeri ORDER BY id DESC LIMIT 6");
$beritaList = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY tanggal DESC, id DESC LIMIT 3");

include 'includes/header.php';
?>

<section class="hero-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <h1>Membangun Generasi Unggul Menuju Masa Depan Gemilang</h1>
        <p class="fs-5 mb-4"><?= htmlspecialchars(mb_strimwidth($profil['visi'], 0, 160, '...')) ?></p>
        <div class="d-flex gap-3 flex-wrap">
          <a href="kontak.php" class="btn btn-accent px-4 py-2 rounded-pill">Hubungi Kami</a>
          <a href="tentang.php" class="btn btn-outline-light-custom px-4 py-2 rounded-pill">Tentang Kami</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-4 text-center">
        <img src="<?= htmlspecialchars($profil['foto_rektor']) ?>" class="rektor-photo" alt="Rektor">
      </div>
      <div class="col-lg-8">
        <h6 class="text-uppercase fw-bold text-warning">Sambutan Rektor</h6>
        <h2 class="section-title mb-3">Selamat Datang</h2>
        <p class="fst-italic">"<?= nl2br(htmlspecialchars($profil['sambutan_rektor'])) ?>"</p>
        <p class="fw-bold mb-0"><?= htmlspecialchars($profil['nama_rektor']) ?></p>
        <p class="text-muted small">Rektor <?= htmlspecialchars($profil['nama_universitas']) ?></p>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="container text-center mb-5">
    <h6 class="text-primary fw-bold text-uppercase">Fakultas</h6>
    <h2 class="section-title">Fakultas Unggulan Kami</h2>
  </div>
  <div class="container">
    <div class="row g-4 <?= $totalFakultasRow < 4 ? 'justify-content-center' : '' ?>">
      <?php
      $iF = 0;
      while ($f = mysqli_fetch_assoc($fakultasList)):
        $fotoSrc = fotoUrl($f['foto']);
        $iF++;
      ?>
      <div class="col-md-6 col-lg-3">
        <div class="card-custom">
          <img src="<?= htmlspecialchars($fotoSrc) ?>" alt="<?= htmlspecialchars($f['nama_fakultas']) ?>">
          <div class="p-3">
            <h6 class="fw-bold"><?= htmlspecialchars($f['nama_fakultas']) ?></h6>
            <p class="small text-muted mb-1"><i class="fa-solid fa-user-tie me-1"></i>Dekan: <?= htmlspecialchars($f['nama_dekan']) ?></p>
            <a href="fakultas.php" class="small">Selengkapnya <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<section>
  <div class="container text-center mb-5">
    <h6 class="text-primary fw-bold text-uppercase">Informasi</h6>
    <h2 class="section-title">Berita Terbaru</h2>
  </div>
  <div class="container">
    <div class="row g-4">
      <?php if (mysqli_num_rows($beritaList) === 0): ?>
        <div class="col-12 text-center text-muted">Belum ada berita yang dipublikasikan.</div>
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
            <p class="small text-muted mb-3"><?= htmlspecialchars(mb_strimwidth(strip_tags($b['isi']), 0, 100, '...')) ?></p>
            <a href="berita_detail.php?id=<?= $b['id'] ?>" class="small mt-auto">Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
    <div class="text-center mt-4"><a href="berita.php" class="btn btn-primary rounded-pill px-4">Lihat Semua Berita</a></div>
  </div>
</section>

<section class="bg-light-blue">
  <div class="container text-center mb-5">
    <h6 class="text-primary fw-bold text-uppercase">Dokumentasi</h6>
    <h2 class="section-title">Galeri Kampus</h2>
  </div>
  <div class="container">
    <div class="row g-3">
      <?php
      $iG = 0;
      while ($g = mysqli_fetch_assoc($galeriList)):
        $fotoSrc = fotoUrl($g['foto']);
        $iG++;
      ?>
      <div class="col-6 col-md-4">
        <div class="gallery-item">
          <img src="<?= htmlspecialchars($fotoSrc) ?>" alt="<?= htmlspecialchars($g['judul']) ?>">
          <div class="gallery-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
    <div class="text-center mt-4"><a href="galeri.php" class="btn btn-primary rounded-pill px-4">Lihat Semua Galeri</a></div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>