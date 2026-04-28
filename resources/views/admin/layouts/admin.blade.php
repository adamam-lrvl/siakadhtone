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
                <p class="text-xs text-gray-400">Admin Panel</p>
            </div>
        </div>

        {{-- NAV --}}
        <nav class="flex-1 overflow-y-auto no-scrollbar px-3 py-4 space-y-0.5">

            {{-- LABEL SEKSI --}}
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">Menu</p>

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                      {{ request()->routeIs('admin.dashboard')
                          ? 'bg-blue-50 text-blue-700'
                          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <i data-lucide="layout-dashboard" class="w-4 h-4 flex-shrink-0"></i>
                Dashboard
            </a>

            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-4 mb-2">Data Master</p>

            <a href="{{ route('admin.guru.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                      {{ request()->routeIs('admin.guru.*')
                          ? 'bg-blue-50 text-blue-700'
                          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <i data-lucide="users" class="w-4 h-4 flex-shrink-0"></i>
                Guru
            </a>

            <a href="{{ route('admin.siswa.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                      {{ request()->routeIs('admin.siswa.*')
                          ? 'bg-blue-50 text-blue-700'
                          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <i data-lucide="user-check" class="w-4 h-4 flex-shrink-0"></i>
                Siswa
            </a>

            <a href="{{ route('admin.kelas.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                      {{ request()->routeIs('admin.kelas.*')
                          ? 'bg-blue-50 text-blue-700'
                          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <i data-lucide="school" class="w-4 h-4 flex-shrink-0"></i>
                Kelas
            </a>

            <a href="{{ route('admin.mapel.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                      {{ request()->routeIs('admin.mapel.*')
                          ? 'bg-blue-50 text-blue-700'
                          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <i data-lucide="book-open" class="w-4 h-4 flex-shrink-0"></i>
                Mata pelajaran
            </a>

            <a href="{{ route('admin.jadwal.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                      {{ request()->routeIs('admin.jadwal.*')
                          ? 'bg-blue-50 text-blue-700'
                          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <i data-lucide="calendar-clock" class="w-4 h-4 flex-shrink-0"></i>
                Jadwal pelajaran
            </a>

            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-4 mb-2">Lainnya</p>

            <a href="{{ route('admin.pengumuman.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                      {{ request()->routeIs('admin.pengumuman.*')
                          ? 'bg-blue-50 text-blue-700'
                          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <i data-lucide="megaphone" class="w-4 h-4 flex-shrink-0"></i>
                Pengumuman
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
                <button id="userDropdown" class="p-1 hover:bg-gray-200 rounded-lg transition flex-shrink-0"
                        title="Edit profil">
                    <i data-lucide="settings" class="w-3.5 h-3.5 text-gray-400"></i>
                </button>
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
    <div id="overlay"
         class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

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

            {{-- TOPBAR KANAN --}}
            <div class="flex items-center gap-2">
                <span class="hidden sm:block text-sm text-gray-500">
                    Hi, <span class="font-semibold text-gray-800">{{ Auth::user()->name }}</span>
                </span>
                <button id="userDropdownTop"
                        class="w-9 h-9 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full
                               flex items-center justify-center text-white font-bold text-sm
                               hover:opacity-90 transition">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </button>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="flex-1 overflow-y-auto p-5 md:p-8 bg-gray-50">
            @yield('content')
        </main>
    </div>
</div>

{{-- MODAL PROFIL --}}
<div id="profilModal"
     class="fixed inset-0 bg-black/60 z-50 hidden items-center justify-center p-4"
     style="display: none;">
    <div class="bg-white rounded-2xl w-full max-w-lg overflow-hidden">

        {{-- HEADER MODAL --}}
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-5 text-white">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold">Profil pengguna</h3>
                <button onclick="closeModal()"
                        class="p-1.5 hover:bg-white/20 rounded-lg transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
        </div>

        {{-- BODY MODAL --}}
        <div class="p-6">
            {{-- AVATAR --}}
            <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl
                            flex items-center justify-center text-white font-bold text-xl flex-shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div>
                    <p class="font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                    <p class="text-sm text-gray-400">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Nama lengkap</label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" required
                               class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" required
                               class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">No. HP</label>
                        <input type="text" name="no_hp" value="{{ Auth::user()->no_hp ?? '' }}"
                               placeholder="08123456789"
                               class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Alamat</label>
                        <input type="text" name="alamat" value="{{ Auth::user()->alamat ?? '' }}"
                               placeholder="Alamat lengkap"
                               class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                </div>

                <div class="flex gap-3 justify-end pt-2">
                    <button type="button" onclick="closeModal()"
                            class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold
                                   text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600
                                   hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl
                                   text-sm font-semibold shadow-sm hover:shadow-md transition">
                        Simpan perubahan
                    </button>
                </div>
            </form>
        </div>
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

    const profilModal = document.getElementById("profilModal");

    window.closeModal = () => {
        profilModal.style.display = "none";
    };

    const openModal = () => {
        profilModal.style.display = "flex";
        lucide.createIcons();
    };

    document.getElementById("userDropdown")?.addEventListener("click", openModal);
    document.getElementById("userDropdownTop")?.addEventListener("click", openModal);

    profilModal?.addEventListener("click", (e) => {
        if (e.target === profilModal) closeModal();
    });
});

document.addEventListener("click", function(e) {
    const deleteButton = e.target.closest(".btn-delete");
    if (!deleteButton) return;
    e.preventDefault();
    const form = deleteButton.closest("form");
    Swal.fire({
        title: "Hapus Data?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#2563eb",
        cancelButtonColor: "#9ca3af",
        confirmButtonText: "Ya, hapus",
        cancelButtonText: "Batal",
        customClass: { popup: "rounded-2xl" }
    }).then((result) => {
        if (result.isConfirmed) form.submit();
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