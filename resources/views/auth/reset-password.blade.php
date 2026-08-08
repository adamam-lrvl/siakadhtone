<!DOCTYPE html>
<html lang="id" class="h-full bg-gradient-to-br from-indigo-50 via-white to-teal-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SIAKAD HTONE</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://rsms.me/inter/inter.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <style>
        .top-bar {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        }
        .btn-submit {
            background: #10b981;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            background: #059669;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.4);
        }
        .card-form {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="h-full font-sans antialiased flex items-center justify-center p-6">
    <div class="w-full max-w-md">

        <!-- TOP BAR -->
        <div class="top-bar text-white p-4 rounded-t-xl shadow-lg flex items-center justify-center space-x-3">
            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-indigo-600 font-bold text-xl shadow-md">
                S
            </div>
            <h1 class="text-xl font-bold">SIAKAD HTONE</h1>
        </div>

        <!-- CARD -->
        <div class="card-form rounded-b-xl rounded-t-none p-8 border border-gray-200">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800">Reset Password</h2>
                <p class="text-gray-600 mt-1">Masukkan password baru Anda</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
		    @error('email')
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-600 text-sm">
            {{ $message }}
        </div>
    @enderror
                <!-- EMAIL -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ request()->email }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                           readonly>
                </div>

                <!-- PASSWORD BARU -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center space-x-2">
                        <x-icon name="lock" class="w-4 h-4 text-gray-500" />
                        <span>Password Baru</span>
                    </label>
                    <input id="password" type="password" name="password" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                           placeholder="Masukkan password baru">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- KONFIRMASI PASSWORD -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center space-x-2">
                        <x-icon name="lock" class="w-4 h-4 text-gray-500" />
                        <span>Konfirmasi Password</span>
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                           placeholder="Ulangi password baru">
                </div>

                <button type="submit"
                        class="w-full btn-submit text-white font-medium py-3 rounded-lg flex items-center justify-center space-x-2 shadow-lg">
                    <x-icon name="check" class="w-5 h-5" />
                    <span>RESET PASSWORD</span>
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm text-emerald-600 hover:text-emerald-700 underline flex items-center justify-center space-x-1">
                    <x-icon name="arrow-left" class="w-4 h-4" />
                    <span>Kembali ke Login</span>
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
</body>
</html>
