@extends('Auth.layout.app')
@section('title', 'Daftar Akun Baru - E-UROO')
@section('content')
    <!-- ==================== Public Register Page ==================== -->
    <section data-page="register">
        <div class="min-h-[70vh] flex items-center justify-center px-4 py-12">
            <div class="w-full max-w-md">
                <div class="text-center mb-8">
                    <span class="w-12 h-12 mx-auto rounded-2xl bg-emerald-700 flex items-center justify-center">
                        <i data-lucide="leaf" class="w-6 h-6 text-white"></i>
                    </span>
                    <h1 class="text-2xl font-extrabold text-slate-900 mt-4 tracking-tight">Buat akun baru</h1>
                    <p class="text-sm text-slate-500 mt-1.5">Gratis, hanya butuh satu menit</p>
                </div>

                <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm">
                    @if (session('success'))
                        <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm rounded-xl flex items-center gap-2">
                            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 shrink-0"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl">
                            <div class="flex items-center gap-2 font-semibold">
                                <i data-lucide="alert-circle" class="w-4 h-4 text-red-600 shrink-0"></i>
                                <span>Gagal Mendaftar</span>
                            </div>
                            <ul class="mt-1 list-disc list-inside text-xs">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register.process') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="role" value="pelanggan">
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    value="{{ old('name') }}"
                                    required
                                    autofocus
                                    placeholder="Contoh: Rina Sulastri"
                                    class="w-full bg-slate-50 border @error('name') border-red-400 bg-red-50/50 @else border-slate-200 @enderror rounded-xl px-3.5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                >
                                @error('name')
                                    <p class="text-xs text-red-600 font-medium mt-1.5 flex items-center gap-1">
                                        <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email Aktif</label>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email') }}"
                                    required
                                    placeholder="nama@email.com"
                                    class="w-full bg-slate-50 border @error('email') border-red-400 bg-red-50/50 @else border-slate-200 @enderror rounded-xl px-3.5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                >
                                @error('email')
                                    <p class="text-xs text-red-600 font-medium mt-1.5 flex items-center gap-1">
                                        <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor Telepon</label>
                                <input
                                    id="phone"
                                    name="phone"
                                    type="tel"
                                    value="{{ old('phone') }}"
                                    required
                                    placeholder="08xxxxxxxxxx"
                                    class="w-full bg-slate-50 border @error('phone') border-red-400 bg-red-50/50 @else border-slate-200 @enderror rounded-xl px-3.5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                >
                                @error('phone')
                                    <p class="text-xs text-red-600 font-medium mt-1.5 flex items-center gap-1">
                                        <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="pw-register" class="block text-sm font-semibold text-slate-700 mb-1.5">Kata Sandi</label>
                                <div class="relative">
                                    <input
                                        id="pw-register"
                                        name="password"
                                        type="password"
                                        required
                                        placeholder="Minimal 8 karakter"
                                        class="w-full bg-slate-50 border @error('password') border-red-400 @else border-slate-200 @enderror rounded-xl px-3.5 py-3 pr-11 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                    >
                                    <button
                                        type="button"
                                        onclick="togglePassword('pw-register', this)"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600"
                                        aria-label="Tampilkan kata sandi"
                                    >
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="text-xs text-red-600 font-medium mt-1.5 flex items-center gap-1">
                                        <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <label class="flex items-start gap-2.5 cursor-pointer">
                                <input type="checkbox" required class="w-4 h-4 rounded border-slate-300 text-emerald-600 mt-0.5 focus:ring-emerald-500">
                                <span class="text-xs text-slate-500">
                                    Saya menyetujui <a href="#" onclick="return false;" class="font-semibold text-emerald-700 hover:underline">Syarat & Ketentuan</a> serta <a href="#" onclick="return false;" class="font-semibold text-emerald-700 hover:underline">Kebijakan Privasi</a> E-UROO
                                </span>
                            </label>

                            <button
                                type="submit"
                                class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-3.5 rounded-xl text-sm transition shadow-md shadow-emerald-700/20"
                            >
                                Daftar Sekarang
                            </button>
                        </div>
                    </form>
                </div>

                <p class="text-center text-sm text-slate-500 mt-6">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-bold text-emerald-700 hover:text-emerald-800">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </div>
    </section>
@endsection
