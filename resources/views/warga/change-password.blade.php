@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6">
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Ganti Password</h2>
            <a href="{{ route('warga.profile.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                Kembali ke Profil
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('warga.profile.update-password') }}" class="space-y-6">
            @csrf
            
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Password Saat Ini <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       id="current_password" 
                       name="current_password" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                       placeholder="Masukkan password saat ini"
                       required>
                @error('current_password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Password Baru <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                       placeholder="Masukkan password baru (minimal 8 karakter)"
                       required>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Konfirmasi Password Baru <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                       placeholder="Konfirmasi password baru"
                       required>
            </div>

            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-2">Tips Password yang Aman:</h4>
                <ul class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                    <li>• Minimal 8 karakter</li>
                    <li>• Kombinasikan huruf besar, huruf kecil, angka, dan simbol</li>
                    <li>• Hindari menggunakan informasi pribadi</li>
                    <li>• Jangan gunakan password yang sama dengan akun lain</li>
                </ul>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('warga.profile.index') }}" 
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Ganti Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 