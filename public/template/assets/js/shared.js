/* NusantaraMart - fungsi bersama (dipakai index.html & admin.html) */

/* ---------- Ikon ---------- */
function renderIcons() {
  if (window.lucide) lucide.createIcons();
}

/* ---------- Muat partial (satu file per halaman di pages/ & admin/pages/) ---------- */
function includePartials() {
  var nodes = Array.prototype.slice.call(document.querySelectorAll('[data-include]'));
  return Promise.all(nodes.map(function (node) {
    var src = node.getAttribute('data-include');
    return fetch(src, { cache: 'no-cache' }).then(function (res) {
      if (!res.ok) throw new Error('Gagal memuat ' + src + ' (HTTP ' + res.status + ')');
      return res.text();
    }).then(function (html) {
      var frag = document.createRange().createContextualFragment(html);
      node.parentNode.replaceChild(frag, node);
    });
  }));
}

/* ---------- Boot: muat partial dulu, render ikon, lalu callback halaman ---------- */
function bootApp(afterIncludes) {
  function run() {
    includePartials().then(function () {
      renderIcons();
      if (afterIncludes) afterIncludes();
    }).catch(function (err) {
      console.error(err);
      toast('Sebagian konten gagal dimuat. Jalankan lewat server lokal (python3 -m http.server 8000), bukan file://.', 'error');
    });
  }
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', run);
  } else {
    run();
  }
}

/* ---------- Toast ---------- */
function toast(message, type) {
  var container = document.getElementById('toast-container');
  if (!container) return;
  var isError = type === 'error';
  var el = document.createElement('div');
  el.className = 'toast-item flex items-center gap-2.5 max-w-xs bg-white border ' +
    (isError ? 'border-red-100' : 'border-emerald-100') +
    ' shadow-lg rounded-xl px-4 py-3 text-sm font-semibold ' +
    (isError ? 'text-red-700' : 'text-emerald-800');
  el.innerHTML = '<i data-lucide="' + (isError ? 'alert-circle' : 'check-circle-2') +
    '" class="w-4 h-4 shrink-0"></i><span>' + message + '</span>';
  container.appendChild(el);
  renderIcons();
  setTimeout(function () {
    el.classList.add('toast-out');
    setTimeout(function () { el.remove(); }, 300);
  }, 2800);
}

/* ---------- Modal ---------- */
function openModal(id) {
  var m = document.getElementById(id);
  if (m) m.classList.remove('hidden');
}
function closeModal(id) {
  var m = document.getElementById(id);
  if (m) m.classList.add('hidden');
}

/* ---------- Chip filter (dua gaya: solid & outline) ---------- */
function selectChip(el, group) {
  var chips = Array.prototype.slice.call(document.querySelectorAll('.' + group));
  var solid = chips.some(function (c) { return c.classList.contains('bg-emerald-700'); });
  chips.forEach(function (c) {
    if (solid) {
      c.classList.remove('bg-emerald-700', 'text-white', 'border-transparent');
      c.classList.add('bg-slate-50', 'border', 'border-slate-200', 'text-slate-600');
    } else {
      c.classList.remove('border-emerald-700', 'bg-emerald-50', 'text-emerald-800');
      c.classList.add('border-slate-200', 'text-slate-600');
    }
  });
  if (solid) {
    el.classList.remove('bg-slate-50', 'bg-white', 'border-slate-200', 'text-slate-600');
    el.classList.add('bg-emerald-700', 'text-white', 'border', 'border-transparent');
  } else {
    el.classList.remove('border-slate-200', 'text-slate-600');
    el.classList.add('border-emerald-700', 'bg-emerald-50', 'text-emerald-800');
  }
}

/* ---------- Kartu opsi (kurir / pembayaran) ---------- */
function selectOption(el, group) {
  document.querySelectorAll('.' + group).forEach(function (c) {
    c.classList.remove('border-2', 'border-emerald-700', 'bg-emerald-50/50');
    c.classList.add('border', 'border-slate-200');
  });
  el.classList.remove('border', 'border-slate-200');
  el.classList.add('border-2', 'border-emerald-700', 'bg-emerald-50/50');
}

/* ---------- Akordeon (FAQ) ---------- */
function toggleAccordion(btn) {
  var panel = btn.nextElementSibling;
  var icon = btn.querySelector('svg, i');
  if (panel) panel.classList.toggle('hidden');
  if (icon) icon.classList.toggle('rotate-180');
}

/* ---------- Lihat/sembunyikan password ---------- */
function togglePassword(id, btn) {
  var input = document.getElementById(id);
  if (!input) return;
  var show = input.type === 'password';
  input.type = show ? 'text' : 'password';
  if (btn) {
    btn.innerHTML = '<i data-lucide="' + (show ? 'eye-off' : 'eye') + '" class="w-4 h-4"></i>';
    renderIcons();
  }
}

/* ---------- Salin teks ---------- */
function copyText(text) {
  if (navigator.clipboard && navigator.clipboard.writeText) {
    navigator.clipboard.writeText(text).then(function () {
      toast('Disalin ke clipboard', 'success');
    });
  } else {
    toast('Teks: ' + text, 'success');
  }
}

/* ---------- Demo state (filled <-> empty), dipakai publik & admin ---------- */
function toggleDemoState(area) {
  var filled = document.getElementById(area + '-filled');
  var empty = document.getElementById(area + '-empty');
  if (!filled || !empty) return;
  var nowFilled = !filled.classList.contains('hidden');
  filled.classList.toggle('hidden', nowFilled);
  empty.classList.toggle('hidden', !nowFilled);
}
