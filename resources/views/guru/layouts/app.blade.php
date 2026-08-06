{{-- resources/views/guru/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SIAKAD Guru</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        (function() {
            if (localStorage.getItem('guruDarkMode') === 'true') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <style>
        .no-scrollbar::-webkit-scrollbar { width: 0px; background: transparent; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        ::-webkit-scrollbar { width: 0px; background: transparent; }
        * { -ms-overflow-style: none; scrollbar-width: none; }

        .toggle-track {
            width: 40px; height: 22px; background: #e5e7eb;
            border-radius: 99px; position: relative;
            transition: background .2s; cursor: pointer; flex-shrink: 0;
        }
        .dark .toggle-track { background: #4f46e5; }
        .toggle-thumb {
            position: absolute; top: 3px; left: 3px;
            width: 16px; height: 16px; background: #fff;
            border-radius: 50%; transition: transform .2s;
            box-shadow: 0 1px 3px rgba(0,0,0,.2);
        }
        .dark .toggle-thumb { transform: translateX(18px); }

        .dark #sidebar {
            background: rgba(15,20,50,0.18) !important;
            backdrop-filter: blur(80px) saturate(2.5) brightness(1.15) !important;
            -webkit-backdrop-filter: blur(80px) saturate(2.5) brightness(1.15) !important;
            border-right: 1px solid rgba(255,255,255,0.10) !important;
        }
        .dark #sidebar::before {
            content: ''; position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 220% 45% at 50% -8%, rgba(99,102,241,0.22) 0%, transparent 65%),
                radial-gradient(ellipse 160% 35% at 115% 100%, rgba(59,130,246,0.13) 0%, transparent 60%);
            pointer-events: none; z-index: 0;
        }
        .dark #sidebar > * { position: relative; z-index: 1; }

        #topbar {
            transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
            background: rgba(255,255,255,0.65) !important;
            backdrop-filter: blur(12px) saturate(150%) !important;
            -webkit-backdrop-filter: blur(12px) saturate(150%) !important;
        }
        .dark #topbar {
            background: rgba(8,12,26,0.55) !important;
            backdrop-filter: blur(12px) saturate(150%) !important;
            -webkit-backdrop-filter: blur(12px) saturate(150%) !important;
        }
        #topbar.scrolled {
            background: rgba(255,255,255,0.88) !important;
            backdrop-filter: blur(24px) saturate(180%) !important;
            box-shadow: 0 4px 24px -4px rgba(0,0,0,0.10);
        }
        .dark #topbar.scrolled {
            background: rgba(8,12,26,0.82) !important;
            backdrop-filter: blur(24px) saturate(180%) !important;
            box-shadow: 0 4px 24px -4px rgba(0,0,0,0.35);
        }
    </style>
</head>

<body class="h-full bg-gray-50 dark:bg-[#080c1a] font-['Inter'] antialiased transition-colors duration-200">

<div class="flex h-screen overflow-hidden">

    {{-- SIDEBAR --}}
    <aside id="sidebar"
           class="fixed inset-y-0 left-0 z-50 w-60
                  bg-white dark:bg-transparent
                  border-r border-gray-200 dark:border-white/[0.07]
                  -translate-x-full lg:translate-x-0
                  transition-transform duration-300 ease-in-out
                  flex flex-col overflow-hidden">

        <div class="flex items-center gap-3 px-5 py-5 border-b border-gray-100 dark:border-white/[0.07]">
            <div class="w-9 h-9 bg-blue-600 dark:bg-white/10 dark:border dark:border-white/15 rounded-xl
                        flex items-center justify-center overflow-hidden flex-shrink-0">
                <img src="{{ asset('loho-sekolah.png') }}" alt="Logo" class="w-full h-full object-contain"
                     onerror="this.style.display='none'; this.parentElement.innerHTML='<span class=\'text-white font-bold text-sm\'>S</span>'">
            </div>
            <div class="min-w-0">
                <p class="font-bold text-gray-900 dark:text-white text-sm leading-tight">SIAKAD HT ONE</p>
                <p class="text-xs text-gray-400 dark:text-white/40">Guru</p>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto no-scrollbar px-3 py-4 space-y-0.5">

            <p class="text-xs font-semibold text-gray-400 dark:text-white/25 uppercase tracking-wider px-3 mb-2">Menu</p>

            <a href="{{ route('guru.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                      {{ request()->routeIs('guru.dashboard')
                          ? 'bg-blue-50 dark:bg-indigo-500/20 dark:border dark:border-indigo-400/25 text-blue-700 dark:text-white'
                          : 'text-gray-600 dark:text-white/50 hover:bg-gray-100 dark:hover:bg-white/[0.08] hover:text-gray-900 dark:hover:text-white' }}">
                <i data-lucide="layout-dashboard" class="w-4 h-4 flex-shrink-0"></i>
                Dashboard
            </a>

            <p class="text-xs font-semibold text-gray-400 dark:text-white/25 uppercase tracking-wider px-3 pt-4 mb-2">Akademik</p>

            <a href="{{ route('guru.absensi.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                      {{ request()->routeIs('guru.absensi.*')
                          ? 'bg-blue-50 dark:bg-indigo-500/20 dark:border dark:border-indigo-400/25 text-blue-700 dark:text-white'
                          : 'text-gray-600 dark:text-white/50 hover:bg-gray-100 dark:hover:bg-white/[0.08] hover:text-gray-900 dark:hover:text-white' }}">
                <i data-lucide="check-square" class="w-4 h-4 flex-shrink-0"></i>
                Absensi
            </a>

            <a href="{{ route('guru.nilai.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                      {{ request()->routeIs('guru.nilai.*')
                          ? 'bg-blue-50 dark:bg-indigo-500/20 dark:border dark:border-indigo-400/25 text-blue-700 dark:text-white'
                          : 'text-gray-600 dark:text-white/50 hover:bg-gray-100 dark:hover:bg-white/[0.08] hover:text-gray-900 dark:hover:text-white' }}">
                <i data-lucide="edit-3" class="w-4 h-4 flex-shrink-0"></i>
                Input nilai
            </a>

        </nav>

        <div class="border-t border-gray-100 dark:border-white/[0.07] p-3">
            <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-gray-50 dark:bg-white/[0.07]
                        border border-gray-200 dark:border-white/[0.08] mb-1">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full
                            flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400 dark:text-white/40 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="button" id="logout-btn"
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium
                               text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10
                               hover:text-red-600 dark:hover:text-red-300 transition">
                    <i data-lucide="log-out" class="w-4 h-4 flex-shrink-0"></i>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div id="overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden lg:pl-60">

        <header id="topbar"
                class="border-b border-gray-200/50 dark:border-white/[0.08]
                       px-5 py-3.5 flex items-center justify-between
                       fixed top-0 right-0 left-0 z-30">
            <div class="flex items-center gap-3">
                <button id="toggleSidebar"
                        class="p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-white/10 transition lg:hidden">
                    <i data-lucide="menu" class="w-5 h-5 text-gray-600 dark:text-gray-400"></i>
                </button>
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">@yield('title')</h2>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2">
                    <i data-lucide="sun" class="w-3.5 h-3.5 text-amber-500 dark:text-gray-500"></i>
                    <button id="darkToggle" class="toggle-track" title="Toggle dark mode">
                        <div class="toggle-thumb"></div>
                    </button>
                    <i data-lucide="moon" class="w-3.5 h-3.5 text-gray-400 dark:text-indigo-400"></i>
                </div>
                <span class="hidden sm:block text-sm text-gray-500 dark:text-gray-400">
                    Hi, <span class="font-semibold text-gray-800 dark:text-gray-100">{{ Auth::user()->name }}</span>
                </span>
                <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full
                            flex items-center justify-center text-white font-bold text-sm">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto pt-[57px] pb-6 px-5 md:px-8 bg-gray-50 dark:bg-[#080c1a] transition-colors duration-200">
            @yield('content')
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();

    document.getElementById('darkToggle')?.addEventListener('click', () => {
        var isDark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('guruDarkMode', isDark);
    });

    var topbar = document.getElementById('topbar');
    var mainEl = document.querySelector('main');
    if (topbar && mainEl) {
        mainEl.addEventListener('scroll', function() {
            topbar.classList.toggle('scrolled', mainEl.scrollTop > 20);
        });
    }

    var sidebar   = document.getElementById('sidebar');
    var overlay   = document.getElementById('overlay');
    var toggleBtn = document.getElementById('toggleSidebar');
    toggleBtn?.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    });
    overlay?.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });

    document.getElementById('logout-btn')?.addEventListener('click', () => {
        Swal.fire({
            title: 'Keluar dari sistem?',
            html: '<span class="text-gray-500 text-sm">Sesi kamu akan diakhiri.</span>',
            iconHtml: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#1d4ed8" width="52" height="52"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5-5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>',
            showCancelButton: true, confirmButtonText: 'Ya, keluar', cancelButtonText: 'Batal', reverseButtons: true,
            customClass: { popup: 'rounded-2xl shadow-xl border border-blue-100', title: 'text-gray-900 font-bold text-lg', htmlContainer: 'text-gray-500 text-sm', confirmButton: 'bg-blue-700 hover:bg-blue-800 text-white font-semibold text-sm px-5 py-2.5 rounded-xl', cancelButton: 'bg-white border border-gray-200 text-gray-700 font-semibold text-sm px-5 py-2.5 rounded-xl', icon: 'border-0 bg-blue-50 rounded-2xl' },
            buttonsStyling: false,
        }).then(r => { if (r.isConfirmed) document.getElementById('logout-form').submit(); });
    });

    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            var nama = this.dataset.name ?? 'data ini';
            Swal.fire({
                title: 'Hapus data?',
                html: '<span class="text-gray-500 text-sm">Data <strong class="text-gray-800">' + nama + '</strong> akan dihapus permanen.</span>',
                iconHtml: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#dc2626" width="52" height="52"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>',
                showCancelButton: true, confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal', reverseButtons: true,
                customClass: { popup: 'rounded-2xl shadow-xl border border-red-100', title: 'text-gray-900 font-bold text-lg', htmlContainer: 'text-gray-500 text-sm', confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-semibold text-sm px-5 py-2.5 rounded-xl', cancelButton: 'bg-white border border-gray-200 text-gray-700 font-semibold text-sm px-5 py-2.5 rounded-xl', icon: 'border-0 bg-red-50 rounded-2xl' },
                buttonsStyling: false,
            }).then(r => { if (r.isConfirmed) form.submit(); });
        });
    });
});
</script>

@stack('scripts')

@if(session('success'))
<script>
Swal.fire({
    title: 'Berhasil!', html: '<span class="text-gray-500 text-sm">{{ session("success") }}</span>',
    iconHtml: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#16a34a" width="52" height="52"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>',
    timer: 2500, timerProgressBar: true, showConfirmButton: false,
    customClass: { popup: 'rounded-2xl shadow-xl border border-emerald-100', title: 'text-gray-900 font-bold text-lg', icon: 'border-0 bg-emerald-50 rounded-2xl' },
    buttonsStyling: false,
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    title: 'Gagal!', html: '<span class="text-gray-500 text-sm">{{ session("error") }}</span>',
    iconHtml: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#dc2626" width="52" height="52"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>',
    showConfirmButton: true, confirmButtonText: 'Tutup',
    customClass: { popup: 'rounded-2xl shadow-xl border border-red-100', title: 'text-gray-900 font-bold text-lg', confirmButton: 'bg-red-600 text-white font-semibold text-sm px-5 py-2.5 rounded-xl', icon: 'border-0 bg-red-50 rounded-2xl' },
    buttonsStyling: false,
});
</script>
@endif

</body>
</html>