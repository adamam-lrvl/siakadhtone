<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAKAD HTONE</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://rsms.me/inter/inter.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* Soft card for announcements */
        .soft-card {
            background: white;
            border-radius: 1rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            transition: .25s ease;
        }
        .soft-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 35px rgba(0,0,0,0.08);
        }

        /* Smooth login button */
        .btn-morph {
            transition: .25s ease;
        }
        .btn-morph:hover {
            border-radius: 2rem;
            transform: translateY(-2px);
            box-shadow: 0 12px 20px rgba(99,102,241,.25);
        }

        /* Fade animation */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(25px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp .7s ease-out forwards; }
    </style>
</head>

<body class="min-h-screen flex flex-col">

    <!-- NAVBAR -->
    <header class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl shadow overflow-hidden">
                    <img src="{{ asset('loho-sekolah.png') }}" alt="Logo" class="w-full h-full object-cover">
                </div>
                <h1 class="text-2xl font-bold text-gray-900">SIAKAD HTONE</h1>
            </div>

            <a href="{{ route('login') }}"
               class="btn-morph px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium shadow">
                Login
            </a>
        </div>
    </header>

    <!-- HERO -->
    <section class="text-center py-20 px-6 fade-up">
        <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight tracking-tight">
            Sistem Informasi Akademik <span class="text-indigo-600">SMK HANG TUAH 1</span>
        </h2>

        <p class="mt-4 text-gray-600 text-lg max-w-2xl mx-auto leading-relaxed">
            Platform akademik yang dirancang untuk kemudahan, kecepatan, dan efisiensi
            dalam pengelolaan data sekolah
        </p>
    </section>

    <!-- PENGUMUMAN -->
    <section class="max-w-7xl mx-auto px-6 pb-20 fade-up">
        <h3 class="text-2xl font-bold text-gray-900 mb-8 flex items-center gap-2">
            <i data-lucide="megaphone" class="w-6 h-6 text-indigo-600"></i>
            Pengumuman Terbaru
        </h3>

        @if($pengumuman->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($pengumuman as $p)
                <div class="soft-card p-6">
                    <div class="flex justify-between items-start">
                        <h4 class="text-gray-900 font-semibold text-lg leading-snug">
                            {{ $p->judul }}
                        </h4>
                        <span class="text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded-lg">
                            {{ $p->created_at->format('d M') }}
                        </span>
                    </div>

                    <p class="text-gray-600 mt-3 text-sm leading-relaxed">
                        {!! Str::limit(strip_tags($p->isi), 120) !!}
                    </p>

                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <a href="#" class="text-indigo-600 text-sm font-medium hover:text-indigo-700 flex items-center gap-1">
                            Baca selengkapnya
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="soft-card p-12 text-center">
                <i data-lucide="inbox" class="w-14 h-14 text-gray-400 mx-auto mb-3"></i>
                <p class="text-gray-500 text-lg">Belum ada pengumuman.</p>
            </div>
        @endif
    </section>

    <!-- FOOTER -->
    <footer class="text-center text-gray-500 text-sm py-10 border-t bg-gray-50">
        © {{ date('Y') }} SIAKAD HTONE — All rights reserved.
    </footer>

    <script> lucide.createIcons(); </script>

</body>
</html>
