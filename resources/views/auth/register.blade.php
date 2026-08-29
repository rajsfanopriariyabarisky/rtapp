<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Register - RT/RW Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-blue-600 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-home text-white text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Daftar Akun
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Buat akun baru untuk mengakses sistem RT/RW
                </p>
            </div>

            <!-- Register Form -->
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nama Lengkap
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input 
                                id="nama" 
                                name="nama" 
                                type="text" 
                                required 
                                value="{{ old('nama') }}"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Masukkan nama lengkap"
                            >
                        </div>
                        @error('nama')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input 
                                id="email" 
                                name="email" 
                                type="email" 
                                required 
                                value="{{ old('email') }}"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Masukkan email"
                            >
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input 
                                id="password" 
                                name="password" 
                                type="password" 
                                required 
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Minimal 8 karakter"
                            >
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Konfirmasi Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                type="password" 
                                required 
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Ulangi password"
                            >
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Pilih Role
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-users text-gray-400"></i>
                            </div>
                            <select 
                                id="role" 
                                name="role" 
                                required 
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                            >
                                <option value="">Pilih role</option>
                                <option value="warga" {{ old('role') == 'warga' ? 'selected' : '' }}>Warga</option>
                                <option value="rt" {{ old('role') == 'rt' ? 'selected' : '' }}>RT</option>
                                <option value="rw" {{ old('role') == 'rw' ? 'selected' : '' }}>RW</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="flex items-center">
                        <input 
                            id="terms" 
                            name="terms" 
                            type="checkbox" 
                            required 
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                        >
                        <label for="terms" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                            Saya setuju dengan 
                            <a href="#" class="text-blue-600 hover:text-blue-500">Syarat & Ketentuan</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button 
                            type="submit" 
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200"
                        >
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <i class="fas fa-user-plus text-blue-500 group-hover:text-blue-400"></i>
                            </span>
                            Daftar Akun
                        </button>
                    </div>

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                                        Terdapat kesalahan dalam pendaftaran
                                    </h3>
                                    <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </form>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500 transition duration-200">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center">
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    © 2024 RT/RW Management System. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <!-- Dark Mode Toggle -->
    <div class="fixed top-4 right-4">
        <button 
            id="darkModeToggle"
            class="p-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-200"
        >
            <i class="fas fa-moon dark:hidden"></i>
            <i class="fas fa-sun hidden dark:block"></i>
        </button>
    </div>

    <script>
        // Dark mode toggle functionality
        const darkModeToggle = document.getElementById('darkModeToggle');
        const html = document.documentElement;
        
        // Check for saved dark mode preference
        const darkMode = localStorage.getItem('darkMode');
        if (darkMode === 'true') {
            html.classList.add('dark');
        }
        
        darkModeToggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            localStorage.setItem('darkMode', html.classList.contains('dark'));
        });
    </script>
</body>
</html>

