<?php
session_start();
require_once 'includes/functions.php';
$profil = getProfil();

if (isLoggedIn()) { header('Location: admin/dashboard.php'); exit; }

$error = '';
$lockRemaining = 0;

// Cek apakah sedang dalam masa jeda (lockout) akibat 3x salah login
if (!empty($_SESSION['login_locked_until']) && time() < $_SESSION['login_locked_until']) {
    $lockRemaining = $_SESSION['login_locked_until'] - time();
    $error = "Terlalu banyak percobaan gagal. Coba lagi dalam $lockRemaining detik.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $lockRemaining <= 0) {
    $username = clean($koneksi, $_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' LIMIT 1"));

    if ($user && password_verify($password, $user['password'])) {
        // Login berhasil, reset hitungan percobaan gagal
        unset($_SESSION['login_attempts'], $_SESSION['login_locked_until']);
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_nama'] = $user['nama'];
        $_SESSION['admin_role'] = $user['role'];
        header('Location: admin/dashboard.php');
        exit;
    }

    // Login gagal: tambah hitungan percobaan
    $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;

    if ($_SESSION['login_attempts'] >= 3) {
        // Sudah 3x salah, kunci selama 30 detik dan reset hitungan
        $_SESSION['login_locked_until'] = time() + 30;
        $_SESSION['login_attempts'] = 0;
        $lockRemaining = 30;
        $error = 'Terlalu banyak percobaan gagal. Coba lagi dalam 30 detik.';
    } else {
        $sisaPercobaan = 3 - $_SESSION['login_attempts'];
        $error = "Username atau password salah! Sisa percobaan: $sisaPercobaan kali.";
    }
}

$page_title = 'Login Admin';
$show_navbar = false;
include 'includes/header.php';
?>

<div class="login-wrapper">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-4 col-md-6">
        <div class="card login-card">
          <div class="card-body p-4">
            <div class="text-center mb-4">
              <img src="<?= BASE_URL ?>assets/img/logo.png" alt="Logo" height="60">
              <h4 class="fw-bold mt-2"><?= htmlspecialchars($profil['nama_universitas']) ?></h4>
              <p class="text-muted small">Login untuk mengakses Dashboard Admin</p>
            </div>
            <?php if ($error): ?><div class="alert alert-danger py-2 small" id="loginError"><?= htmlspecialchars($error) ?></div><?php endif; ?>
            <form method="POST" id="loginForm">
              <div class="mb-3"><label class="form-label">Username</label><input type="text" name="username" class="form-control" required autofocus <?= $lockRemaining > 0 ? 'disabled' : '' ?>></div>
              <div class="mb-4"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required <?= $lockRemaining > 0 ? 'disabled' : '' ?>></div>
              <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold" id="btnLogin" <?= $lockRemaining > 0 ? 'disabled' : '' ?>>
                <i class="fa-solid fa-right-to-bracket me-1"></i> <span id="btnLoginText">Login</span>
              </button>
            </form>
            <div class="text-center mt-4"><a href="index.php" class="small text-muted"><i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Beranda</a></div>
            <p class="text-center small text-muted mt-3 mb-0">Default: admin / admin123</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php if ($lockRemaining > 0): ?>
<script>
// Hitung mundur jeda login 30 detik, lalu aktifkan lagi form-nya otomatis
let sisaDetik = <?= (int)$lockRemaining ?>;
const btnLogin = document.getElementById('btnLogin');
const btnLoginText = document.getElementById('btnLoginText');
const loginError = document.getElementById('loginError');
const inputs = document.querySelectorAll('#loginForm input');

const timer = setInterval(() => {
  sisaDetik--;
  if (loginError) loginError.textContent = 'Terlalu banyak percobaan gagal. Coba lagi dalam ' + sisaDetik + ' detik.';
  if (btnLoginText) btnLoginText.textContent = 'Tunggu ' + sisaDetik + ' detik...';

  if (sisaDetik <= 0) {
    clearInterval(timer);
    if (loginError) loginError.remove();
    if (btnLoginText) btnLoginText.textContent = 'Login';
    btnLogin.disabled = false;
    inputs.forEach(el => el.disabled = false);
  }
}, 1000);
</script>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= BASE_URL ?>assets/js/script.js"></script>
</body>
</html>