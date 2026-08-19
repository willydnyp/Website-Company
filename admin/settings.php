<?php
session_start();
require_once '../includes/functions.php';
requireLogin();

$tab = $_GET['tab'] ?? 'profil';
if (!in_array($tab, ['profil','pesan'])) $tab = 'profil';
$active_menu = $tab;
$judulTab = ['profil'=>'Profil Universitas','pesan'=>'Pesan Masuk'];
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

if ($tab == 'profil' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ubah_password'])) {
    $user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id=" . (int)$_SESSION['admin_id']));
    if (password_verify($_POST['password_lama'], $user['password'])) {
        if ($_POST['password_baru'] === $_POST['konfirmasi_password']) {
            $hash = password_hash($_POST['password_baru'], PASSWORD_DEFAULT);
            mysqli_query($koneksi, "UPDATE users SET password='$hash' WHERE id=" . (int)$_SESSION['admin_id']);
            header('Location: settings.php?tab=profil&success=Password+berhasil+diubah');
        } else {
            header('Location: settings.php?tab=profil&error=Konfirmasi+password+tidak+cocok');
        }
    } else {
        header('Location: settings.php?tab=profil&error=Password+lama+salah');
    }
    exit;
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

<?php endif; ?>

<?php include 'includes/footer.php'; ?>
