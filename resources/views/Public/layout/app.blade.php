<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-UROO - E-Commerce UMKM Lokal')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="{{ asset('template/assets/css/style.css') }}">
</head>
<body class="font-['Plus_Jakarta_Sans'] bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">

    <!-- Toast Container -->
    <div id="toast-container" class="fixed bottom-4 right-4 z-[90] flex flex-col gap-2 items-end"></div>

    <div id="public-area" class="flex-1 flex flex-col">
        @include('Public.layout.navbar')

        <main class="flex-1">
            @yield('content')
        </main>

        @include('Public.layout.footer')
    </div>

    <script>
        lucide.createIcons();

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }

        function toast(msg, type = 'info') {
            const container = document.getElementById('toast-container');
            if (!container) return;
            const el = document.createElement('div');
            const bg = type === 'success' ? 'bg-emerald-700' : (type === 'error' ? 'bg-red-600' : 'bg-slate-800');
            el.className = `${bg} text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-lg transition-all transform translate-y-2 opacity-0 duration-200`;
            el.innerText = msg;
            container.appendChild(el);
            setTimeout(() => {
                el.classList.remove('translate-y-2', 'opacity-0');
            }, 10);
            setTimeout(() => {
                el.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => el.remove(), 200);
            }, 3000);
        }
    </script>
    @stack('scripts')
</body>
</html>
