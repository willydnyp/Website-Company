<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($page_title) ? $page_title . ' - ' : '' ?><?= htmlspecialchars($profil['nama_universitas'] ?? 'Universitas YPIB') ?></title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap">
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>

<?php if (!empty($show_navbar)): ?>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top main-navbar">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>index.php">
      <img src="<?= BASE_URL ?>assets/img/logo.png" alt="Logo" height="30" class="me-2"><?= htmlspecialchars($profil['nama_universitas'] ?? 'Website Company') ?>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item"><a class="nav-link <?= $active=='beranda'?'active':'' ?>" href="<?= BASE_URL ?>index.php">Beranda</a></li>
        <li class="nav-item"><a class="nav-link <?= $active=='tentang'?'active':'' ?>" href="<?= BASE_URL ?>tentang.php">Tentang Kami</a></li>
        <li class="nav-item"><a class="nav-link <?= $active=='fakultas'?'active':'' ?>" href="<?= BASE_URL ?>fakultas.php">Fakultas</a></li>
        <li class="nav-item"><a class="nav-link <?= $active=='berita'?'active':'' ?>" href="<?= BASE_URL ?>berita.php">Berita</a></li>
        <li class="nav-item"><a class="nav-link <?= $active=='galeri'?'active':'' ?>" href="<?= BASE_URL ?>galeri.php">Galeri</a></li>
        <li class="nav-item"><a class="nav-link <?= $active=='kontak'?'active':'' ?>" href="<?= BASE_URL ?>kontak.php">Hubungi Kami</a></li>
        <li class="nav-item"><a class="nav-link <?= $active=='profil'?'active':'' ?>" href="<?= BASE_URL ?>profil.php">Profil</a></li>
        <li class="nav-item ms-lg-1">
          <a class="btn btn-light btn-sm px-3 fw-semibold" href="<?= BASE_URL ?><?= isLoggedIn() ? 'admin/dashboard.php' : 'login.php' ?>">
            <i class="fa-solid fa-right-to-bracket me-1"></i><?= isLoggedIn() ? 'Dashboard' : 'Login' ?>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php endif; ?>