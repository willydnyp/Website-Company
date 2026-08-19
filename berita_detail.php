<?php
session_start();
require_once 'includes/functions.php';
$profil = getProfil();
$active = 'berita';
$show_navbar = true;

$id = (int)($_GET['id'] ?? 0);
$berita = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM berita WHERE id=$id"));

if (!$berita) {
    header('Location: berita.php');
    exit;
}

$page_title = $berita['judul'];

$beritaLain = mysqli_query($koneksi, "SELECT * FROM berita WHERE id != $id ORDER BY tanggal DESC, id DESC LIMIT 3");

include 'includes/header.php';
?>

<div class="page-banner text-center">
  <div class="container">
    <h1 class="fw-bold"><?= htmlspecialchars($berita['judul']) ?></h1>
    <nav class="breadcrumb-custom justify-content-center d-flex gap-2 mt-2">
      <a href="index.php">Beranda</a> / <a href="berita.php">Berita</a> / <span class="active">Detail</span>
    </nav>
  </div>
</div>

<section>
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <?php $fotoSrc = fotoUrl($berita['foto']); ?>
        <?php if ($fotoSrc): ?>
          <img src="<?= htmlspecialchars($fotoSrc) ?>" alt="<?= htmlspecialchars($berita['judul']) ?>" class="w-100 rounded-4 mb-4" style="max-height:420px;object-fit:cover;">
        <?php endif; ?>
        <p class="small text-muted mb-2">
          <i class="fa-regular fa-calendar me-1"></i><?= htmlspecialchars(formatTanggalIndo($berita['tanggal'])) ?>
          <?php if (!empty($berita['penulis'])): ?>
            &nbsp;&bull;&nbsp;<i class="fa-regular fa-user me-1"></i><?= htmlspecialchars($berita['penulis']) ?>
          <?php endif; ?>
        </p>
        <h2 class="section-title mb-3"><?= htmlspecialchars($berita['judul']) ?></h2>
        <?php
          // Berita lama tersimpan sebagai teks polos, berita baru (dari editor) tersimpan sebagai HTML.
          $isiBerita = strip_tags($berita['isi']) === $berita['isi']
            ? nl2br(htmlspecialchars($berita['isi']))
            : $berita['isi'];
        ?>
        <div class="fs-6 berita-content" style="line-height:1.9;"><?= $isiBerita ?></div>
        <a href="berita.php" class="btn btn-outline-primary rounded-pill px-4 mt-4"><i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Berita</a>
      </div>

      <div class="col-lg-4">
        <h6 class="fw-bold mb-3">Berita Lainnya</h6>
        <?php while ($bl = mysqli_fetch_assoc($beritaLain)): $fotoLain = fotoUrl($bl['foto']) ?: 'assets/img/logo.png'; ?>
          <a href="berita_detail.php?id=<?= $bl['id'] ?>" class="d-flex gap-3 mb-3 text-decoration-none text-dark">
            <img src="<?= htmlspecialchars($fotoLain) ?>" style="width:80px;height:60px;object-fit:cover;border-radius:8px;flex-shrink:0;">
            <div>
              <p class="small fw-semibold mb-1"><?= htmlspecialchars(mb_strimwidth($bl['judul'], 0, 60, '...')) ?></p>
              <p class="small text-muted mb-0"><?= htmlspecialchars(formatTanggalIndo($bl['tanggal'])) ?></p>
            </div>
          </a>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
