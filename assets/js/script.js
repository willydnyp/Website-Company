// Toggle sidebar admin (mobile)
document.addEventListener('DOMContentLoaded', function () {
  const toggleBtn = document.getElementById('sidebarToggle');
  const sidebar = document.getElementById('sidebar');
  if (toggleBtn && sidebar) {
    toggleBtn.addEventListener('click', () => sidebar.classList.toggle('show'));
  }

  // Lightbox galeri sederhana
  const galleryItems = document.querySelectorAll('.gallery-item img');
  const lightbox = document.getElementById('lightboxModal');
  if (galleryItems.length && lightbox) {
    const lightboxImg = document.getElementById('lightboxImg');
    galleryItems.forEach(img => {
      img.addEventListener('click', () => {
        lightboxImg.src = img.src;
        const modal = new bootstrap.Modal(lightbox);
        modal.show();
      });
    });
  }

  // Aktifkan tooltip Bootstrap jika ada
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
  tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));
});

// Konfirmasi hapus data (dipakai di dashboard admin) via SweetAlert2
function confirmDelete(url) {
  Swal.fire({
    title: 'Yakin ingin menghapus?',
    text: 'Data yang dihapus tidak dapat dikembalikan!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#0b3d91',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  });
}

// Notifikasi alert dari query string (?success= / ?error=)
function showAlertFromQuery() {
  const params = new URLSearchParams(window.location.search);
  if (params.get('success')) {
    Swal.fire({ icon: 'success', title: 'Berhasil', text: params.get('success'), timer: 2000, showConfirmButton: false });
  }
  if (params.get('error')) {
    Swal.fire({ icon: 'error', title: 'Gagal', text: params.get('error') });
  }
}
document.addEventListener('DOMContentLoaded', showAlertFromQuery);
