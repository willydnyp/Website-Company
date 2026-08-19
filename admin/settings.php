<?php
session_start();
require_once '../includes/functions.php';
requireLogin();

$tab = $_GET['tab'] ?? 'profil';
if (!in_array($tab, ['profil','pesan','users'])) $tab = 'profil';
$active_menu = $tab;
$judulTab = ['profil'=>'Profil Universitas','pesan'=>'Pesan Masuk','users'=>'Pengguna/Admin'];
$page_title = $judulTab[$tab];

$profil = getProfil();

if ($tab == 'profil' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $keys = ['nama_universitas','sejarah','visi','misi','tujuan','nilai_nilai','nama_rektor','sambutan_rektor','foto_rektor','foto_sejarah','foto_struktur','alamat','telepon','email','maps_embed'];
    $baru = [];
    foreach ($keys as $k) $baru[$k] = trim($_POST[$k] ?? '');

    $isi = "<?php\n\$profil = " . var_export($baru, true) . ";\n";

    file_put_contents(__DIR__ . '/../includes/konfigurasi.php', $isi);
    header('Location: settings.php?tab=profil&success=Profil+berhasil+diperbarui');
    exit;
}

if ($tab == 'pesan') {
    if (isset($_GET['hapus'])) { mysqli_query($koneksi, "DELETE FROM kontak WHERE id=" . (int)$_GET['hapus']); header('Location: settings.php?tab=pesan&success=Pesan+dihapus'); exit; }
    if (isset($_GET['baca'])) { mysqli_query($koneksi, "UPDATE kontak SET status='dibaca' WHERE id=" . (int)$_GET['baca']); header('Location: settings.php?tab=pesan'); exit; }
    $cari = clean($koneksi, $_GET['cari'] ?? '');
    $halaman = max(1, (int)($_GET['halaman'] ?? 1));
    $perHalaman = 8;
    $offset = ($halaman - 1) * $perHalaman;
    $where = $cari ? "WHERE nama LIKE '%$cari%' OR subjek LIKE '%$cari%'" : '';
    $total = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM kontak $where"))['c'];
    $totalHalaman = ceil($total / $perHalaman);
    $dataPesan = mysqli_query($koneksi, "SELECT * FROM kontak $where ORDER BY created_at DESC LIMIT $perHalaman OFFSET $offset");
}

if ($tab == 'users') {
    if (isset($_GET['hapus'])) {
        $id = (int)$_GET['hapus'];
        if ($id != $_SESSION['admin_id']) { mysqli_query($koneksi, "DELETE FROM users WHERE id=$id"); header('Location: settings.php?tab=users&success=Data+dihapus'); }
        else header('Location: settings.php?tab=users&error=Tidak+bisa+hapus+akun+sendiri');
        exit;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ubah_password'])) {
        $user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id=" . (int)$_SESSION['admin_id']));
        if (password_verify($_POST['password_lama'], $user['password'])) {
            if ($_POST['password_baru'] === $_POST['konfirmasi_password']) {
                $hash = password_hash($_POST['password_baru'], PASSWORD_DEFAULT);
                mysqli_query($koneksi, "UPDATE users SET password='$hash' WHERE id=" . (int)$_SESSION['admin_id']);
                header('Location: settings.php?tab=users&success=Password+berhasil+diubah');
            } else {
                header('Location: settings.php?tab=users&error=Konfirmasi+password+tidak+cocok');
            }
        } else {
            header('Location: settings.php?tab=users&error=Password+lama+salah');
        }
        exit;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
        $username = clean($koneksi, $_POST['username']);
        $nama = clean($koneksi, $_POST['nama']);
        $role = clean($koneksi, $_POST['role']);
        $password = $_POST['password'] ?? '';
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $set = "username='$username', nama='$nama', role='$role'";
            if (!empty($password)) $set .= ", password='" . password_hash($password, PASSWORD_DEFAULT) . "'";
            mysqli_query($koneksi, "UPDATE users SET $set WHERE id=$id");
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            mysqli_query($koneksi, "INSERT INTO users (username, password, nama, role) VALUES ('$username','$hash','$nama','$role')");
        }
        header('Location: settings.php?tab=users&success=Data+berhasil+disimpan');
        exit;
    }
    $dataUsers = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id ASC");
}

include 'includes/layout.php';
?>

<?php if ($tab == 'profil'): ?>
<div class="card dash-card p-4">
  <form method="POST">
    <div class="row g-3">
      <div class="col-md-6"><label class="form-label">Nama Universitas</label><input type="text" name="nama_universitas" class="form-control" value="<?= htmlspecialchars($profil['nama_universitas']) ?>" required></div>
      <div class="col-md-6"><label class="form-label">Nama Rektor</label><input type="text" name="nama_rektor" class="form-control" value="<?= htmlspecialchars($profil['nama_rektor']) ?>" required></div>
      <div class="col-12"><label class="form-label">Sambutan Rektor</label><textarea name="sambutan_rektor" class="form-control" rows="3"><?= htmlspecialchars($profil['sambutan_rektor']) ?></textarea></div>
      <div class="col-md-4"><label class="form-label">Foto Rektor</label><input type="text" name="foto_rektor" class="form-control" value="<?= htmlspecialchars($profil['foto_rektor'] ?? '') ?>"></div>
      <div class="col-12"><label class="form-label">Sejarah</label><textarea name="sejarah" class="form-control" rows="3"><?= htmlspecialchars($profil['sejarah']) ?></textarea></div>
      <div class="col-md-4"><label class="form-label">Foto Sejarah</label><input type="text" name="foto_sejarah" class="form-control" value="<?= htmlspecialchars($profil['foto_sejarah'] ?? '') ?>"></div>
      <div class="col-md-4"><label class="form-label">Visi</label><textarea name="visi" class="form-control" rows="3"><?= htmlspecialchars($profil['visi']) ?></textarea></div>
      <div class="col-md-4"><label class="form-label">Misi</label><textarea name="misi" class="form-control" rows="3"><?= htmlspecialchars($profil['misi']) ?></textarea></div>
      <div class="col-md-4"><label class="form-label">Tujuan</label><textarea name="tujuan" class="form-control" rows="3"><?= htmlspecialchars($profil['tujuan']) ?></textarea></div>
      <div class="col-12"><label class="form-label">Nilai-Nilai Universitas</label><textarea name="nilai_nilai" class="form-control" rows="2"><?= htmlspecialchars($profil['nilai_nilai']) ?></textarea></div>
      <div class="col-md-4"><label class="form-label">Foto Struktur Organisasi</label><input type="text" name="foto_struktur" class="form-control" value="<?= htmlspecialchars($profil['foto_struktur'] ?? '') ?>"></div>
      <div class="col-12"><label class="form-label">Alamat</label><textarea name="alamat" class="form-control" rows="2"><?= htmlspecialchars($profil['alamat']) ?></textarea></div>
      <div class="col-md-4"><label class="form-label">Telepon</label><input type="text" name="telepon" class="form-control" value="<?= htmlspecialchars($profil['telepon']) ?>"></div>
      <div class="col-md-4"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="<?= htmlspecialchars($profil['email']) ?>"></div>
      <div class="col-12"><label class="form-label">Google Maps Embed</label><textarea name="maps_embed" class="form-control" rows="3"><?= htmlspecialchars($profil['maps_embed']) ?></textarea></div>
    </div>
    <button class="btn btn-primary mt-4 px-4"><i class="fa-solid fa-save me-1"></i> Simpan Perubahan</button>
  </form>
</div>

<?php elseif ($tab == 'pesan'): ?>
<div class="card dash-card p-4">
  <form class="d-flex mb-3" method="GET"><input type="hidden" name="tab" value="pesan">
    <input type="text" name="cari" class="form-control me-2" placeholder="Cari nama / subjek..." value="<?= htmlspecialchars($cari) ?>">
    <button class="btn btn-outline-primary"><i class="fa-solid fa-search"></i></button>
  </form>
  <div class="table-responsive">
    <table class="table align-middle">
      <thead><tr><th>#</th><th>Nama</th><th>Email / HP</th><th>Subjek</th><th>Pesan</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr></thead>
      <tbody>
      <?php $no=$offset+1; while ($k = mysqli_fetch_assoc($dataPesan)): ?>
        <tr>
          <td><?= $no++ ?></td><td><?= htmlspecialchars($k['nama']) ?></td>
          <td><?= htmlspecialchars($k['email']) ?><br><small class="text-muted"><?= htmlspecialchars($k['no_hp']) ?></small></td>
          <td><?= htmlspecialchars($k['subjek']) ?></td><td><?= htmlspecialchars(mb_strimwidth($k['pesan'],0,60,'...')) ?></td>
          <td><?= date('d/m/Y', strtotime($k['created_at'])) ?></td>
          <td><span class="badge <?= $k['status']=='dibaca'?'bg-success':'bg-secondary' ?>"><?= $k['status']=='dibaca'?'Dibaca':'Belum Dibaca' ?></span></td>
          <td>
            <?php if ($k['status'] != 'dibaca'): ?><a href="?tab=pesan&baca=<?= $k['id'] ?>" class="btn btn-sm btn-primary"><i class="fa-solid fa-envelope-open"></i></a><?php endif; ?>
            <button class="btn btn-sm btn-danger" onclick="confirmDelete('settings.php?tab=pesan&hapus=<?= $k['id'] ?>')"><i class="fa-solid fa-trash"></i></button>
          </td>
        </tr>
      <?php endwhile; ?>
      <?php if ($total==0): ?><tr><td colspan="8" class="text-center text-muted">Tidak ada pesan</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
  <?php if ($totalHalaman > 1): ?>
  <nav><ul class="pagination">
    <?php for ($i=1;$i<=$totalHalaman;$i++): ?><li class="page-item <?= $i==$halaman?'active':'' ?>"><a class="page-link" href="?tab=pesan&halaman=<?= $i ?>&cari=<?= urlencode($cari) ?>"><?= $i ?></a></li><?php endfor; ?>
  </ul></nav>
  <?php endif; ?>
</div>

<?php elseif ($tab == 'users'): ?>
<div class="card dash-card p-4">
  <div class="d-flex justify-content-end mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUser" onclick="tambahUserMode()"><i class="fa-solid fa-plus me-1"></i> Tambah Pengguna</button>
  </div>
  <div class="table-responsive">
    <table class="table align-middle">
      <thead><tr><th>#</th><th>Username</th><th>Nama</th><th>Role</th><th>Aksi</th></tr></thead>
      <tbody>
      <?php $no=1; while ($u = mysqli_fetch_assoc($dataUsers)): ?>
        <tr>
          <td><?= $no++ ?></td><td><?= htmlspecialchars($u['username']) ?></td><td><?= htmlspecialchars($u['nama']) ?></td>
          <td><span class="badge bg-primary"><?= htmlspecialchars($u['role']) ?></span></td>
          <td>
            <button class="btn btn-sm btn-warning" onclick='editUserMode(<?= json_encode($u) ?>)'><i class="fa-solid fa-pen"></i></button>
            <?php if ($u['id'] != $_SESSION['admin_id']): ?><button class="btn btn-sm btn-danger" onclick="confirmDelete('settings.php?tab=users&hapus=<?= $u['id'] ?>')"><i class="fa-solid fa-trash"></i></button><?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="card dash-card p-4 mt-4">
  <h6 class="fw-bold mb-3"><i class="fa-solid fa-lock me-1"></i> Ubah Password Saya</h6>
  <form method="POST">
    <input type="hidden" name="ubah_password" value="1">
    <div class="row g-3">
      <div class="col-md-4"><label class="form-label">Password Lama</label><input type="password" name="password_lama" class="form-control" required></div>
      <div class="col-md-4"><label class="form-label">Password Baru</label><input type="password" name="password_baru" class="form-control" required minlength="6"></div>
      <div class="col-md-4"><label class="form-label">Konfirmasi Password</label><input type="password" name="konfirmasi_password" class="form-control" required minlength="6"></div>
    </div>
    <button class="btn btn-primary mt-3"><i class="fa-solid fa-key me-1"></i> Ubah Password</button>
  </form>
</div>

<div class="modal fade" id="modalUser" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="POST">
      <div class="modal-header"><h5 class="modal-title" id="userModalTitle">Tambah Pengguna</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <input type="hidden" name="id" id="u_id">
        <div class="mb-3"><label class="form-label">Username</label><input type="text" name="username" id="u_username" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Nama Lengkap</label><input type="text" name="nama" id="u_nama" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Role</label><select name="role" id="u_role" class="form-select"><option value="admin">Admin</option><option value="superadmin">Super Admin</option></select></div>
        <div class="mb-3"><label class="form-label">Password <small id="u_pass_hint" class="text-muted">(kosongkan jika tidak diubah)</small></label><input type="password" name="password" id="u_password" class="form-control"></div>
      </div>
      <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary">Simpan</button></div>
    </form>
  </div>
</div>
<script>
function tambahUserMode(){
  document.getElementById('userModalTitle').innerText='Tambah Pengguna';
  document.getElementById('u_id').value=''; document.getElementById('u_username').value='';
  document.getElementById('u_nama').value=''; document.getElementById('u_password').value='';
  document.getElementById('u_password').required = true;
  document.getElementById('u_pass_hint').style.display='none';
}
function editUserMode(data){
  document.getElementById('userModalTitle').innerText='Edit Pengguna';
  document.getElementById('u_id').value=data.id; document.getElementById('u_username').value=data.username;
  document.getElementById('u_nama').value=data.nama; document.getElementById('u_role').value=data.role;
  document.getElementById('u_password').value=''; document.getElementById('u_password').required = false;
  document.getElementById('u_pass_hint').style.display='inline';
  new bootstrap.Modal(document.getElementById('modalUser')).show();
}
</script>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>
