@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
  <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Edit Akun</h2>

  <form method="POST" action="{{ route('users.update', $user->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-4">
      <label class="block text-sm text-gray-700 dark:text-gray-300">Nama</label>
      <input type="text" name="nama" value="{{ old('nama', $user->nama) }}"
        class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white" required>
    </div>

    <div class="mb-4">
      <label class="block text-sm text-gray-700 dark:text-gray-300">Email</label>
      <input type="email" name="email" value="{{ old('email', $user->email) }}"
        class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white" required>
    </div>

    <div class="mb-4">
      <label class="block text-sm text-gray-700 dark:text-gray-300">Role</label>
      <select name="role" class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white">
        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="rt" {{ $user->role === 'rt' ? 'selected' : '' }}>RT</option>
        <option value="rw" {{ $user->role === 'rw' ? 'selected' : '' }}>RW</option>
        <option value="warga" {{ $user->role === 'warga' ? 'selected' : '' }}>Warga</option>
      </select>
    </div>

    <div class="flex justify-end gap-2">
      <a href="{{ route('users.active') }}"
        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Kembali</a>
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
    </div>
  </form>
</div>
@endsection
