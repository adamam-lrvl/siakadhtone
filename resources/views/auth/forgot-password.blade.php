<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - SIAKAD HTONE</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>

<body class="min-h-screen font-['Inter'] antialiased flex">

    {{-- PANEL KIRI — BIRU (hidden di HP) --}}
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-600 to-indigo-700
                flex-col items-center justify-center p-12 text-white">
        <div class="max-w-sm text-center">
            <div class="w-20 h-20 bg-white/15 rounded-3xl flex items-center justify-center mx-auto mb-6 overflow-hidden">
                <img src="{{ asset('loho-sekolah.png') }}" alt="Logo"
                     class="w-full h-full object-contain"
                     onerror="this.style.display='none'; this.parentElement.innerHTML='<span class=\'text-white font-bold text-2xl\'>S</span>'">
            </div>
            <h1 class="text-3xl font-bold mb-2">SIAKAD HTONE</h1>
            <p class="text-blue-200 text-sm mb-10">
                Sistem Informasi Akademik<br>SMK Hang Tuah 1 Jakarta
            </p>

            {{-- INFO --}}
            <div class="bg-white/10 rounded-2xl p-6 text-left">
                <div class="flex items-start gap-3 mb-4">
                    <div class="bg-white/20 rounded-lg p-1.5 flex-shrink-0 mt-0.5">
                        <i data-lucide="mail" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-sm">Cek email kamu</p>
                        <p class="text-blue-200 text-xs mt-0.5">Kami akan kirim link reset ke email yang terdaftar</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 mb-4">
                    <div class="bg-white/20 rounded-lg p-1.5 flex-shrink-0 mt-0.5">
                        <i data-lucide="link" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-sm">Klik link di email</p>
                        <p class="text-blue-200 text-xs mt-0.5">Link berlaku selama 60 menit setelah dikirim</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="bg-white/20 rounded-lg p-1.5 flex-shrink-0 mt-0.5">
                        <i data-lucide="lock" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-sm">Buat password baru</p>
                        <p class="text-blue-200 text-xs mt-0.5">Masukkan password baru yang aman</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- PANEL KANAN — FORM --}}
    <div class="flex-1 flex flex-col items-center justify-center
                bg-gray-50 px-6 py-12 min-h-screen">

        {{-- LOGO MOBILE --}}
        <div class="lg:hidden text-center mb-8">
            <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-3 overflow-hidden">
                <img src="{{ asset('loho-sekolah.png') }}" alt="Logo"
                     class="w-full h-full object-contain"
                     onerror="this.style.display='none'">
            </div>
            <p class="font-bold text-gray-900">SIAKAD HTONE</p>
            <p class="text-xs text-gray-400">SMK Hang Tuah 1 Jakarta</p>
        </div>

        <div class="w-full max-w-sm">

            {{-- JUDUL --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Lupa password?</h2>
                <p class="text-sm text-gray-400 mt-1">
                    Masukkan email kamu, kami akan kirim link reset password.
                </p>
            </div>

            {{-- STATUS --}}
            @if(session('status'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3
                            rounded-xl flex items-center gap-3 text-sm mb-6">
                    <i data-lucide="check-circle" class="w-4 h-4 flex-shrink-0"></i>
                    {{ session('status') }}
                </div>
            @endif

            {{-- ERROR --}}
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3
                            rounded-xl flex items-center gap-3 text-sm mb-6">
                    <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- FORM --}}
            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                {{-- EMAIL --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        Email
                    </label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-3.5 top-1/2 -translate-y-1/2
                                                      text-gray-400 w-4 h-4"></i>
                        <input type="email" name="email" value="{{ old('email') }}"
                               required autofocus
                               placeholder="contoh@email.com"
                               class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200
                                      rounded-xl text-sm text-gray-800 focus:outline-none
                                      focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                      transition @error('email') border-red-400 bg-red-50 @enderror">
                    </div>
                </div>

                {{-- SUBMIT --}}
                <button type="submit"
                        class="w-full py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600
                               hover:from-blue-700 hover:to-indigo-700 text-white font-semibold
                               rounded-xl text-sm shadow-sm hover:shadow-md transition mt-2">
                    Kirim link reset
                </button>

            </form>

            {{-- KEMBALI --}}
            <div class="mt-5 text-center">
                <a href="{{ route('login') }}"
                   class="inline-flex items-center gap-1.5 text-xs font-semibold
                          text-gray-500 hover:text-gray-700 transition">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    Kembali ke halaman login
                </a>
            </div>

            {{-- FOOTER --}}
            <p class="text-center text-xs text-gray-400 mt-8">
                © {{ date('Y') }} SIAKAD HTONE — SMK Hang Tuah 1 Jakarta
            </p>

        </div>
    </div>

</body>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();
    });
</script>
</html>