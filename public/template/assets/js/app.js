/* NusantaraMart - logika toko publik (index.html) */

/* ---------- Router halaman publik ---------- */
function go(page) {
  var target = document.querySelector('[data-page="' + page + '"]');
  if (!target) {
    page = '404';
    target = document.querySelector('[data-page="404"]');
  }
  document.querySelectorAll('.page').forEach(function (s) { s.classList.add('hidden'); });
  if (target) target.classList.remove('hidden');
  var menu = document.getElementById('mobile-menu');
  if (menu) menu.classList.add('hidden');
  showSearchDropdown(false);
  window.scrollTo({ top: 0 });
}

function openAdmin() {
  location.href = 'admin.html';
}

/* ---------- Menu & pencarian ---------- */
function toggleMobileMenu() {
  document.getElementById('mobile-menu').classList.toggle('hidden');
}

function showSearchDropdown(show) {
  var dd = document.getElementById('search-dropdown');
  if (dd) dd.classList.toggle('hidden', !show);
}

/* ---------- Filter drawer (halaman produk) ---------- */
function openFilterDrawer() {
  document.getElementById('filter-drawer').classList.remove('hidden');
}
function closeFilterDrawer() {
  document.getElementById('filter-drawer').classList.add('hidden');
}

/* ---------- Keranjang & wishlist ---------- */
function addToCart(name) {
  var badge = document.getElementById('cart-count');
  if (badge) badge.textContent = (parseInt(badge.textContent, 10) || 0) + 1;
  toast(name + ' masuk ke keranjang', 'success');
}

function changeQty(id, delta) {
  var input = document.getElementById(id);
  if (!input) return;
  var val = (parseInt(input.value, 10) || 1) + delta;
  input.value = Math.max(1, val);
}

function toggleWish(btn) {
  var active = btn.classList.toggle('text-rose-500');
  btn.classList.toggle('text-slate-400', !active);
  var svg = btn.querySelector('svg');
  if (svg) svg.setAttribute('fill', active ? 'currentColor' : 'none');
  toast(active ? 'Ditambahkan ke wishlist' : 'Dihapus dari wishlist', active ? 'success' : 'error');
}

/* ---------- Voucher ---------- */
function applyVoucher() {
  var input = document.getElementById('cart-voucher');
  var ok = document.getElementById('voucher-success');
  var err = document.getElementById('voucher-error');
  var valid = input && input.value.trim().toUpperCase() === 'HEMAT20';
  if (ok) ok.classList.toggle('hidden', !valid);
  if (err) err.classList.toggle('hidden', valid);
  toast(valid ? 'Voucher HEMAT20 dipakai' : 'Kode voucher tidak valid', valid ? 'success' : 'error');
}

/* ---------- Galeri produk ---------- */
function setGallery(mainUrl, fallbackUrl) {
  var img = document.getElementById('gallery-main');
  if (!img) return;
  img.onerror = fallbackUrl ? function () { this.onerror = null; this.src = fallbackUrl; } : null;
  img.src = mainUrl;
  document.querySelectorAll('[onclick^="setGallery("]').forEach(function (b) {
    var isActive = b.getAttribute('onclick').indexOf(mainUrl) !== -1;
    b.classList.toggle('ring-2', isActive);
    b.classList.toggle('ring-emerald-600', isActive);
    b.classList.toggle('border', !isActive);
    b.classList.toggle('border-slate-200', !isActive);
  });
}

/* ---------- Tab info produk ---------- */
function switchInfoTab(name) {
  document.querySelectorAll('.info-tab').forEach(function (b) {
    var on = b.id === 'tab-btn-' + name;
    b.classList.toggle('font-bold', on);
    b.classList.toggle('border-emerald-700', on);
    b.classList.toggle('text-emerald-800', on);
    b.classList.toggle('font-semibold', !on);
    b.classList.toggle('border-transparent', !on);
    b.classList.toggle('text-slate-500', !on);
  });
  document.querySelectorAll('.info-panel').forEach(function (p) {
    p.classList.toggle('hidden', p.id !== 'info-' + name);
  });
}

/* ---------- Tab detail pesanan ---------- */
function switchOrderTab(btn, tabId) {
  document.querySelectorAll('.otab-btn').forEach(function (b) {
    var on = b === btn;
    b.classList.toggle('font-bold', on);
    b.classList.toggle('border-emerald-700', on);
    b.classList.toggle('text-emerald-800', on);
    b.classList.toggle('font-semibold', !on);
    b.classList.toggle('border-transparent', !on);
    b.classList.toggle('text-slate-500', !on);
  });
  ['otab-produk', 'otab-riwayat'].forEach(function (id) {
    var p = document.getElementById(id);
    if (p) p.classList.toggle('hidden', id !== tabId);
  });
}

/* ---------- Tab profil ---------- */
function switchProfileTab(btn, tabId) {
  document.querySelectorAll('.ptab').forEach(function (b) {
    var on = b === btn;
    b.classList.toggle('bg-emerald-50', on);
    b.classList.toggle('text-emerald-800', on);
    b.classList.toggle('text-slate-600', !on);
  });
  document.querySelectorAll('.ptab-panel').forEach(function (p) {
    p.classList.toggle('hidden', p.id !== tabId);
  });
}

/* ---------- Boot toko publik ---------- */
bootApp();
