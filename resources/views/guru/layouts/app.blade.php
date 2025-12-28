<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SIAKAD Guru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body class="h-full bg-gray-50 font-['Inter'] antialiased">

<div class="flex h-screen">
    
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-600 to-blue-700 text-white shadow-2xl transform -translate-x-full lg:translate-x-0 lg:static lg:z-auto transition-transform duration-300 ease-in-out">
            <div class="p-6 flex items-center space-x-3 border-b border-blue-800">
                <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('loho-sekolah.png') }}" 
                        alt="Logo Sekolah" class="w-full h-full object-contain">
                </div>
            <h1 class="text-xl font-bold">SIAKAD HT ONE</h1>
        </div>

        <nav class="mt-8 space-y-2 px-4">
            <a href="{{ route('guru.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-white transition {{ request()->routeIs('guru.dashboard') ? 'bg-blue-800' : 'hover:bg-blue-800/70' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span class="ml-4 font-medium">Dashboard</span>
            </a>
            <a href="{{ route('guru.absensi.index') }}" class="flex items-center px-4 py-3 rounded-lg text-white transition {{ request()->routeIs('guru.absensi.*') ? 'bg-blue-800' : 'hover:bg-blue-800/70' }}">
                <i data-lucide="check-square" class="w-5 h-5"></i>
                <span class="ml-4 font-medium">Absensi</span>
            </a>
            <a href="{{ route('guru.nilai.index') }}" class="flex items-center px-4 py-3 rounded-lg text-white transition {{ request()->routeIs('guru.nilai.*') ? 'bg-blue-800' : 'hover:bg-blue-800/70' }}">
                <i data-lucide="edit-3" class="w-5 h-5"></i>
                <span class="ml-4 font-medium">Input Nilai</span>
            </a>
        </nav>

        <div class="absolute bottom-0 w-full p-4 border-t border-blue-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-3 rounded-lg hover:bg-blue-800/70 transition">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    <span class="ml-4 text-sm font-medium">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- OVERLAY — HANYA DI HP -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-60 z-40 hidden lg:hidden"></div>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col lg:ml-0">
        <header class="bg-white shadow-md border-b border-gray-200 px-5 py-4 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center space-x-4">
                <!-- HAMBURGER — HANYA MUNCUL DI HP -->
                <button id="toggleSidebar" class="p-2.5 rounded-lg bg-blue-100 hover:bg-blue-200 transition lg:hidden">
                    <i data-lucide="menu" class="w-6 h-6 text-blue-600"></i>
                </button>
                <h2 class="text-xl md:text-2xl font-bold text-gray-800">@yield('title')</h2>
            </div>
            <div class="flex items-center space-x-4">
                <span class="hidden sm:block text-sm font-medium text-gray-600">Hi, <strong>{{ Auth::user()->name }}</strong></span>
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <i data-lucide="user" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </header>

        <main class="flex-1 p-5 md:p-8 overflow-y-auto bg-gray-50">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-5 py-3 rounded-xl mb-6 flex items-center">
                    <i data-lucide="check-circle" class="w-6 h-6 mr-3"></i>
                    {{ session('success') }}
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

        toggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("-translate-x-full");
            overlay.classList.toggle("hidden");
        });

        overlay.addEventListener("click", () => {
            sidebar.classList.add("-translate-x-full");
            overlay.classList.add("hidden");
        });
    });
</script>
</body>
</html> 