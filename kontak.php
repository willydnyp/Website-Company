<?php
session_start();
require_once 'includes/functions.php';
$profil = getProfil();
$page_title = 'Hubungi Kami';
$active = 'kontak';
$show_navbar = true;

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = clean($koneksi, $_POST['nama'] ?? '');
    $email = clean($koneksi, $_POST['email'] ?? '');
    $no_hp = clean($koneksi, $_POST['no_hp'] ?? '');
    $subjek = clean($koneksi, $_POST['subjek'] ?? '');
    $pesan = clean($koneksi, $_POST['pesan'] ?? '');

    if (!$nama) $errors[] = 'Nama lengkap wajib diisi.';
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email tidak valid.';
    if (!$no_hp) $errors[] = 'Nomor HP wajib diisi.';
    if (!$subjek) $errors[] = 'Subjek wajib diisi.';
    if (!$pesan) $errors[] = 'Pesan wajib diisi.';

    if (empty($errors)) {
        mysqli_query($koneksi, "INSERT INTO kontak (nama, email, no_hp, subjek, pesan) VALUES ('$nama','$email','$no_hp','$subjek','$pesan')");
        $success = true;
    }
}

include 'includes/header.php';
?>

<div class="page-banner text-center">
  <div class="container">
    <h1 class="fw-bold">Hubungi Kami</h1>
    <nav class="breadcrumb-custom justify-content-center d-flex gap-2 mt-2">
      <a href="index.php">Beranda</a> / <span class="active">Hubungi Kami</span>
    </nav>
  </div>
</div>

<section>
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-5">
        <h2 class="section-title mb-4">Informasi Kontak</h2>
        <div class="mb-3"><i class="fa-solid fa-location-dot text-primary me-2"></i><?= htmlspecialchars($profil['alamat']) ?></div>
        <div class="mb-3"><i class="fa-solid fa-phone text-primary me-2"></i><?= htmlspecialchars($profil['telepon']) ?></div>
        <div class="mb-4"><i class="fa-solid fa-envelope text-primary me-2"></i><?= htmlspecialchars($profil['email']) ?></div>
        <div class="mt-4 rounded-4 overflow-hidden shadow">
          <?= $profil['maps_embed'] ?>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="card-custom p-4">
          <?php if ($success): ?>
            <div class="alert alert-success">Pesan Anda berhasil terkirim. Terima kasih telah menghubungi kami!</div>
          <?php endif; ?>
          <?php if (!empty($errors)): ?>
            <div class="alert alert-danger"><ul class="mb-0"><?php foreach ($errors as $e) echo "<li>" . htmlspecialchars($e) . "</li>"; ?></ul></div>
          <?php endif; ?>
          <form method="POST" novalidate>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Nomor HP</label>
                <input type="text" name="no_hp" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Subjek</label>
                <input type="text" name="subjek" class="form-control" required>
              </div>
              <div class="col-12">
                <label class="form-label">Pesan</label>
                <textarea name="pesan" rows="5" class="form-control" required></textarea>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-primary rounded-pill px-4"><i class="fa-solid fa-paper-plane me-1"></i> Kirim Pesan</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
