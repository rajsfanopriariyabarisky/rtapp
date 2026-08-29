<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem RT/RW</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo dan Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 rounded-full mb-4">
                <i class="fas fa-home text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Selamat Datang</h1>
            <p class="text-gray-600 dark:text-gray-400">Masuk ke akun Anda</p>
        </div>

        <!-- Card Login -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                        <span class="text-red-700 dark:text-red-400 text-sm">{{ $errors->first() }}</span>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}" class="space-y-6">
                @csrf
                
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-envelope mr-2"></i>Email
                    </label>
                    <input type="email" 
                           id="email"
                           name="email" 
                           required 
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition duration-200"
                           placeholder="Masukkan email Anda">
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-lock mr-2"></i>Password
                    </label>
                    <input type="password" 
                           id="password"
                           name="password" 
                           required 
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition duration-200"
                           placeholder="Masukkan password Anda">
                </div>

                <!-- Login Button -->
                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Masuk
                </button>
            </form>

            <!-- Divider -->
            <div class="my-6 flex items-center">
                <div class="flex-1 border-t border-gray-300 dark:border-gray-600"></div>
                <span class="px-4 text-sm text-gray-500 dark:text-gray-400">atau</span>
                <div class="flex-1 border-t border-gray-300 dark:border-gray-600"></div>
            </div>

            <!-- Register Link -->
            <div class="text-center">
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium transition duration-200">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-gray-500 dark:text-gray-400 text-sm">
                © 2024 Sistem RT/RW. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
