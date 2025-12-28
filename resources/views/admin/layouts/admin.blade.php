{{-- resources/views/admin/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SIAKAD Admin</title>

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

  
    <aside id="sidebar" 
        class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-600 to-blue-700 
               text-white shadow-2xl transform -translate-x-full lg:translate-x-0 lg:static 
               transition-transform duration-300 ease-in-out">

        <div class="p-6 flex items-center space-x-3 border-b border-blue-800">
            <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center overflow-hidden">
                <img src="{{ asset('loho-sekolah.png') }}" alt="Logo Sekolah" class="w-full h-full object-contain">
            </div>
            <h1 class="text-xl font-bold">SIAKAD HT ONE</h1>
        </div>

        <nav class="mt-8 space-y-2 px-4 pb-32 overflow-y-auto no-scrollbar h-[calc(100vh-160px)]">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-800' : 'hover:bg-blue-800/70' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span class="ml-4 font-medium">Dashboard</span>
            </a>
            <a href="{{ route('admin.guru.index') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.guru.*') ? 'bg-blue-800' : 'hover:bg-blue-800/70' }}">
                <i data-lucide="users" class="w-5 h-5"></i>
                <span class="ml-4 font-medium">Guru</span>
            </a>
            <a href="{{ route('admin.siswa.index') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.siswa.*') ? 'bg-blue-800' : 'hover:bg-blue-800/70' }}">
                <i data-lucide="user-check" class="w-5 h-5"></i>
                <span class="ml-4 font-medium">Siswa</span>
            </a>
            <a href="{{ route('admin.kelas.index') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.kelas.*') ? 'bg-blue-800' : 'hover:bg-blue-800/70' }}">
                <i data-lucide="school" class="w-5 h-5"></i>
                <span class="ml-4 font-medium">Kelas</span>
            </a>
            <a href="{{ route('admin.mapel.index') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.mapel.*') ? 'bg-blue-800' : 'hover:bg-blue-800/70' }}">
                <i data-lucide="book-open" class="w-5 h-5"></i>
                <span class="ml-4 font-medium">Mata Pelajaran</span>
            </a>
            <a href="{{ route('admin.jadwal.index') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.jadwal.*') ? 'bg-blue-800' : 'hover:bg-blue-800/70' }}">
                <i data-lucide="calendar-clock" class="w-5 h-5"></i>
                <span class="ml-4 font-medium">Jam Pelajaran</span>
            </a>
            <a href="{{ route('admin.pengumuman.index') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.pengumuman.*') ? 'bg-blue-800' : 'hover:bg-blue-800/70' }}">
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

    <!-- OVERLAY -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-60 z-40 hidden lg:hidden"></div>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col">

        <!-- HEADER — CUMA GANTI AVATAR JADI BISA DIKLIK -->
        <header class="bg-white shadow-md border-b px-5 py-4 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center space-x-4">
                <button id="toggleSidebar" class="p-2.5 rounded-lg bg-blue-100 hover:bg-blue-200 transition lg:hidden">
                    <i data-lucide="menu" class="w-6 h-6 text-blue-600"></i>
                </button>
                <h2 class="text-xl md:text-2xl font-bold text-gray-800">@yield('title')</h2>
            </div>

            <!-- KLIK DI SINI BUKA MODAL PROFIL -->
            <button id="userDropdown" class="flex items-center space-x-4 group">
                <span class="hidden sm:block text-sm font-medium text-gray-600">
                    Hi, <strong>{{ Auth::user()->name }}</strong>
                </span>
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg ring-4 ring-white group-hover:ring-indigo-200 transition-all">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
            </button>
        </header>

        <!-- CONTENT -->
        <main class="flex-1 p-5 md:p-8 overflow-y-auto bg-gray-50">
            @yield('content')
        </main>
    </div>
</div>

<!-- MODAL PROFIL — CANTIK BANGET, BISA EDIT SEMUA -->
<div id="profilModal" class="fixed inset-0 bg-black bg-opacity-60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-screen overflow-y-auto">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-8 text-white rounded-t-3xl">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-bold">Profil Pengguna</h3>
                <button onclick="closeModal()" class="p-2 hover:bg-white/20 rounded-xl transition">
                    <i data-lucide="x" class="w-7 h-7"></i>
                </button>
            </div>
        </div>

        <div class="p-8">
            <div class="text-center mb-8">
                <div class="w-32 h-32 mx-auto bg-gradient-to-br from-indigo-500 to-purple-600 rounded-3xl flex items-center justify-center text-white text-5xl font-black shadow-2xl">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <h4 class="text-3xl font-bold text-gray-900 mt-5">{{ Auth::user()->name }}</h4>
                <p class="text-indigo-600 text-lg">{{ Auth::user()->email }}</p>
            </div>

                    <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}" required 
                        class="w-full px-5 py-4 border-2 border-gray-200 rounded-2xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ Auth::user()->email }}" required 
                        class="w-full px-5 py-4 border-2 border-gray-200 rounded-2xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">No. HP</label>
                    <input type="text" name="no_hp" value="{{ Auth::user()->no_hp ?? '' }}" 
                        placeholder="08123456789"
                        class="w-full px-5 py-4 border-2 border-gray-200 rounded-2xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Alamat</label>
                    <input type="text" name="alamat" value="{{ Auth::user()->alamat ?? '' }}" 
                        placeholder="Masukkan alamat lengkap"
                        class="w-full px-5 py-4 border-2 border-gray-200 rounded-2xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                </div>
            </div>

            <div class="flex gap-4 justify-end pt-6">
                <button type="button" onclick="closeModal()" 
                        class="px-8 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-2xl transition">
                    Batal
                </button>
                <button type="submit" 
                        class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-700 hover:from-indigo-700 hover:to-purple-800 text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
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

    toggleBtn?.addEventListener("click", () => {
        sidebar.classList.toggle("-translate-x-full");
        overlay.classList.toggle("hidden");
    });

    overlay?.addEventListener("click", () => {
        sidebar.classList.add("-translate-x-full");
        overlay.classList.add("hidden");
    });

    // Modal profil
    const userDropdown = document.getElementById("userDropdown");
    const profilModal = document.getElementById("profilModal");

    window.closeModal = () => profilModal.classList.add("hidden");

    userDropdown?.addEventListener("click", () => {
        profilModal.classList.remove("hidden");
    });

    profilModal?.addEventListener("click", (e) => {
        if (e.target === profilModal) closeModal();
    });
});

// =======================
// SWEETALERT DELETE GLOBAL (INDIGO / MAPEL STYLE)
// =======================
document.addEventListener("click", function (e) {
    const deleteButton = e.target.closest(".btn-delete");
    if (!deleteButton) return;

    e.preventDefault();
    const form = deleteButton.closest("form");

    Swal.fire({
        title: "Hapus Data?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,

        // 🔵 BIRU INDIGO (BUKAN MERAH)
        confirmButtonColor: "#4f46e5", // indigo-600
        cancelButtonColor: "#9ca3af",  // gray-400

        confirmButtonText: "Ya, hapus",
        cancelButtonText: "Batal",
        customClass: { popup: "rounded-2xl" }
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});
</script>


@stack('scripts')

{{-- SWEETALERT SUCCESS --}}
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: "{{ session('success') }}",
    timer: 2000,
    showConfirmButton: false,
    customClass: { popup: 'rounded-2xl' }
});
</script>
@endif

{{-- SWEETALERT ERROR --}}
@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: "{{ session('error') }}",
    customClass: { popup: 'rounded-2xl' }
});
</script>
@endif


</body>
</html>