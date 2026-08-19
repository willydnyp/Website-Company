<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $page_title ?? 'Dashboard' ?> - Admin</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap">
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="sidebar" id="sidebar">
  <div class="brand"><img src="<?= BASE_URL ?>assets/img/logo.png" alt="Logo" height="28" class="me-2">Admin Panel</div>
  <ul class="nav flex-column py-3">
    <li class="nav-item"><a class="nav-link <?= $active_menu=='dashboard'?'active':'' ?>" href="dashboard.php"><i class="fa-solid fa-gauge me-2"></i>Dashboard</a></li>
    <li class="nav-item"><a class="nav-link <?= $active_menu=='profil'?'active':'' ?>" href="settings.php?tab=profil"><i class="fa-solid fa-building-columns me-2"></i>Profil Universitas</a></li>
    <li class="nav-item"><a class="nav-link <?= $active_menu=='fakultas'?'active':'' ?>" href="data.php?modul=fakultas"><i class="fa-solid fa-landmark me-2"></i>Fakultas</a></li>
    <li class="nav-item"><a class="nav-link <?= $active_menu=='berita'?'active':'' ?>" href="data.php?modul=berita"><i class="fa-solid fa-newspaper me-2"></i>Berita</a></li>
    <li class="nav-item"><a class="nav-link <?= $active_menu=='galeri'?'active':'' ?>" href="data.php?modul=galeri"><i class="fa-solid fa-images me-2"></i>Galeri</a></li>
    <li class="nav-item"><a class="nav-link <?= $active_menu=='pesan'?'active':'' ?>" href="settings.php?tab=pesan"><i class="fa-solid fa-envelope me-2"></i>Pesan Masuk</a></li>
    <li class="nav-item"><a class="nav-link <?= $active_menu=='users'?'active':'' ?>" href="settings.php?tab=users"><i class="fa-solid fa-users-gear me-2"></i>Pengguna/Admin</a></li>
    <li class="nav-item"><a class="nav-link <?= $active_menu=='pengaturan'?'active':'' ?>" href="settings.php?tab=pengaturan"><i class="fa-solid fa-gear me-2"></i>Pengaturan Website</a></li>
    <li class="nav-item mt-3"><a class="nav-link text-info" href="<?= BASE_URL ?>index.php" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>Lihat Website</a></li>
    <li class="nav-item"><a class="nav-link text-warning" href="logout.php" onclick="return confirm('Yakin ingin logout?')"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a></li>
  </ul>
</div>

<div class="main-content">
  <div class="topbar d-flex justify-content-between align-items-center">
    <div>
      <button class="btn btn-outline-primary d-lg-none" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>
      <span class="fw-bold ms-2"><?= $page_title ?? 'Dashboard' ?></span>
    </div>
    <div class="d-flex align-items-center gap-2">
      <i class="fa-solid fa-circle-user fs-4 text-primary"></i>
      <span class="fw-semibold"><?= htmlspecialchars($_SESSION['admin_nama'] ?? 'Admin') ?></span>
    </div>
  </div>
