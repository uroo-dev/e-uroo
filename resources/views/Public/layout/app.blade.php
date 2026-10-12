<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-UROO - E-Commerce UMKM Lokal')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f2f9f1',
                            100: '#e1f2df',
                            200: '#c5e5c2',
                            300: '#9cd197',
                            400: '#6eb568',
                            500: '#387c33',
                            600: '#2e632b',
                            700: '#284f26',
                            800: '#224221',
                            900: '#1b331a',
                            dark: '#122411',
                        },
                        earth: {
                            amber: '#8b4513',
                            terracotta: '#9e3a1f',
                            rust: '#800000',
                            sand: '#f4ebd0',
                            cream: '#fdfbf7',
                            sage: '#d8e2dc',
                        }
                    },
                    fontFamily: {
                        display: ['Fredoka', 'sans-serif'],
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    boxShadow: {
                        'organic': '0 20px 25px -5px rgba(34, 66, 33, 0.08), 0 8px 10px -6px rgba(34, 66, 33, 0.05)',
                        'organic-lg': '0 25px 50px -12px rgba(34, 66, 33, 0.18)',
                    }
                }
            }
        };
    </script>
    <style>
        .organic-badge {
            border-radius: 1.5rem 0.5rem 1.5rem 0.5rem;
        }
        ::-webkit-scrollbar {
            width: 10px;
        }
        ::-webkit-scrollbar-track {
            background: #fdfbf7;
        }
        ::-webkit-scrollbar-thumb {
            background: #387c33;
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #284f26;
        }
        .nav-glass {
            background: rgba(27, 51, 26, 0.95);
            backdrop-filter: blur(12px);
        }
    </style>
    <link rel="stylesheet" href="{{ asset('template/assets/css/style.css') }}">
</head>
<body class="font-sans bg-earth-cream text-brand-dark antialiased min-h-screen flex flex-col justify-between">

    <!-- Toast Container -->
    <div id="toast-container" class="fixed bottom-4 right-4 z-[90] flex flex-col gap-2 items-end"></div>

    <div id="public-area" class="flex-1 flex flex-col">
        @include('Public.layout.navbar')

        <main class="flex-1">
            @yield('content')
        </main>

        @include('Public.layout.footer')
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            easing: 'ease-out-cubic'
        });
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
