<footer class="footer-section text-light pt-5 pb-3">
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-4 col-md-6">
        <h5 class="fw-bold mb-3"><img src="<?= BASE_URL ?>assets/img/logo.png" alt="Logo" height="28" class="me-2"><?= htmlspecialchars($profil['nama_universitas']) ?></h5>
        <p class="text-light-50 small"><?= htmlspecialchars(mb_strimwidth($profil['sejarah'], 0, 180, '...')) ?></p>
      </div>
      <div class="col-lg-2 col-md-6">
        <h6 class="fw-bold mb-3">Tautan</h6>
        <ul class="list-unstyled footer-links">
          <li><a href="<?= BASE_URL ?>tentang.php">Tentang Kami</a></li>
          <li><a href="<?= BASE_URL ?>fakultas.php">Fakultas</a></li>
          <li><a href="<?= BASE_URL ?>berita.php">Berita</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-6">
        <h6 class="fw-bold mb-3">Layanan</h6>
        <ul class="list-unstyled footer-links">
          <li><a href="<?= BASE_URL ?>galeri.php">Galeri Kampus</a></li>
          <li><a href="<?= BASE_URL ?>kontak.php">Hubungi Kami</a></li>
          <li><a href="<?= BASE_URL ?>login.php">Login Admin</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-6">
        <h6 class="fw-bold mb-3">Kontak</h6>
        <ul class="list-unstyled footer-links small">
          <li class="mb-2"><i class="fa-solid fa-location-dot me-2"></i><?= htmlspecialchars($profil['alamat']) ?></li>
          <li class="mb-2"><i class="fa-solid fa-phone me-2"></i><?= htmlspecialchars($profil['telepon']) ?></li>
          <li><i class="fa-solid fa-envelope me-2"></i><?= htmlspecialchars($profil['email']) ?></li>
        </ul>
      </div>
    </div>
    <hr class="border-light-50 mt-4">
    <p class="text-center small mb-0">&copy; <?= date('Y') ?> <?= htmlspecialchars($profil['nama_universitas']) ?>. Seluruh hak cipta dilindungi.</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= BASE_URL ?>assets/js/script.js"></script>
</body>
</html>
