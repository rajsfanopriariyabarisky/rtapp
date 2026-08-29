<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\FamilyApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WargaFamilyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'checkStatus', 'role:warga']);
    }

    /**
     * Menampilkan form untuk menambah anggota keluarga
     */
    public function create()
    {
        // Pastikan user sudah memiliki data resident (kepala keluarga)
        if (!Auth::user()->resident) {
            return redirect()->route('residents.create')
                ->with('error', 'Anda harus melengkapi data diri terlebih dahulu sebelum menambahkan anggota keluarga.');
        }

        return view('warga.add-family');
    }

    /**
     * Menyimpan data anggota keluarga baru (menggunakan sistem persetujuan)
     */
    public function store(Request $request)
    {
        // Pastikan user sudah memiliki data resident
        if (!Auth::user()->resident) {
            return redirect()->route('residents.create')
                ->with('error', 'Anda harus melengkapi data diri terlebih dahulu.');
        }

        $request->validate([
            'nik' => 'required|numeric|digits:16|unique:residents|unique:family_approvals',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu,Lainnya',
            'pekerjaan' => 'nullable|string|max:255',
            'status_perkawinan' => 'required|in:Belum Menikah,Menikah,Cerai',
            'status_tinggal' => 'required|in:Tetap,Pindah,Meninggal',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:10',
            'rw' => 'required|string|max:10',
            'telepon' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'hubungan_keluarga' => 'required|in:Kepala Keluarga,Istri,Anak,Saudara,Lainnya',
        ]);

        // Buat pengajuan persetujuan anggota keluarga
        $familyApproval = new FamilyApproval($request->all());
        $familyApproval->user_id = Auth::id();
        $familyApproval->status = 'Menunggu';
        $familyApproval->save();

        return redirect()->route('family-approvals.my-approvals')
            ->with('success', 'Pengajuan anggota keluarga berhasil dikirim. Menunggu persetujuan RT.');
    }

    /**
     * Menampilkan daftar anggota keluarga
     */
    public function index()
    {
        $user = Auth::user();
        
        // Ambil semua resident yang dimiliki oleh user ini (termasuk kepala keluarga)
        $familyMembers = Resident::where('user_id', $user->id)
            ->where('id', '!=', $user->resident->id ?? 0) // Exclude kepala keluarga
            ->orderBy('nama_lengkap')
            ->paginate(10);

        return view('warga.family-list', compact('familyMembers'));
    }

    /**
     * Menampilkan form edit anggota keluarga
     */
    public function edit(Resident $resident)
    {
        // Pastikan resident ini milik user yang sedang login
        if ($resident->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        // Pastikan bukan data kepala keluarga
        if ($resident->id === Auth::user()->resident->id ?? 0) {
            return redirect()->route('residents.edit', $resident->id)
                ->with('error', 'Untuk mengedit data kepala keluarga, gunakan menu edit data diri.');
        }

        return view('warga.edit-family', compact('resident'));
    }

    /**
     * Update data anggota keluarga
     */
    public function update(Request $request, Resident $resident)
    {
        // Pastikan resident ini milik user yang sedang login
        if ($resident->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        // Pastikan bukan data kepala keluarga
        if ($resident->id === Auth::user()->resident->id ?? 0) {
            return redirect()->route('residents.edit', $resident->id)
                ->with('error', 'Untuk mengedit data kepala keluarga, gunakan menu edit data diri.');
        }

        $request->validate([
            'nik' => 'required|numeric|digits:16|unique:residents,nik,' . $resident->id,
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu,Lainnya',
            'pekerjaan' => 'nullable|string|max:255',
            'status_perkawinan' => 'required|in:Belum Menikah,Menikah,Cerai',
            'status_tinggal' => 'required|in:Tetap,Pindah,Meninggal',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:10',
            'rw' => 'required|string|max:10',
            'telepon' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'hubungan_keluarga' => 'required|in:Kepala Keluarga,Istri,Anak,Saudara,Lainnya',
        ]);

        $resident->update($request->all());

        return redirect()->route('warga.family.index')
            ->with('success', 'Data anggota keluarga berhasil diperbarui.');
    }

    /**
     * Hapus data anggota keluarga
     */
    public function destroy(Resident $resident)
    {
        // Pastikan resident ini milik user yang sedang login
        if ($resident->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        // Pastikan bukan data kepala keluarga
        if ($resident->id === Auth::user()->resident->id ?? 0) {
            return redirect()->route('warga.family.index')
                ->with('error', 'Data kepala keluarga tidak dapat dihapus.');
        }

        $resident->delete();

        return redirect()->route('warga.family.index')
            ->with('success', 'Data anggota keluarga berhasil dihapus.');
    }
} 