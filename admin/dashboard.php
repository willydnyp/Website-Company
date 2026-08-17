<?php
session_start();
require_once '../includes/functions.php';
requireLogin();

$page_title = 'Dashboard';
$active_menu = 'dashboard';

$totalMhs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM mahasiswa"))['c'];
$totalDosen = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM dosen"))['c'];
$totalFakultas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM fakultas"))['c'];
$totalPengunjung = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM pengunjung"))['c'];

$visitQuery = mysqli_query($koneksi, "SELECT tanggal, COUNT(*) jumlah FROM pengunjung WHERE tanggal >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) GROUP BY tanggal ORDER BY tanggal ASC");
$visitLabels = []; $visitData = [];
while ($row = mysqli_fetch_assoc($visitQuery)) { $visitLabels[] = $row['tanggal']; $visitData[] = (int)$row['jumlah']; }

include 'includes/layout.php';
?>

<div class="row g-3">
  <div class="col-md-4 col-lg-2"><div class="card dash-card p-3 d-flex flex-row align-items-center gap-3"><div class="icon-box bg-primary"><i class="fa-solid fa-user-graduate"></i></div><div><h4 class="fw-bold mb-0"><?= $totalMhs ?></h4><small class="text-muted">Mahasiswa</small></div></div></div>
  <div class="col-md-4 col-lg-2"><div class="card dash-card p-3 d-flex flex-row align-items-center gap-3"><div class="icon-box bg-success"><i class="fa-solid fa-chalkboard-user"></i></div><div><h4 class="fw-bold mb-0"><?= $totalDosen ?></h4><small class="text-muted">Dosen</small></div></div></div>
  <div class="col-md-4 col-lg-2"><div class="card dash-card p-3 d-flex flex-row align-items-center gap-3"><div class="icon-box bg-warning"><i class="fa-solid fa-building-columns"></i></div><div><h4 class="fw-bold mb-0"><?= $totalFakultas ?></h4><small class="text-muted">Fakultas</small></div></div></div>
  <div class="col-md-4 col-lg-2"><div class="card dash-card p-3 d-flex flex-row align-items-center gap-3"><div class="icon-box bg-secondary"><i class="fa-solid fa-eye"></i></div><div><h4 class="fw-bold mb-0"><?= $totalPengunjung ?></h4><small class="text-muted">Pengunjung</small></div></div></div>
</div>

<div class="row g-3 mt-1">
  <div class="col-lg-6"><div class="card dash-card p-3"><h6 class="fw-bold mb-3">Kunjungan Website (7 Hari Terakhir)</h6><canvas id="chartVisit" height="220"></canvas></div></div>
</div>

<?php include 'includes/footer.php'; ?>
<script>
new Chart(document.getElementById('chartVisit'), {
  type: 'line',
  data: { labels: <?= json_encode($visitLabels) ?>, datasets: [{ label: 'Pengunjung', data: <?= json_encode($visitData) ?>, borderColor: '#ffb703', backgroundColor: 'rgba(255,183,3,.2)', fill: true, tension: .3 }] },
  options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});
</script>
