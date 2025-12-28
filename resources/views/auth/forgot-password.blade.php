<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - SIAKAD HTONE</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://rsms.me/inter/inter.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* ANIMASI HALUS SAMA KAYAK LOGIN */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeInUp .6s ease-out forwards; }

        /* CARD SAMA PERSIS LOGIN */
        .card-form {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.06);
        }

        /* BUTTON MORPH HOVER SAMA PERSIS */
        .btn-morph {
            transition: all .25s ease;
        }

        .btn-morph:hover {
            border-radius: 2rem;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(99,102,241,0.25);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center px-6">

    <div class="w-full max-w-md fade-up">

        <!-- Logo Title SAMA PERSIS LOGIN -->
        <div class="text-center mb-8">
            <div class="mx-auto w-20 h-20 rounded-3xl bg-transparent flex items-center justify-center shadow-lg">
                <img src="{{ asset('loho-sekolah.png') }}" alt="Logo" class="w-full h-full object-cover rounded-3xl">
            </div>

            <h1 class="mt-4 text-3xl font-extrabold text-gray-900">
                SIAKAD HTONE
            </h1>

            <p class="text-gray-500 mt-1 text-sm">Sistem Informasi Akademik SMK HANG TUAH 1 JAKARTA</p>
        </div>

        <!-- CARD FORM SAMA PERSIS LOGIN -->
        <div class="card-form rounded-2xl p-8 fade-up">

            <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">
                Lupa Password?
            </h2>

            <p class="text-center text-gray-600 mb-6 text-sm">
                Masukkan email Anda, kami akan kirim link reset password.
            </p>

            <!-- FLASH MESSAGE -->
            @if (session('status'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label class="text-gray-700 font-medium flex items-center gap-2 mb-2">
                        <i data-lucide="mail" class="w-4 h-4 text-indigo-500"></i>
                        Email
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-300 text-gray-800
                        focus:ring-2 focus:ring-indigo-400 focus:bg-white transition"
                        placeholder="example@gmail.com">

                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button SAMA PERSIS LOGIN -->
                <button type="submit"
                    class="btn-morph w-full py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 
                    text-white font-semibold transition-all">
                    KIRIM LINK RESET
                </button>

            </form>

            <!-- Kembali ke Login -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}"
                   class="text-sm text-indigo-600 hover:text-indigo-500 underline flex items-center justify-center gap-1">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Kembali ke Login
                </a>
            </div>

            <!-- Footer SAMA PERSIS -->
            <p class="text-center text-gray-400 mt-8 text-sm">
                © {{ date('Y') }} SIAKAD HTONE — All rights reserved.
            </p>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>

</body>
</html>