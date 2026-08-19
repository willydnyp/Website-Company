<?php
session_start();
require_once '../includes/functions.php';
requireLogin();

$modul = $_GET['modul'] ?? 'fakultas';
if (!in_array($modul, ['fakultas','galeri','berita'])) $modul = 'fakultas';
$active_menu = $modul;
$judulModul = ['fakultas'=>'Fakultas','galeri'=>'Galeri','berita'=>'Berita'];
$page_title = $judulModul[$modul];

// hapus data
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $tabel = $modul;
    mysqli_query($koneksi, "DELETE FROM $tabel WHERE id=$id");
    header("Location: data.php?modul=$modul&success=Data+berhasil+dihapus");
    exit;
}

// simpan data baru / update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $foto = clean($koneksi, trim($_POST['foto'] ?? ''));

    if ($modul == 'fakultas') {
        $nama_fakultas = clean($koneksi, $_POST['nama_fakultas']);
        $nama_dekan = clean($koneksi, $_POST['nama_dekan']);
        $deskripsi = clean($koneksi, $_POST['deskripsi']);
        if ($id > 0) {
            $set = "nama_fakultas='$nama_fakultas', nama_dekan='$nama_dekan', deskripsi='$deskripsi'" . ($foto !== '' ? ", foto='$foto'" : '');
            mysqli_query($koneksi, "UPDATE fakultas SET $set WHERE id=$id");
        } else {
            mysqli_query($koneksi, "INSERT INTO fakultas (nama_fakultas, foto, nama_dekan, deskripsi) VALUES ('$nama_fakultas','$foto','$nama_dekan','$deskripsi')");
        }
    } elseif ($modul == 'galeri') {
        $judul = clean($koneksi, $_POST['judul']);
        $kategori = clean($koneksi, $_POST['kategori']);
        if ($id > 0) {
            $set = "judul='$judul', kategori='$kategori'" . ($foto !== '' ? ", foto='$foto'" : '');
            mysqli_query($koneksi, "UPDATE galeri SET $set WHERE id=$id");
        } else {
            mysqli_query($koneksi, "INSERT INTO galeri (judul, foto, kategori) VALUES ('$judul','$foto','$kategori')");
        }
    } elseif ($modul == 'berita') {
        $judul = clean($koneksi, $_POST['judul']);
        $isi = cleanRichText($koneksi, $_POST['isi'] ?? '');
        $penulis = clean($koneksi, $_POST['penulis']);
        $tanggal = clean($koneksi, $_POST['tanggal']);
        if ($tanggal === '') $tanggal = date('Y-m-d');
        if ($id > 0) {
            $set = "judul='$judul', isi='$isi', penulis='$penulis', tanggal='$tanggal'" . ($foto !== '' ? ", foto='$foto'" : '');
            mysqli_query($koneksi, "UPDATE berita SET $set WHERE id=$id");
        } else {
            mysqli_query($koneksi, "INSERT INTO berita (judul, isi, foto, penulis, tanggal) VALUES ('$judul','$isi','$foto','$penulis','$tanggal')");
        }
    }
    header("Location: data.php?modul=$modul&success=Data+berhasil+disimpan");
    exit;
}

$cari = clean($koneksi, $_GET['cari'] ?? '');
$halaman = max(1, (int)($_GET['halaman'] ?? 1));
$perHalaman = 8;
$offset = ($halaman - 1) * $perHalaman;

switch ($modul) {
    case 'fakultas':
        $where = $cari ? "WHERE nama_fakultas LIKE '%$cari%' OR nama_dekan LIKE '%$cari%'" : '';
        $total = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM fakultas $where"))['c'];
        $data = mysqli_query($koneksi, "SELECT * FROM fakultas $where ORDER BY id DESC LIMIT $perHalaman OFFSET $offset");
        break;
    case 'galeri':
        $where = $cari ? "WHERE judul LIKE '%$cari%'" : '';
        $total = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM galeri $where"))['c'];
        $data = mysqli_query($koneksi, "SELECT * FROM galeri $where ORDER BY id DESC LIMIT $perHalaman OFFSET $offset");
        break;
    case 'berita':
        $where = $cari ? "WHERE judul LIKE '%$cari%' OR penulis LIKE '%$cari%'" : '';
        $total = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM berita $where"))['c'];
        $data = mysqli_query($koneksi, "SELECT * FROM berita $where ORDER BY tanggal DESC, id DESC LIMIT $perHalaman OFFSET $offset");
        break;
}
$totalHalaman = ceil($total / $perHalaman);

include 'includes/layout.php';
?>

<?php if ($modul == 'berita'): ?>
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<style>
.editor-wrap .ql-toolbar.ql-snow{border-radius:.5rem .5rem 0 0;border-color:#ced4da;background:#f8f9fa;}
.editor-wrap .ql-container.ql-snow{border-radius:0 0 .5rem .5rem;border-color:#ced4da;font-family:inherit;}
.editor-wrap .ql-editor{min-height:180px;font-size:1rem;}
</style>
<?php endif; ?>

<div class="card dash-card p-4">
  <div class="d-flex justify-content-between flex-wrap gap-2 mb-3">
    <form class="d-flex" method="GET">
      <input type="hidden" name="modul" value="<?= $modul ?>">
      <input type="text" name="cari" class="form-control me-2" placeholder="Cari data..." value="<?= htmlspecialchars($cari) ?>">
      <button class="btn btn-outline-primary"><i class="fa-solid fa-search"></i></button>
    </form>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm" onclick="tambahMode()"><i class="fa-solid fa-plus me-1"></i> Tambah Data</button>
  </div>

  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
        <?php if ($modul=='fakultas'): ?><th>#</th><th>Foto</th><th>Nama Fakultas</th><th>Dekan</th><th>Deskripsi</th><th>Aksi</th>
        <?php elseif ($modul=='galeri'): ?><th>#</th><th>Foto</th><th>Judul</th><th>Kategori</th><th>Aksi</th>
        <?php elseif ($modul=='berita'): ?><th>#</th><th>Foto</th><th>Judul</th><th>Penulis</th><th>Tanggal</th><th>Aksi</th>
        <?php endif; ?>
        </tr>
      </thead>
      <tbody>
      <?php $no = $offset + 1; while ($row = mysqli_fetch_assoc($data)): ?>
        <tr>
        <?php if ($modul=='fakultas'):
          $thumbAsli = fotoUrl($row['foto'], '../');
        ?>
          <td><?= $no++ ?></td>
          <td class="position-relative" style="width:70px;">
            <?php if ($thumbAsli): ?>
              <img src="<?= htmlspecialchars($thumbAsli) ?>" class="thumb-foto">
            <?php else: ?>
              <div class="thumb-foto d-flex align-items-center justify-content-center bg-light text-muted"><i class="fa-solid fa-image"></i></div>
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars($row['nama_fakultas']) ?></td><td><?= htmlspecialchars($row['nama_dekan']) ?></td>
          <td><?= htmlspecialchars(mb_strimwidth($row['deskripsi'],0,50,'...')) ?></td>
          <td><button class="btn btn-sm btn-warning" onclick='editMode(<?= json_encode($row) ?>)'><i class="fa-solid fa-pen"></i></button>
              <button class="btn btn-sm btn-danger" onclick="confirmDelete('data.php?modul=fakultas&hapus=<?= $row['id'] ?>')"><i class="fa-solid fa-trash"></i></button></td>
        <?php elseif ($modul=='galeri'):
          $thumbAsli = fotoUrl($row['foto'], '../');
        ?>
          <td><?= $no++ ?></td>
          <td class="position-relative" style="width:70px;">
            <?php if ($thumbAsli): ?>
              <img src="<?= htmlspecialchars($thumbAsli) ?>" class="thumb-foto">
            <?php else: ?>
              <div class="thumb-foto d-flex align-items-center justify-content-center bg-light text-muted"><i class="fa-solid fa-image"></i></div>
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars($row['judul']) ?></td><td><?= htmlspecialchars($row['kategori']) ?></td>
          <td><button class="btn btn-sm btn-warning" onclick='editMode(<?= json_encode($row) ?>)'><i class="fa-solid fa-pen"></i></button>
              <button class="btn btn-sm btn-danger" onclick="confirmDelete('data.php?modul=galeri&hapus=<?= $row['id'] ?>')"><i class="fa-solid fa-trash"></i></button></td>
        <?php elseif ($modul=='berita'):
          $thumbAsli = fotoUrl($row['foto'], '../');
        ?>
          <td><?= $no++ ?></td>
          <td class="position-relative" style="width:70px;">
            <?php if ($thumbAsli): ?>
              <img src="<?= htmlspecialchars($thumbAsli) ?>" class="thumb-foto">
            <?php else: ?>
              <div class="thumb-foto d-flex align-items-center justify-content-center bg-light text-muted"><i class="fa-solid fa-image"></i></div>
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars(mb_strimwidth($row['judul'],0,50,'...')) ?></td>
          <td><?= htmlspecialchars($row['penulis']) ?></td>
          <td><?= htmlspecialchars(formatTanggalIndo($row['tanggal'])) ?></td>
          <td><button class="btn btn-sm btn-warning" onclick='editMode(<?= json_encode($row) ?>)'><i class="fa-solid fa-pen"></i></button>
              <button class="btn btn-sm btn-danger" onclick="confirmDelete('data.php?modul=berita&hapus=<?= $row['id'] ?>')"><i class="fa-solid fa-trash"></i></button></td>
        <?php endif; ?>
        </tr>
      <?php endwhile; ?>
      <?php if ($total==0): ?><tr><td colspan="7" class="text-center text-muted">Tidak ada data</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php if ($totalHalaman > 1): ?>
  <nav><ul class="pagination">
    <?php for ($i=1;$i<=$totalHalaman;$i++): ?>
      <li class="page-item <?= $i==$halaman?'active':'' ?>"><a class="page-link" href="?modul=<?= $modul ?>&halaman=<?= $i ?>&cari=<?= urlencode($cari) ?>"><?= $i ?></a></li>
    <?php endfor; ?>
  </ul></nav>
  <?php endif; ?>
</div>

<div class="modal fade" id="modalForm" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content modal-anim" method="POST">
      <div class="modal-header"><h5 class="modal-title" id="modalTitle">Tambah Data</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <input type="hidden" name="id" id="f_id">

        <?php if ($modul=='fakultas'): ?>
          <div class="mb-3"><label class="form-label">Nama Fakultas</label><input type="text" name="nama_fakultas" id="f_nama_fakultas" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Nama Dekan</label><input type="text" name="nama_dekan" id="f_nama_dekan" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Deskripsi</label><textarea name="deskripsi" id="f_deskripsi" class="form-control" rows="3" required></textarea></div>
          <div class="mb-3">
            <label class="form-label">Foto</label>
            <input type="text" name="foto" id="f_foto" class="form-control">
            <div id="f_foto_preview_wrap" class="foto-preview-wrap">
              <img id="f_foto_preview" src="" class="foto-preview">
            </div>
          </div>

        <?php elseif ($modul=='galeri'): ?>
          <div class="mb-3"><label class="form-label">Judul</label><input type="text" name="judul" id="f_judul" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Kategori</label><input type="text" name="kategori" id="f_kategori" class="form-control" required></div>
          <div class="mb-3">
            <label class="form-label">Foto</label>
            <input type="text" name="foto" id="f_foto" class="form-control">
            <div id="f_foto_preview_wrap" class="foto-preview-wrap">
              <img id="f_foto_preview" src="" class="foto-preview">
            </div>
          </div>

        <?php elseif ($modul=='berita'): ?>
          <div class="mb-3"><label class="form-label">Judul</label><input type="text" name="judul" id="f_judul" class="form-control" required></div>
          <div class="mb-3">
            <label class="form-label">Isi Berita</label>
            <div class="editor-wrap">
              <div id="f_isi_toolbar">
                <span class="ql-formats">
                  <select class="ql-header">
                    <option value="2">Judul Besar</option>
                    <option value="3">Judul Kecil</option>
                    <option selected>Normal</option>
                  </select>
                </span>
                <span class="ql-formats">
                  <button type="button" class="ql-bold" title="Bold"></button>
                  <button type="button" class="ql-italic" title="Italic"></button>
                  <button type="button" class="ql-underline" title="Underline"></button>
                  <button type="button" class="ql-strike" title="Strikethrough"></button>
                </span>
                <span class="ql-formats">
                  <select class="ql-color"></select>
                </span>
                <span class="ql-formats">
                  <button type="button" class="ql-list" value="ordered" title="Numbered list"></button>
                  <button type="button" class="ql-list" value="bullet" title="Bullet list"></button>
                  <button type="button" class="ql-indent" value="-1"></button>
                  <button type="button" class="ql-indent" value="+1"></button>
                </span>
                <span class="ql-formats">
                  <button type="button" class="ql-blockquote" title="Kutipan"></button>
                  <button type="button" class="ql-link" title="Tautan"></button>
                </span>
                <span class="ql-formats">
                  <button type="button" class="ql-clean" title="Hapus format"></button>
                </span>
              </div>
              <div id="f_isi_editor"></div>
            </div>
            <textarea name="isi" id="f_isi" class="d-none"></textarea>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">Penulis</label><input type="text" name="penulis" id="f_penulis" class="form-control"></div>
            <div class="col-md-6 mb-3"><label class="form-label">Tanggal</label><input type="date" name="tanggal" id="f_tanggal" class="form-control"></div>
          </div>
          <div class="mb-3">
            <label class="form-label">Foto</label>
            <input type="text" name="foto" id="f_foto" class="form-control">
            <div id="f_foto_preview_wrap" class="foto-preview-wrap">
              <img id="f_foto_preview" src="" class="foto-preview">
            </div>
          </div>

        <?php endif; ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-primary" id="btnSimpan"><span id="btnSimpanText">Simpan</span></button>
      </div>
    </form>
  </div>
</div>

<?php if ($modul == 'berita'): ?>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<?php endif; ?>
<?php include 'includes/footer.php'; ?>
<script>
const MODUL = '<?= $modul ?>';

let quill = null;
if (MODUL === 'berita') {
  quill = new Quill('#f_isi_editor', {
    theme: 'snow',
    modules: { toolbar: '#f_isi_toolbar' },
    placeholder: 'Tulis isi berita di sini...'
  });
  quill.on('text-change', function(){
    document.getElementById('f_isi').value = quill.root.innerHTML;
  });
}

function togglePreview(value){
  const wrap = document.getElementById('f_foto_preview_wrap');
  const img = document.getElementById('f_foto_preview');
  if (!wrap || !img) return;
  value = (value || '').trim();
  if (!value) { wrap.classList.remove('show'); return; }
  const src = /^https?:\/\//i.test(value) ? value : '../' + value.replace(/^\/+/, '');
  img.onerror = () => wrap.classList.remove('show');
  img.onload = () => wrap.classList.add('show');
  img.src = src;
}

document.getElementById('f_foto')?.addEventListener('input', e => togglePreview(e.target.value));

function tambahMode(){
  document.getElementById('modalTitle').innerText = 'Tambah Data';
  document.getElementById('f_id').value = '';
  document.querySelectorAll('#modalForm input[type=text], #modalForm input[type=date], #modalForm textarea, #modalForm select').forEach(el => el.value = '');
  if (quill) quill.setText('');
  togglePreview('');
}

function editMode(data){
  document.getElementById('modalTitle').innerText = 'Edit Data';
  document.getElementById('f_id').value = data.id;

  if (MODUL === 'fakultas') {
    document.getElementById('f_nama_fakultas').value = data.nama_fakultas;
    document.getElementById('f_nama_dekan').value = data.nama_dekan;
    document.getElementById('f_deskripsi').value = data.deskripsi;
  } else if (MODUL === 'galeri') {
    document.getElementById('f_judul').value = data.judul;
    document.getElementById('f_kategori').value = data.kategori;
  } else if (MODUL === 'berita') {
    document.getElementById('f_judul').value = data.judul;
    document.getElementById('f_isi').value = data.isi || '';
    if (quill) quill.root.innerHTML = data.isi || '';
    document.getElementById('f_penulis').value = data.penulis || '';
    document.getElementById('f_tanggal').value = data.tanggal || '';
  }

  const fotoInput = document.getElementById('f_foto');
  if (fotoInput) { fotoInput.value = data.foto || ''; togglePreview(data.foto || ''); }

  new bootstrap.Modal(document.getElementById('modalForm')).show();
}

document.querySelector('#modalForm form')?.addEventListener('submit', function(e){
  if (MODUL === 'berita' && quill) {
    document.getElementById('f_isi').value = quill.root.innerHTML;
    if (quill.getText().trim().length === 0) {
      e.preventDefault();
      alert('Isi berita tidak boleh kosong.');
      return;
    }
  }
  const btn = document.getElementById('btnSimpan');
  const label = document.getElementById('btnSimpanText');
  btn.disabled = true;
  label.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...';
});
</script>