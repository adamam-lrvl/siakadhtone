<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAKAD HTONE</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>

<body class="min-h-screen bg-gray-50 font-['Inter'] antialiased flex flex-col">

    {{-- NAVBAR glass effect --}}
    <header class="fixed top-0 left-0 right-0 z-30 bg-white/10 backdrop-blur-md border-b border-white/20 transition-all duration-300" id="navbar">
        <div class="max-w-5xl mx-auto px-5 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-white/20 rounded-xl overflow-hidden flex-shrink-0 border border-white/30">
                    <img src="{{ asset('loho-sekolah.png') }}" alt="Logo"
                         class="w-full h-full object-contain"
                         onerror="this.style.display='none'">
                </div>
                <div>
                    <p class="font-bold text-white text-sm leading-tight drop-shadow" id="navbar-title">SIAKAD HT ONE</p>
                    <p class="text-xs text-white/70" id="navbar-sub">SMK Hang Tuah 1 Jakarta</p>
                </div>
            </div>
            <a href="{{ route('login') }}"
               class="flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30
                      border border-white/30 text-white text-sm font-semibold rounded-xl
                      transition backdrop-blur-sm" id="navbar-btn">
                <i data-lucide="log-in" class="w-4 h-4"></i>
                Masuk
            </a>
        </div>
    </header>

    {{-- HERO — foto sekolah + overlay --}}
    <section class="relative text-white overflow-hidden pt-16">

        {{-- FOTO SEKOLAH --}}
        <img src="{{ asset('foto-sekolah.jpg') }}"
             alt="SMK Hang Tuah 1 Jakarta"
             class="absolute inset-0 w-full h-full object-cover object-center"
             onerror="this.style.display='none'">

        {{-- OVERLAY gradient gelap biar teks terbaca --}}
        <div class="absolute inset-0 bg-gradient-to-b from-blue-900/75 via-blue-800/65 to-indigo-900/80"></div>

        {{-- CONTENT --}}
        <div class="relative max-w-5xl mx-auto px-5 py-20 md:py-28 text-center">
            <div class="inline-flex items-center gap-2 bg-white/15 border border-white/20
                        px-3 py-1.5 rounded-full text-xs font-semibold mb-6 backdrop-blur-sm">
                Sistem Informasi Akademik
            </div>
            <h1 class="text-3xl md:text-5xl font-bold leading-tight mb-4 drop-shadow-lg">
                Selamat datang di<br>
                <span class="text-blue-200">SMK Hang Tuah 1 Jakarta</span>
            </h1>
            <p class="text-blue-100 text-base md:text-lg max-w-xl mx-auto leading-relaxed drop-shadow">
                Platform akademik untuk kemudahan pengelolaan data absensi, nilai,
                jadwal, dan informasi sekolah.
            </p>

        </div>
    </section>

    {{-- PENGUMUMAN --}}
    <section class="max-w-5xl mx-auto px-5 py-12 flex-1">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i data-lucide="megaphone" class="w-5 h-5 text-blue-600"></i>
                Pengumuman terbaru
            </h2>
        </div>

        @if($pengumuman->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($pengumuman as $p)
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden
                            hover:border-indigo-300 hover:shadow-md transition-all">

                    {{-- GAMBAR --}}
                    @if($p->gambar)
                        <div class="w-full bg-gray-50 flex items-center justify-center overflow-hidden">
                            <img src="{{ asset('storage/' . $p->gambar) }}"
                                 alt="{{ $p->judul }}"
                                 class="w-full h-auto object-contain max-h-48">
                        </div>
                    @else
                        <div class="w-full h-32 bg-gradient-to-br from-blue-50 to-indigo-100
                                    flex items-center justify-center">
                            <i data-lucide="megaphone" class="w-8 h-8 text-indigo-300"></i>
                        </div>
                    @endif

                    {{-- CONTENT --}}
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-3">
                            <span class="inline-flex items-center gap-1.5 text-xs text-gray-400">
                                <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                {{ $p->created_at->translatedFormat('d F Y') }}
                            </span>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs
                                         font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <i data-lucide="circle-dot" class="w-3 h-3"></i>
                                Aktif
                            </span>
                        </div>

                        <h3 class="font-semibold text-gray-900 text-sm leading-snug mb-2">
                            {{ $p->judul }}
                        </h3>

                        <p class="text-xs text-gray-500 leading-relaxed">
                            {!! Str::limit(strip_tags($p->isi), 100) !!}
                        </p>

                        <div class="mt-4 pt-3 border-t border-gray-100">
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center gap-1 text-xs font-semibold
                                      text-blue-600 hover:text-blue-800 transition">
                                Baca selengkapnya
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-white border border-gray-200 rounded-2xl p-16 text-center">
                <div class="bg-gray-50 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                    <i data-lucide="inbox" class="w-7 h-7 text-gray-300"></i>
                </div>
                <p class="text-sm font-medium text-gray-500">Belum ada pengumuman</p>
            </div>
        @endif
    </section>

    {{-- FOOTER --}}
    <footer class="border-t border-gray-200 bg-white">
        <div class="max-w-5xl mx-auto px-5 py-5 flex flex-col sm:flex-row items-center
                    justify-between gap-2 text-xs text-gray-400">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 bg-blue-600 rounded-lg overflow-hidden flex-shrink-0">
                    <img src="{{ asset('loho-sekolah.png') }}" alt="Logo"
                         class="w-full h-full object-contain"
                         onerror="this.style.display='none'">
                </div>
                <span class="font-medium text-gray-600">SIAKAD HT ONE</span>
            </div>
            <p>© {{ date('Y') }} SMK Hang Tuah 1 Jakarta. All rights reserved.</p>
        </div>
    </footer>

    <script>
    // Navbar: glass saat di hero, solid saat scroll ke bawah
    var navbar  = document.getElementById('navbar');
    var btnEl   = document.getElementById('navbar-btn');
    var titleEl = document.getElementById('navbar-title');
    var subEl   = document.getElementById('navbar-sub');
    var heroH   = document.querySelector('section').offsetHeight;

    window.addEventListener('scroll', function() {
        if (window.scrollY > heroH - 80) {
            navbar.classList.remove('bg-white/10', 'border-white/20');
            navbar.classList.add('bg-white', 'border-gray-200', 'shadow-sm');
            titleEl.classList.remove('text-white', 'drop-shadow');
            titleEl.classList.add('text-gray-900');
            subEl.classList.remove('text-white/70');
            subEl.classList.add('text-gray-400');
            btnEl.classList.remove('bg-white/20', 'hover:bg-white/30', 'border-white/30', 'text-white');
            btnEl.classList.add('bg-blue-600', 'hover:bg-blue-700', 'border-transparent', 'text-white');
        } else {
            navbar.classList.add('bg-white/10', 'border-white/20');
            navbar.classList.remove('bg-white', 'border-gray-200', 'shadow-sm');
            titleEl.classList.add('text-white', 'drop-shadow');
            titleEl.classList.remove('text-gray-900');
            subEl.classList.add('text-white/70');
            subEl.classList.remove('text-gray-400');
            btnEl.classList.add('bg-white/20', 'hover:bg-white/30', 'border-white/30', 'text-white');
            btnEl.classList.remove('bg-blue-600', 'hover:bg-blue-700', 'border-transparent');
        }
    });
    lucide.createIcons();
    </script>
</body>
</html>