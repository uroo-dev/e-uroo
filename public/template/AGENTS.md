# AGENTS.md

## Project Overview

**NusantaraMart** — a front-end-only e-commerce UI template for Indonesian UMKM (small businesses). Static HTML + vanilla JS, no backend, no build system, no package manager, no tests, no git repo. All UI copy is in **Indonesian** (`lang="id"`), currency formatted like `Rp412.000`. All data/actions are demo-only: buttons fire toasts, flip demo states, or navigate between pre-rendered sections.

## File Structure

```
index.html            Toko publik (storefront) - 20 "page" sections
admin.html            Panel admin - sidebar + "apage" sections + Chart.js
assets/css/style.css  Custom CSS kecil (toast anim, sidebar collapsed, skeleton)
assets/js/shared.js   Fungsi bersama: toast, modal, chip, accordion, password, copy
assets/js/app.js      Logika publik: router go(), cart, wishlist, galeri, tab, demo state
assets/js/admin.js    Logika admin: router goAdmin(), drawer, collapse, chart, bulk select
```

## Running / Previewing

No build step. Serve statically (fetch/clipboard work better over http than file://):

```sh
python3 -m http.server 8000   # index.html = toko, admin.html = panel admin
```

Internet required: Tailwind Play CDN, Lucide (unpkg), Chart.js (jsdelivr, admin only), Google Fonts.

## Dependencies (CDN only)

| Library | Loaded in | Usage |
|---|---|---|
| Tailwind CSS Play CDN | both | All styling via utility classes; no config file. Font via arbitrary class `font-['Plus_Jakarta_Sans']` on `<body>`. |
| Lucide icons | both | `<i data-lucide="name" class="w-4 h-4">`; rendered by `renderIcons()` (shared.js) on DOMContentLoaded and after dynamic icon injection. |
| Chart.js | admin.html only | `#salesChart` (bar, 7 hari) + `#categoryChart` (doughnut, kategori) initialized in `admin.js:initCharts()`. |

## Architecture: show/hide "routing", no real router

- **index.html**: pages are `<section data-page="NAME" class="page">`, exactly one visible; `go('name')` toggles `hidden`, closes mobile menu, scrolls to top. Unknown target falls back to `data-page="404"`. Pages: `home, products, product, category, search, cart, checkout, payment, success, orders, order-detail, wishlist, profile, login, register, forgot, about, contact, faq, 404`.
- **admin.html**: pages are `<section data-admin-page="a-NAME" class="apage">`; `goAdmin('a-name')` also syncs active state on `.anav` buttons via their `data-anav` attribute. **Sidebar links to 8 pages that don't exist** (`a-order-status, a-payments, a-customers, a-vouchers, a-banners, a-reports, a-settings, a-profile`) plus `a-order-detail` from the orders table; `goAdmin` falls back to the `a-placeholder` section ("Halaman belum tersedia"). Real pages: `a-dashboard, a-products, a-product-add, a-product-edit, a-categories, a-inventory, a-orders`.
- **Cross-navigation**: `openAdmin()` → `location.href='admin.html'`; `openStore()` → `index.html`.
- **Modals**: `openModal(id)`/`closeModal(id)` toggle `hidden`. index.html has `#modal-cancel-order`; admin.html has `#modal-delete`, `#modal-confirm-payment`, and `#modal-category` (nested inside the a-categories section). Backdrop click closes.
- **Toasts**: `toast(message, type)` with type `'success'`|`'error'` into `#toast-container`, auto-dismiss ~3s, animation via `.toast-item` in style.css.

### Demo-state pattern

Content is static HTML; "interactivity" is toggling between pre-rendered states:

- `toggleDemoState('cart'|'search'|'orders'|'wishlist')` — swaps `{area}-filled` / `{area}-empty` (public pages only).
- `toggleOrdersError()` — swaps `#orders-table-wrap` / `#orders-error` (admin).
- `simulateLoading()` — swaps `#dash-content` / `#dash-skeleton` for 1.2s (admin dashboard).

Keep this pattern when extending: add both states in HTML, toggle with a small gray "Demo:" button.

## Conventions & Gotchas

- **Interaction model**: inline `onclick=`/`onchange=`/`onsubmit=` handlers calling **plain global functions** (no modules). New functions used by both pages go in `shared.js`; page-specific ones in `app.js` / `admin.js`.
- **Lucide replaces `<i data-lucide>` with `<svg>`** after `renderIcons()` — never query `i[data-lucide]` after load; query `svg` instead, or re-inject `<i data-lucide>` + call `renderIcons()` (see `togglePassword`).
- **Chips**: `selectChip(this, 'chip-GROUP')` — GROUP is a shared class (`chip-kat, chip-order, chip-rating, chip-roast, chip-varian` public; `chip-ostatus` admin). Two visual styles auto-detected: solid (`bg-emerald-700 text-white`) vs outline (`border-emerald-700 bg-emerald-50`).
- **Option cards**: `selectOption(this, 'opt-kurir'|'opt-bayar')` — active `border-2 border-emerald-700 bg-emerald-50/50`.
- **Tabs** (three near-identical switchers in app.js): `switchInfoTab(name)` uses ids `tab-btn-{name}`/`info-{name}` + classes `.info-tab`/`.info-panel`; `switchOrderTab(btn,id)` uses `.otab-btn` + ids `otab-*`; `switchProfileTab(btn,id)` uses `.ptab` + `.ptab-panel` (ids `ptab-*`).
- **Voucher**: only code `HEMAT20` is valid (`applyVoucher()` toggles `#voucher-success`/`#voucher-error`).
- **Cart badge**: `addToCart(name)` increments `#cart-count`; `changeQty(id, ±1)` clamps at min 1.
- **Bulk select (admin)**: `toggleSelectAll(master,'prod-check')` + `updateBulkBar()` drive `#bulk-bar`/`#bulk-count`.
- **Sidebar collapse (admin)**: `toggleAdminCollapse()` toggles `.admin-collapsed`; CSS hides `.side-label` — keep that class on any label that must hide when collapsed.
- **Color language**: brand emerald (700 buttons, 900/950 navbars & sidebar, 50 tints); accent orange; slate neutrals; public bg `bg-slate-50`, admin bg `bg-slate-100`; destructive red-600; status pills on `-50` backgrounds (amber/blue/sky/orange/emerald/red).
- **Shape/type**: `rounded-xl` controls, `rounded-2xl` cards/modals; headings `font-extrabold tracking-tight`; cards `bg-white border border-slate-200 rounded-2xl`.
- **Images**: external placeholders only (`images.unsplash.com` with `onerror` fallback to `picsum.photos`). Don't add local image assets.
- **Accessibility**: icon-only buttons carry `aria-label`; preserve in new markup.
- **Language**: all user-facing text must be Indonesian.

## Commands

None — no build, lint, test, or CI. Verification loop: open both pages in a browser and watch the console for `ReferenceError`s; every function referenced by inline handlers must be defined in one of the three JS files.
