<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FamilyApproval;
use App\Models\Resident;
use Illuminate\Support\Facades\Auth;

class FamilyApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'checkStatus']);
    }

    /**
     * Menampilkan daftar pengajuan anggota keluarga untuk RT
     */
    public function index(Request $request)
    {
        $this->middleware('role:rt');
        
        $query = FamilyApproval::with('user');

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('nik', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function ($userQuery) use ($request) {
                      $userQuery->where('nama', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan hubungan keluarga
        if ($request->filled('hubungan') && $request->hubungan !== 'all') {
            $query->where('hubungan_keluarga', $request->hubungan);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->where('created_at', '>=', $request->tanggal_mulai . ' 00:00:00');
        }

        if ($request->filled('tanggal_akhir')) {
            $query->where('created_at', '<=', $request->tanggal_akhir . ' 23:59:59');
        }

        // Sorting
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        $approvals = $query->paginate(10);

        // Data untuk dropdown filter
        $statusList = ['Menunggu', 'Disetujui', 'Ditolak'];
        $hubunganList = ['Suami', 'Istri', 'Anak', 'Orang Tua', 'Saudara', 'Lainnya'];

        return view('family-approvals.index', compact('approvals', 'statusList', 'hubunganList', 'sort', 'direction'));
    }

    /**
     * Menampilkan detail pengajuan
     */
    public function show(FamilyApproval $familyApproval)
    {
        $this->middleware('role:rt');
        
        return view('family-approvals.show', compact('familyApproval'));
    }

    /**
     * Menyetujui pengajuan anggota keluarga
     */
    public function approve(Request $request, FamilyApproval $familyApproval)
    {
        $this->middleware('role:rt');
        
        $request->validate([
            'alasan' => 'nullable|string|max:500'
        ]);

        // CEK DULU APAKAH NIK SUDAH ADA
        if (\App\Models\Resident::where('nik', $familyApproval->nik)->exists()) {
            return redirect()->back()->with('error', 'NIK sudah terdaftar di data warga.');
        }

        // Buat data resident baru
        $resident = new Resident([
            'nik' => $familyApproval->nik,
            'nama_lengkap' => $familyApproval->nama_lengkap,
            'tempat_lahir' => $familyApproval->tempat_lahir,
            'tanggal_lahir' => $familyApproval->tanggal_lahir,
            'jenis_kelamin' => $familyApproval->jenis_kelamin,
            'agama' => $familyApproval->agama,
            'pekerjaan' => $familyApproval->pekerjaan,
            'status_perkawinan' => $familyApproval->status_perkawinan,
            'status_tinggal' => $familyApproval->status_tinggal,
            'alamat' => $familyApproval->alamat,
            'rt' => $familyApproval->rt,
            'rw' => $familyApproval->rw,
            'telepon' => $familyApproval->telepon,
            'email' => $familyApproval->email,
            'user_id' => $familyApproval->user_id,
            'hubungan_keluarga' => $familyApproval->hubungan_keluarga,
        ]);

        $resident->save();

        // Update status approval
        $familyApproval->approve(Auth::id(), $request->alasan);

        return redirect()->route('family-approvals.index')
            ->with('success', 'Pengajuan anggota keluarga berhasil disetujui.');
    }

    /**
     * Menolak pengajuan anggota keluarga
     */
    public function reject(Request $request, FamilyApproval $familyApproval)
    {
        $this->middleware('role:rt');
        
        $request->validate([
            'alasan' => 'required|string|max:500'
        ]);

        $familyApproval->reject(Auth::id(), $request->alasan);

        return redirect()->route('family-approvals.index')
            ->with('success', 'Pengajuan anggota keluarga berhasil ditolak.');
    }

    /**
     * Menampilkan daftar pengajuan untuk warga
     */
    public function myApprovals()
    {
        $this->middleware('role:warga');
        
        $approvals = FamilyApproval::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('family-approvals.my-approvals', compact('approvals'));
    }

    /**
     * Menghapus pengajuan yang masih pending
     */
    public function destroy(FamilyApproval $familyApproval)
    {
        // Hanya bisa menghapus pengajuan milik sendiri yang masih pending
        if ($familyApproval->user_id !== Auth::id() || !$familyApproval->isPending()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus pengajuan ini.');
        }

        $familyApproval->delete();

        return redirect()->route('family-approvals.my-approvals')
            ->with('success', 'Pengajuan berhasil dihapus.');
    }
}
