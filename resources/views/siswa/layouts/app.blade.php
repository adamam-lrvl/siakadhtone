<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SIAKAD Siswa</title>

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

<div class="flex h-screen">

    <!-- SIDEBAR SISWA — 100% SAMA KAYAK ADMIN (BIRU-INDIGO) -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-600 to-blue-700 text-white shadow-2xl transform -translate-x-full lg:translate-x-0 lg:static lg:z-auto transition-transform duration-300 ease-in-out">
        <div class="p-6 flex items-center space-x-3 border-b border-blue-800">
            <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center overflow-hidden">
                <img src="{{ asset('loho-sekolah.png') }}" alt="Logo Sekolah" class="w-full h-full object-contain">
            </div>
            <h1 class="text-xl font-bold">SIAKAD HT ONE</h1>
        </div>

        <nav class="mt-8 space-y-2 px-4 pb-32 overflow-y-auto no-scrollbar h-[calc(100vh-160px)]">
            <a href="{{ route('siswa.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('siswa.dashboard') ? 'bg-blue-800' : 'hover:bg-blue-800/70' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span class="ml-4 font-medium">Dashboard</span>
            </a>
            <a href="{{ route('siswa.jadwal.index') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('siswa.jadwal.*') ? 'bg-blue-800' : 'hover:bg-blue-800/70' }}">
                <i data-lucide="calendar-days" class="w-5 h-5"></i>
                <span class="ml-4 font-medium">Jadwal Pelajaran</span>
            </a>
            <a href="{{ route('siswa.absensi.index') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('siswa.absensi.*') ? 'bg-blue-800' : 'hover:bg-blue-800/70' }}">
                <i data-lucide="check-square" class="w-5 h-5"></i>
                <span class="ml-4 font-medium">Absensi</span>
            </a>
            <a href="{{ route('siswa.nilai.rekap') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('siswa.nilai.*') ? 'bg-blue-800' : 'hover:bg-blue-800/70' }}">
                <i data-lucide="trending-up" class="w-5 h-5"></i>
                <span class="ml-4 font-medium">Nilai Saya</span>
            </a>
            <a href="{{ route('siswa.pengumuman.index') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('siswa.pengumuman.*') ? 'bg-blue-800' : 'hover:bg-blue-800/70' }}">
                <i data-lucide="megaphone" class="w-5 h-5"></i>
                <span class="ml-4 font-medium">Pengumuman</span>
            </a>
        </nav>

        <div class="absolute bottom-0 w-full p-4 border-t border-blue-800 bg-blue-700/40 backdrop-blur">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-3 rounded-lg hover:bg-blue-800/70 transition">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    <span class="ml-4 text-sm font-medium">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- OVERLAY MOBILE -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-60 z-40 hidden lg:hidden"></div>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col lg:ml-0">
        <header class="bg-white shadow-md border-b px-5 py-4 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center space-x-4">
                <button id="toggleSidebar" class="p-2.5 rounded-lg bg-blue-100 hover:bg-blue-200 transition lg:hidden">
                    <i data-lucide="menu" class="w-6 h-6 text-blue-600"></i>
                </button>
                <h2 class="text-xl md:text-2xl font-bold text-gray-800">@yield('title')</h2>
            </div>
            <div class="flex items-center space-x-4">
                <span class="hidden sm:block text-sm font-medium text-gray-600">
                    Hi, <strong>{{ Auth::user()->siswa->nama }}</strong>
                </span>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i data-lucide="user" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </header>

        <main class="flex-1 p-5 md:p-8 overflow-y-auto bg-gray-50">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-5 py-3 rounded-xl mb-6 flex items-center shadow-sm">
                    <i data-lucide="check-circle" class="w-6 h-6 mr-3"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-5 py-3 rounded-xl mb-6 flex items-center shadow-sm">
                    <i data-lucide="alert-circle" class="w-6 h-6 mr-3"></i>
                    {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>

<!-- MODAL PROFIL SISWA — SAMA KAYAK ADMIN -->
<div id="profilModal" class="fixed inset-0 bg-black bg-opacity-60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-screen overflow-y-auto">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-8 text-white rounded-t-3xl">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-bold">Profil Siswa</h3>
                <button onclick="closeModal()" class="p-2 hover:bg-white/20 rounded-xl transition">
                    <i data-lucide="x" class="w-7 h-7"></i>
                </button>
            </div>
        </div>

        <div class="p-8">
            <div class="text-center mb-8">
                <div class="w-32 h-32 mx-auto bg-gradient-to-br from-indigo-500 to-purple-600 rounded-3xl flex items-center justify-center text-white text-5xl font-black shadow-2xl">
                    {{ strtoupper(substr(Auth::user()->siswa->nama, 0, 2)) }}
                </div>
                <h4 class="text-3xl font-bold text-gray-900 mt-5">{{ Auth::user()->siswa->nama }}</h4>
                <p class="text-indigo-600 text-lg">NIS: {{ Auth::user()->siswa->nis ?? '-' }}</p>
                <p class="text-purple-600">Kelas: {{ Auth::user()->siswa->kelas->nama_kelas ?? '-' }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                <div>
                    <p class="text-gray-600 font-medium">Email Login</p>
                    <p class="font-bold text-gray-900">{{ Auth::user()->email }}</p>
                </div>
                <div>
                    <p class="text-gray-600 font-medium">Jenis Kelamin</p>
                    <p class="font-bold text-gray-900">{{ Auth::user()->siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                </div>
                <div>
                    <p class="text-gray-600 font-medium">Tanggal Lahir</p>
                    <p class="font-bold text-gray-900">{{ Auth::user()->siswa->tanggal_lahir ? Auth::user()->siswa->tanggal_lahir->format('d F Y') : '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-600 font-medium">Telepon</p>
                    <p class="font-bold text-gray-900">{{ Auth::user()->siswa->telepon ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-600 font-medium">Telepon Wali</p>
                    <p class="font-bold text-gray-900">{{ Auth::user()->siswa->telepon_wali ?? '-' }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-gray-600 font-medium">Alamat</p>
                    <p class="font-bold text-gray-900">{{ Auth::user()->siswa->alamat ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    lucide.createIcons();

    // Sidebar toggle
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");
    const toggleBtn = document.getElementById("toggleSidebar");

    toggleBtn.addEventListener("click", () => {
        sidebar.classList.toggle("-translate-x-full");
        overlay.classList.toggle("hidden");
    });

    overlay.addEventListener("click", () => {
        sidebar.classList.add("-translate-x-full");
        overlay.classList.add("hidden");
    });

    // Modal profil
    const userDropdown = document.getElementById("userDropdown");
    const profilModal = document.getElementById("profilModal");

    window.closeModal = () => profilModal.classList.add("hidden");

    userDropdown.addEventListener("click", () => {
        profilModal.classList.remove("hidden");
    });

    profilModal.addEventListener("click", (e) => {
        if (e.target === profilModal) closeModal();
    });
});

// SweetAlert delete global
document.addEventListener("click", function (e) {
    const deleteButton = e.target.closest(".btn-delete");
    if (!deleteButton) return;
    e.preventDefault();
    let form = deleteButton.closest("form");

    Swal.fire({
        title: "Hapus Data?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal",
        customClass: { popup: "rounded-xl" }
    }).then((result) => {
        if (result.isConfirmed) form.submit();
    });
});
</script>

@stack('scripts')
</body>
</html>