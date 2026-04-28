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
    <style>
        .no-scrollbar::-webkit-scrollbar { width: 0px; background: transparent; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="h-full bg-gray-50 font-['Inter'] antialiased">

<div class="flex h-screen overflow-hidden">

    {{-- SIDEBAR --}}
    <aside id="sidebar"
           class="fixed inset-y-0 left-0 z-50 w-60 bg-white border-r border-gray-200
                  transform -translate-x-full lg:translate-x-0 lg:static
                  transition-transform duration-300 ease-in-out flex flex-col">

        {{-- LOGO --}}
        <div class="flex items-center gap-3 px-5 py-5 border-b border-gray-100">
            <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center overflow-hidden flex-shrink-0">
                <img src="{{ asset('loho-sekolah.png') }}" alt="Logo"
                     class="w-full h-full object-contain"
                     onerror="this.style.display='none'; this.parentElement.innerHTML='<span class=\'text-white font-bold text-sm\'>S</span>'">
            </div>
            <div class="min-w-0">
                <p class="font-bold text-gray-900 text-sm leading-tight">SIAKAD HT ONE</p>
                <p class="text-xs text-gray-400">Guru</p>
            </div>
        </div>

        {{-- NAV --}}
        <nav class="flex-1 overflow-y-auto no-scrollbar px-3 py-4 space-y-0.5">

            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">Menu</p>

            <a href="{{ route('guru.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                      {{ request()->routeIs('guru.dashboard')
                          ? 'bg-blue-50 text-blue-700'
                          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <i data-lucide="layout-dashboard" class="w-4 h-4 flex-shrink-0"></i>
                Dashboard
            </a>

            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-4 mb-2">Akademik</p>

            <a href="{{ route('guru.absensi.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                      {{ request()->routeIs('guru.absensi.*')
                          ? 'bg-blue-50 text-blue-700'
                          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <i data-lucide="check-square" class="w-4 h-4 flex-shrink-0"></i>
                Absensi
            </a>

            <a href="{{ route('guru.nilai.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                      {{ request()->routeIs('guru.nilai.*')
                          ? 'bg-blue-50 text-blue-700'
                          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <i data-lucide="edit-3" class="w-4 h-4 flex-shrink-0"></i>
                Input nilai
            </a>

        </nav>

        {{-- USER + LOGOUT --}}
        <div class="border-t border-gray-100 p-3">
            <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-gray-50 mb-1">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full
                            flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm
                               font-medium text-red-600 hover:bg-red-50 transition">
                    <i data-lucide="log-out" class="w-4 h-4 flex-shrink-0"></i>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- OVERLAY --}}
    <div id="overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- TOPBAR --}}
        <header class="bg-white border-b border-gray-200 px-5 py-3.5 flex items-center
                       justify-between sticky top-0 z-30 flex-shrink-0">
            <div class="flex items-center gap-3">
                <button id="toggleSidebar"
                        class="p-2 rounded-xl hover:bg-gray-100 transition lg:hidden">
                    <i data-lucide="menu" class="w-5 h-5 text-gray-600"></i>
                </button>
                <h2 class="text-base font-semibold text-gray-900">@yield('title')</h2>
            </div>
            <div class="flex items-center gap-2">
                <span class="hidden sm:block text-sm text-gray-500">
                    Hi, <span class="font-semibold text-gray-800">{{ Auth::user()->name }}</span>
                </span>
                <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full
                            flex items-center justify-center text-white font-bold text-sm">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="flex-1 overflow-y-auto p-5 md:p-8 bg-gray-50">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3
                            rounded-xl flex items-center gap-3 text-sm font-medium mb-6">
                    <i data-lucide="check-circle" class="w-4 h-4 flex-shrink-0"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3
                            rounded-xl flex items-center gap-3 text-sm font-medium mb-6">
                    <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
                    {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    lucide.createIcons();

    const sidebar   = document.getElementById("sidebar");
    const overlay   = document.getElementById("overlay");
    const toggleBtn = document.getElementById("toggleSidebar");

    toggleBtn?.addEventListener("click", () => {
        sidebar.classList.toggle("-translate-x-full");
        overlay.classList.toggle("hidden");
    });

    overlay?.addEventListener("click", () => {
        sidebar.classList.add("-translate-x-full");
        overlay.classList.add("hidden");
    });
});
</script>

@stack('scripts')

@if(session('success'))
<script>
Swal.fire({
    icon: 'success', title: 'Berhasil!',
    text: "{{ session('success') }}",
    timer: 2000, showConfirmButton: false,
    customClass: { popup: 'rounded-2xl' }
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon: 'error', title: 'Gagal!',
    text: "{{ session('error') }}",
    customClass: { popup: 'rounded-2xl' }
});
</script>
@endif

</body>
</html>