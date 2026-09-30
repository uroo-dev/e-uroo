/* NusantaraMart - logika panel admin (admin.html) */

/* ---------- Router halaman admin ---------- */
function goAdmin(page) {
  if (!document.querySelector('[data-admin-page="' + page + '"]')) page = 'a-placeholder';
  document.querySelectorAll('.apage').forEach(function (s) { s.classList.add('hidden'); });
  var target = document.querySelector('[data-admin-page="' + page + '"]');
  if (target) target.classList.remove('hidden');

  document.querySelectorAll('.anav').forEach(function (b) {
    var on = b.getAttribute('data-anav') === page;
    b.classList.toggle('bg-emerald-500', on);
    b.classList.toggle('text-emerald-950', on);
    b.classList.toggle('font-bold', on);
    b.classList.toggle('text-emerald-100/80', !on);
  });

  if (window.innerWidth < 1024) closeAdminDrawer();
  window.scrollTo({ top: 0 });
}

function openStore() {
  location.href = 'index.html';
}

/* ---------- Sidebar ---------- */
function toggleAdminDrawer() {
  var sidebar = document.getElementById('admin-sidebar');
  var overlay = document.getElementById('admin-overlay');
  var open = sidebar.classList.contains('-translate-x-full');
  sidebar.classList.toggle('-translate-x-full', !open);
  sidebar.classList.toggle('translate-x-0', open);
  if (overlay) overlay.classList.toggle('hidden', !open);
}

function closeAdminDrawer() {
  var sidebar = document.getElementById('admin-sidebar');
  var overlay = document.getElementById('admin-overlay');
  if (window.innerWidth >= 1024) return;
  sidebar.classList.add('-translate-x-full');
  sidebar.classList.remove('translate-x-0');
  if (overlay) overlay.classList.add('hidden');
}

function toggleAdminCollapse() {
  document.getElementById('admin-sidebar').classList.toggle('admin-collapsed');
}

/* ---------- Dropdown notifikasi ---------- */
function toggleNotifDropdown() {
  document.getElementById('notif-dropdown').classList.toggle('hidden');
}
document.addEventListener('click', function (e) {
  var dd = document.getElementById('notif-dropdown');
  if (!dd || dd.classList.contains('hidden')) return;
  if (!e.target.closest('#notif-dropdown') && !e.target.closest('[onclick*="toggleNotifDropdown"]')) {
    dd.classList.add('hidden');
  }
});

/* ---------- Demo: skeleton loading dashboard ---------- */
function simulateLoading() {
  var skeleton = document.getElementById('dash-skeleton');
  var content = document.getElementById('dash-content');
  skeleton.classList.remove('hidden');
  content.classList.add('hidden');
  setTimeout(function () {
    skeleton.classList.add('hidden');
    content.classList.remove('hidden');
    toast('Data dashboard diperbarui', 'success');
  }, 1200);
}

/* ---------- Demo: error state tabel pesanan ---------- */
function toggleOrdersError() {
  document.getElementById('orders-table-wrap').classList.toggle('hidden');
  document.getElementById('orders-error').classList.toggle('hidden');
}

/* ---------- Bulk select tabel produk ---------- */
function toggleSelectAll(master, cls) {
  document.querySelectorAll('.' + cls).forEach(function (cb) { cb.checked = master.checked; });
  updateBulkBar();
}

function updateBulkBar() {
  var count = document.querySelectorAll('.prod-check:checked').length;
  var bar = document.getElementById('bulk-bar');
  var label = document.getElementById('bulk-count');
  if (label) label.textContent = count;
  if (bar) bar.classList.toggle('hidden', count === 0);
}

/* ---------- Chart.js (dashboard) ---------- */
function initCharts() {
  if (!window.Chart) return;
  var sales = document.getElementById('salesChart');
  if (sales) {
    new Chart(sales, {
      type: 'bar',
      data: {
        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
        datasets: [{
          label: 'Penjualan (Rp juta)',
          data: [5.2, 6.8, 4.9, 7.4, 8.1, 9.6, 6.3],
          backgroundColor: 'rgba(4, 120, 87, 0.85)',
          borderRadius: 8,
          maxBarThickness: 34
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          y: { beginAtZero: true, grid: { color: 'rgba(148, 163, 184, 0.15)' }, ticks: { font: { size: 11 } } },
          x: { grid: { display: false }, ticks: { font: { size: 11 } } }
        }
      }
    });
  }
  var category = document.getElementById('categoryChart');
  if (category) {
    new Chart(category, {
      type: 'doughnut',
      data: {
        labels: ['Kopi & Minuman', 'Camilan', 'Fashion', 'Lainnya'],
        datasets: [{
          data: [34, 26, 22, 18],
          backgroundColor: ['#047857', '#34d399', '#fb923c', '#cbd5e1'],
          borderWidth: 0
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '68%',
        plugins: { legend: { display: false } }
      }
    });
  }
}

/* ---------- Boot panel admin: tunggu partial halaman dimuat ---------- */
bootApp(function () {
  initCharts();
  updateBulkBar();
});
