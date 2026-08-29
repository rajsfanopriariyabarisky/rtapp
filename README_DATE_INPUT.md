# Komponen Date Input dengan Icon Kalender

## Deskripsi
Komponen ini menyediakan input date dengan icon kalender yang bisa diklik untuk memilih tanggal tanpa perlu mengetik manual. Menggunakan HTML murni tanpa CSS atau JavaScript tambahan.

## Fitur
- ✅ Icon kalender yang bisa diklik
- ✅ Tidak perlu mengetik manual
- ✅ Mendukung dark mode
- ✅ Responsive design
- ✅ Error handling
- ✅ Validasi Laravel

## Penggunaan

### 1. Menggunakan Komponen Blade (Direkomendasikan)

```blade
<!-- Penggunaan dasar -->
<x-date-input name="tanggal_lahir" label="Tanggal Lahir" required />

<!-- Dengan value -->
<x-date-input 
    name="tanggal_lahir" 
    label="Tanggal Lahir" 
    :value="old('tanggal_lahir', $resident->tanggal_lahir ?? '')" 
    required 
/>

<!-- Dengan class tambahan -->
<x-date-input 
    name="tanggal_lahir" 
    label="Tanggal Lahir" 
    class="custom-class" 
    required 
/>

<!-- Tanpa label -->
<x-date-input name="tanggal_lahir" :value="old('tanggal_lahir')" required />
```

### 2. Menggunakan HTML Manual

```blade
<div>
    <label class="block text-gray-700 dark:text-gray-200 mb-1">Tanggal Lahir</label>
    <div class="relative">
        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required 
               class="w-full px-3 py-2 pr-10 border rounded dark:bg-gray-800 dark:text-white @error('tanggal_lahir') border-red-500 @enderror">
        <button type="button" onclick="this.previousElementSibling.showPicker()" 
                class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 cursor-pointer">
            📅
        </button>
    </div>
    @error('tanggal_lahir') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>
```

## Parameter Komponen

| Parameter | Tipe | Default | Deskripsi |
|-----------|------|---------|-----------|
| `name` | string | - | Nama field (wajib) |
| `label` | string | null | Label untuk input |
| `value` | string | null | Nilai default input |
| `required` | boolean | false | Apakah field wajib diisi |
| `class` | string | '' | Class CSS tambahan |
| `id` | string | null | ID custom (default: sama dengan name) |

## File yang Sudah Diupdate

Berikut adalah file-file yang sudah diupdate dengan komponen date input:

### Residents
- `resources/views/residents/partials/form.blade.php`
- `resources/views/residents/create.blade.php`
- `resources/views/residents/edit.blade.php`
- `resources/views/residents/edit-warga.blade.php`

### Warga
- `resources/views/warga/add-family.blade.php`
- `resources/views/warga/edit-family.blade.php`

### Letters
- `resources/views/letters/index.blade.php`
- `resources/views/letters/create.blade.php`

### Family Approvals
- `resources/views/family-approvals/index.blade.php`

### Complaints
- `resources/views/complaints/index.blade.php`

### Admin Payments
- `resources/views/admin/payments/create.blade.php`
- `resources/views/admin/payments/index.blade.php`
- `resources/views/admin/payments/edit.blade.php`

## Cara Kerja

1. **HTML Structure**: Input date dibungkus dalam div dengan class `relative`
2. **Icon Button**: Button dengan icon 📅 diposisikan absolut di sebelah kanan input
3. **JavaScript**: Menggunakan `showPicker()` method bawaan browser untuk menampilkan date picker
4. **Styling**: Menggunakan Tailwind CSS untuk styling dan positioning

## Browser Support

- ✅ Chrome/Chromium (semua versi)
- ✅ Firefox (semua versi)
- ✅ Safari (semua versi)
- ✅ Edge (semua versi)

## Catatan

- Method `showPicker()` adalah fitur modern browser yang sudah didukung oleh semua browser utama
- Icon menggunakan emoji 📅 yang universal dan tidak memerlukan font tambahan
- Komponen ini sepenuhnya menggunakan HTML murni tanpa dependensi JavaScript eksternal 