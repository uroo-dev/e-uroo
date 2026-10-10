<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - NusantaraMart</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  
  <!-- Tailwind CSS & Lucide Icons CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="{{ asset('template/assets/css/style.css') }}">
</head>
<body class="font-['Plus_Jakarta_Sans'] bg-slate-100 text-slate-800 antialiased">

  <!-- Toast Container -->
  <div id="toast-container" class="fixed bottom-4 right-4 z-[90] flex flex-col gap-2 items-end"></div>

  <!-- Modal admin (hapus, konfirmasi pembayaran, kategori) -->
  <div>@include('Admin.partials.modal')</div>

  <div id="admin-area" class="min-h-screen flex bg-slate-100">

    <div id="admin-overlay" class="hidden fixed inset-0 bg-slate-900/60 z-40 lg:hidden" onclick="toggleAdminDrawer()"></div>

    <!-- Sidebar -->
    @include('Admin.layout.sidebar')

    <div class="flex-1 min-w-0 flex flex-col">
      <!-- Topbar -->
      @include('Admin.layout.header')

      <main class="flex-1 p-4 lg:p-8">
        @yield('content')
      </main>
    </div>
  </div>

  <script src="{{ asset('template/assets/js/shared.js') }}"></script>
  <script src="{{ asset('template/assets/js/admin.js') }}"></script>
  <script>
    if (window.lucide) {
      lucide.createIcons();
    }
  </script>
</body>
</html>
