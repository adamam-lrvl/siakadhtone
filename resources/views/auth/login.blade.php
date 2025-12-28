<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIAKAD HTONE</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://rsms.me/inter/inter.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* ANIMASI HALUS */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeInUp .6s ease-out forwards; }

        /* CARD */
        .card-login {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.06);
        }

        /* BUTTON MORPH HOVER */
        .btn-morph {
            transition: all .25s ease;
        }

        .btn-morph:hover {
            border-radius: 2rem;     /* MELENGKUNG SAAT HOVER */
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(99,102,241,0.25);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center px-6">

    <div class="w-full max-w-md fade-up">

        <!-- Logo Title -->
        <div class="text-center mb-8">
            <div class="mx-auto w-20 h-20 rounded-3xl bg-transparant-600 flex items-center justify-center shadow-lg">
                <img src="{{ asset('loho-sekolah.png') }}" alt="Logo" class="w-full h-full object-cover">
            </div>

            <h1 class="mt-4 text-3xl font-extrabold text-gray-900">
                SIAKAD HTONE
            </h1>

            <p class="text-gray-500 mt-1 text-sm">Sistem Informasi Akademik SMK HANG TUAH 1 JAKARTA</p>
        </div>

        <!-- CARD -->
        <div class="card-login rounded-2xl p-8 fade-up">

            <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">
                Masuk ke Akun Anda
            </h2>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label class="text-gray-700 font-medium flex items-center gap-2 mb-2">
                        <i data-lucide="mail" class="w-4 h-4 text-indigo-500"></i>
                        Email
                    </label>
                    <input type="email" name="email" required
                        class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-300 text-gray-800
                        focus:ring-2 focus:ring-indigo-400 focus:bg-white transition"
                        placeholder="example@gmail.com">
                </div>

                <!-- Password -->
                <div>
                    <label class="text-gray-700 font-medium flex items-center gap-2 mb-2">
                        <i data-lucide="lock" class="w-4 h-4 text-indigo-500"></i>
                        Password
                    </label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-300 text-gray-800
                        focus:ring-2 focus:ring-indigo-400 focus:bg-white transition"
                        placeholder="••••••••">
                </div>

                <!-- Remember + Forgot -->
                <div class="flex items-center justify-between text-gray-600 text-sm">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded text-indigo-600 border-gray-300">
                        Ingat saya
                    </label>

                    <a href="{{ route('password.request') }}" class="text-indigo-600 hover:text-indigo-500 underline">
                        Lupa password?
                    </a>
                </div>

                <!-- Login Button -->
                <button type="submit"
                    class="btn-morph w-full py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 
                    text-white font-semibold transition-all">
                    MASUK
                </button>

            </form>

            <!-- Footer -->
            <p class="text-center text-gray-400 mt-8 text-sm">
                © {{ date('Y') }} SIAKAD HTONE — All rights reserved.
            </p>
        </div>
    </div>

    <script> lucide.createIcons(); </script>
</body>
</html>
