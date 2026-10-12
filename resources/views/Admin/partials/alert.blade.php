{{-- Alert Notifications (Success, Error, Information) --}}

{{-- 1. Success Alert --}}
@if (session('success'))
    <div class="mb-5 flex items-start gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl shadow-sm transition-all duration-300">
        <span class="w-8 h-8 rounded-xl bg-emerald-100/80 text-emerald-700 flex items-center justify-center shrink-0 mt-0.5">
            <i class="fa-solid fa-circle-check text-base"></i>
        </span>
        <div class="flex-1 text-sm">
            <h4 class="font-bold text-emerald-900 leading-tight">Berhasil!</h4>
            <p class="text-xs text-emerald-700 mt-0.5 leading-relaxed">{{ session('success') }}</p>
        </div>
        <button type="button" onclick="this.closest('div').remove()" class="text-emerald-500 hover:text-emerald-700 p-1.5 rounded-lg hover:bg-emerald-100/50 transition shrink-0" aria-label="Tutup">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
    </div>
@endif

{{-- 2. Error Alert --}}
@if (session('error') || $errors->any())
    <div class="mb-5 flex items-start gap-3 p-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl shadow-sm transition-all duration-300">
        <span class="w-8 h-8 rounded-xl bg-red-100/80 text-red-700 flex items-center justify-center shrink-0 mt-0.5">
            <i class="fa-solid fa-circle-exclamation text-base"></i>
        </span>
        <div class="flex-1 text-sm">
            <h4 class="font-bold text-red-900 leading-tight">Terjadi Kesalahan!</h4>
            @if (session('error'))
                <p class="text-xs text-red-700 mt-0.5 leading-relaxed">{{ session('error') }}</p>
            @endif
            @if ($errors->any())
                <ul class="mt-1.5 list-disc list-inside text-xs text-red-700 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        <button type="button" onclick="this.closest('div').remove()" class="text-red-500 hover:text-red-700 p-1.5 rounded-lg hover:bg-red-100/50 transition shrink-0" aria-label="Tutup">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
    </div>
@endif

{{-- 3. Information Alert --}}
@if (session('info') || session('information') || session('status'))
    <div class="mb-5 flex items-start gap-3 p-4 bg-sky-50 border border-sky-200 text-sky-800 rounded-2xl shadow-sm transition-all duration-300">
        <span class="w-8 h-8 rounded-xl bg-sky-100/80 text-sky-700 flex items-center justify-center shrink-0 mt-0.5">
            <i class="fa-solid fa-circle-info text-base"></i>
        </span>
        <div class="flex-1 text-sm">
            <h4 class="font-bold text-sky-900 leading-tight">Informasi</h4>
            <p class="text-xs text-sky-700 mt-0.5 leading-relaxed">{{ session('info') ?? session('information') ?? session('status') }}</p>
        </div>
        <button type="button" onclick="this.closest('div').remove()" class="text-sky-500 hover:text-sky-700 p-1.5 rounded-lg hover:bg-sky-100/50 transition shrink-0" aria-label="Tutup">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
    </div>
@endif

