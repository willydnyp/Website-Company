<?php
session_start();
require_once 'includes/functions.php';
$profil = getProfil();
$page_title = 'Profil';
$active = 'profil';
$show_navbar = true;

$biodata = [
    'nama'       => 'Willy Permana Putra',
    'jurusan'    => 'Rekayasa Perangkat Lunak',
    'sekolah'    => 'SMK Negeri 1 Maja',
    'alamat'     => 'Jalan Boulayar, Blok Kertasari, Desa Sindangkerta, Kec.Maja Kab.Majalengka',
    'email'      => 'willyputra@gmail.com',
    'foto'       => 'assets/img/foto-anda.jpg',
    'deskripsi'  => 'Siswa jurusan Rekayasa Perangkat Lunak yang tertarik pada pengembangan website dan aplikasi. Website ini dibuat sebagai salah satu bentuk pembelajaran dan praktik dalam membangun sistem informasi berbasis web.',
];

include 'includes/header.php';
?>

<div class="page-banner text-center">
  <div class="container">
    <h1 class="fw-bold">Profil</h1>
    <nav class="breadcrumb-custom justify-content-center d-flex gap-2 mt-2">
      <a href="index.php">Beranda</a> / <span class="active">Profil</span>
    </nav>
  </div>
</div>

<section>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-9">
        <div class="row g-5 align-items-start">
          <div class="col-md-4 text-center">
            <img src="<?= htmlspecialchars($biodata['foto']) ?>" class="img-fluid rounded-4 shadow mb-3" alt="Foto Profil" style="width:100%;max-width:260px;aspect-ratio:1/1;object-fit:cover;">
            <h5 class="fw-bold mb-0"><?= htmlspecialchars($biodata['nama']) ?></h5>
            <p class="text-muted small"><?= htmlspecialchars($biodata['jurusan']) ?></p>
          </div>
          <div class="col-md-8">
            <h6 class="text-primary fw-bold text-uppercase">Biodata</h6>
            <h2 class="section-title mb-3">Data Diri</h2>

            <p style="text-align:justify;">"<?= nl2br(htmlspecialchars($biodata['deskripsi'])) ?>"</p>

            <div class="row g-3 mt-2">
              <div class="col-sm-6">
                <p class="small text-muted mb-1">Nama Lengkap</p>
                <p class="fw-bold mb-0"><?= htmlspecialchars($biodata['nama']) ?></p>
              </div>
              <div class="col-sm-6">
                <p class="small text-muted mb-1">Jurusan</p>
                <p class="fw-bold mb-0"><?= htmlspecialchars($biodata['jurusan']) ?></p>
              </div>
              <div class="col-sm-6">
                <p class="small text-muted mb-1">Sekolah</p>
                <p class="fw-bold mb-0"><?= htmlspecialchars($biodata['sekolah']) ?></p>
              </div>
              <div class="col-sm-6">
                <p class="small text-muted mb-1"><i class="fa-solid fa-envelope me-1"></i>Email</p>
                <p class="fw-bold mb-0"><?= htmlspecialchars($biodata['email']) ?></p>
              </div>
              <div class="col-12">
                <p class="small text-muted mb-1">Alamat</p>
                <p class="fw-bold mb-0"><?= htmlspecialchars($biodata['alamat']) ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>