@extends('layouts.app')

@section('content')
@php
    $dir = $direction === 'asc' ? 'desc' : 'asc';
@endphp
<div
  class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6"
>
  <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
      <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
        Daftar Akun Aktif
      </h3>
    </div>

    <div class="flex items-center gap-3">
      <form method="GET" action="{{ route('users.active') }}" class="flex gap-3 items-center">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama/email..."
                class="rounded-lg border-gray-300 px-3 py-2 text-sm dark:bg-gray-800 dark:text-white dark:border-gray-600"
            />

            <select
                name="role"
                class="rounded-lg border-gray-300 px-3 py-2 text-sm dark:bg-gray-800 dark:text-white dark:border-gray-600"
            >
                <option value="all" {{ request('role') == 'all' ? 'selected' : '' }}>Semua Role</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="rt" {{ request('role') == 'rt' ? 'selected' : '' }}>RT</option>
                <option value="rw" {{ request('role') == 'rw' ? 'selected' : '' }}>RW</option>
                <option value="warga" {{ request('role') == 'warga' ? 'selected' : '' }}>Warga</option>
            </select>

            <button
                type="submit"
                class="px-4 py-2 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600"
            >
                Cari
            </button>
        </form>
      <div class="flex gap-3">
        <a href="{{ route('users.export.pdf', request()->query()) }}"
            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 text-sm">
            Export PDF
        </a>

        <a href="{{ route('users.export.excel', request()->query()) }}"
            class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 text-sm">
            Export Excel
        </a>
    </div>

    </div>
  </div>

  <div class="w-full overflow-x-auto">
    <table class="min-w-full">
      <thead>
        <tr class="border-gray-100 border-y dark:border-gray-800">
          <th class="py-3">
            <a class="font-medium text-gray-500 text-theme-xs dark:text-gray-400"
            href="{{ route('users.active', array_merge(request()->all(), ['sort' => 'nama', 'direction' => $dir])) }}">
                Nama @if($sort == 'nama') {!! $direction === 'asc' ? '↑' : '↓' !!} @endif
            </a>
            </th>
            <th class="py-3">
            <a class="font-medium text-gray-500 text-theme-xs dark:text-gray-400"
            href="{{ route('users.active', array_merge(request()->all(), ['sort' => 'email', 'direction' => $dir])) }}">
                Email @if($sort == 'email') {!! $direction === 'asc' ? '↑' : '↓' !!} @endif
            </a>
            </th>
            <th class="py-3">
            <a class="font-medium text-gray-500 text-theme-xs dark:text-gray-400"
            href="{{ route('users.active', array_merge(request()->all(), ['sort' => 'role', 'direction' => $dir])) }}">
                Role @if($sort == 'role') {!! $direction === 'asc' ? '↑' : '↓' !!} @endif
            </a>
            </th>
          <th class="py-3">
            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Tanggal Daftar</p>
          </th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
        @forelse ($users as $user)
        <tr>
          <td class="py-3">
            <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
              {{ $user->nama }}
            </p>
          </td>
          <td class="py-3">
            <p class="text-gray-500 text-theme-sm dark:text-gray-400">
              {{ $user->email }}
            </p>
          </td>
          <td class="py-3">
            <p class="text-gray-500 text-theme-sm dark:text-gray-400">
              {{ ucfirst($user->role) }}
            </p>
          </td>
          <td class="py-3">
            <p class="text-gray-500 text-theme-sm dark:text-gray-400">
              {{ $user->created_at->format('d M Y') }}
            </p>
          </td>
          <td class="py-3">
            <div class="flex gap-2">
                <a href="{{ route('users.edit', $user->id) }}"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition rounded-lg bg-yellow-500 shadow hover:bg-yellow-600">
                Edit
                </a>

                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition rounded-lg bg-red-500 shadow hover:bg-red-600">
                    Hapus
                </button>
                </form>
            </div>
            </td>
        </tr>
        @empty
        <tr>
          <td colspan="4" class="py-3 text-center text-gray-500 dark:text-gray-400">
            Tidak ada data akun aktif.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
<div class="mt-4">
    {{ $users->links() }}
</div>
@endsection
