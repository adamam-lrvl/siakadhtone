<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - SIAKAD HTONE</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }

        .glass-card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.22);
        }

        .glass-input {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #fff;
            transition: all 0.2s;
        }
        .glass-input::placeholder { color: rgba(255,255,255,0.45); }
        .glass-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.22);
            border-color: rgba(255, 255, 255, 0.5);
            box-shadow: 0 0 0 3px rgba(255,255,255,0.12);
        }

        .glass-btn {
            background: rgba(255, 255, 255, 0.95);
            color: #1d4ed8;
            font-weight: 700;
            border: none;
            transition: all 0.2s;
        }
        .glass-btn:hover {
            background: #ffffff;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            transform: translateY(-1px);
        }

        .glass-feature {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .success-glass {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.35);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .error-glass {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.35);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>

<body class="min-h-screen flex overflow-hidden">

    {{-- BACKGROUND FOTO SEKOLAH --}}
    <div class="fixed inset-0 z-0">
        <img src="{{ asset('foto-sekolah.jpg') }}"
             alt="SMK Hang Tuah 1 Jakarta"
             class="w-full h-full object-cover object-center"
             onerror="this.style.display='none'">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900/80 via-blue-800/70 to-indigo-900/85"></div>
    </div>

    {{-- CONTENT --}}
    <div class="relative z-10 flex w-full min-h-screen">

        {{-- PANEL KIRI --}}
        <div class="hidden lg:flex lg:w-1/2 flex-col items-center justify-center p-14 text-white">
            <div class="max-w-sm w-full">

                {{-- LOGO --}}
                <div class="glass-card w-20 h-20 rounded-3xl flex items-center justify-center mb-7 overflow-hidden">
                    <img src="{{ asset('loho-sekolah.png') }}" alt="Logo"
                         class="w-full h-full object-contain"
                         onerror="this.style.display='none'; this.parentElement.innerHTML='<span style=\'color:white;font-weight:800;font-size:1.5rem\'>S</span>'">
                </div>

                <h1 class="text-4xl font-extrabold mb-2 leading-tight tracking-tight">
                    SIAKAD<br>HT ONE
                </h1>
                <p class="text-white/60 text-sm mb-10 leading-relaxed">
                    Sistem Informasi Akademik<br>SMK Hang Tuah 1 Jakarta
                </p>

                {{-- INFO STEPS --}}
                <div class="space-y-3">
                    @foreach([
                        ['mail',  'Cek email kamu',      'Kami kirim link reset ke email terdaftar'],
                        ['link',  'Klik link di email',  'Link berlaku selama 60 menit setelah dikirim'],
                        ['lock',  'Buat password baru',  'Masukkan password baru yang aman'],
                    ] as [$icon, $title, $desc])
                    <div class="glass-feature flex items-start gap-3 rounded-2xl px-4 py-3.5">
                        <div class="w-8 h-8 bg-white/15 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i data-lucide="{{ $icon }}" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white/90">{{ $title }}</p>
                            <p class="text-xs text-white/50 mt-0.5">{{ $desc }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- PANEL KANAN — FORM --}}
        <div class="flex-1 flex flex-col items-center justify-center px-6 py-12">

            {{-- LOGO MOBILE --}}
            <div class="lg:hidden text-center mb-8">
                <div class="glass-card w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-3 overflow-hidden">
                    <img src="{{ asset('loho-sekolah.png') }}" alt="Logo"
                         class="w-full h-full object-contain"
                         onerror="this.style.display='none'">
                </div>
                <p class="font-bold text-white text-sm">SIAKAD HTONE</p>
                <p class="text-xs text-white/50">SMK Hang Tuah 1 Jakarta</p>
            </div>

            {{-- FORM CARD --}}
            <div class="glass-card rounded-3xl p-8 w-full max-w-sm">

                {{-- JUDUL --}}
                <div class="mb-7">
                    <h2 class="text-2xl font-extrabold text-white tracking-tight">Lupa password?</h2>
                    <p class="text-sm text-white/50 mt-1">
                        Masukkan email kamu, kami akan kirim link reset password.
                    </p>
                </div>

                {{-- STATUS SUCCESS --}}
                @if(session('status'))
                    <div class="success-glass text-emerald-200 px-4 py-3 rounded-2xl
                                flex items-center gap-3 text-sm mb-5">
                        <i data-lucide="check-circle" class="w-4 h-4 flex-shrink-0 text-emerald-300"></i>
                        {{ session('status') }}
                    </div>
                @endif

                {{-- ERROR --}}
                @if($errors->any())
                    <div class="error-glass text-red-200 px-4 py-3 rounded-2xl
                                flex items-center gap-3 text-sm mb-5">
                        <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0 text-red-300"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- FORM --}}
                <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                    @csrf

                    {{-- EMAIL --}}
                    <div>
                        <label class="block text-xs font-semibold text-white/70 mb-1.5 uppercase tracking-wide">
                            Email
                        </label>
                        <div class="relative">
                            <i data-lucide="mail" class="absolute left-3.5 top-1/2 -translate-y-1/2
                                                          text-white/40 w-4 h-4 pointer-events-none"></i>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   required autofocus
                                   placeholder="contoh@email.com"
                                   class="glass-input w-full pl-10 pr-4 py-2.5 rounded-xl text-sm">
                        </div>
                    </div>

                    {{-- SUBMIT --}}
                    <button type="submit"
                            class="glass-btn w-full py-3 rounded-2xl text-sm mt-1">
                        Kirim link reset
                    </button>

                </form>

                {{-- KEMBALI --}}
                <div class="mt-5 text-center">
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-1.5 text-xs font-semibold
                              text-white/50 hover:text-white/80 transition">
                        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                        Kembali ke halaman login
                    </a>
                </div>

                {{-- FOOTER --}}
                <p class="text-center text-xs text-white/30 mt-6">
                    © {{ date('Y') }} SMK Hang Tuah 1 Jakarta
                </p>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();
    });
    </script>

</body>
</html>