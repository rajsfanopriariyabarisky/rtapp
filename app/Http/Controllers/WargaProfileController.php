<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Letter;
use App\Models\Complaint;
use App\Models\Payment;

class WargaProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'checkStatus', 'role:warga']);
    }

    /**
     * Menampilkan halaman profil warga
     */
    public function index()
    {
        $user = Auth::user();
        $resident = $user->resident;

        // Statistik aktivitas
        $stats = [
            'total_surat' => 0,
            'surat_disetujui' => 0,
            'surat_ditolak' => 0,
            'surat_menunggu' => 0,
            'total_pengaduan' => 0,
            'pengaduan_selesai' => 0,
            'total_pembayaran' => 0,
            'pembayaran_lunas' => 0,
        ];

        if ($resident) {
            // Statistik surat
            $letters = Letter::where('resident_id', $resident->id);
            $stats['total_surat'] = $letters->count();
            $stats['surat_disetujui'] = $letters->where('status', 'Disetujui')->count();
            $stats['surat_ditolak'] = $letters->where('status', 'Ditolak')->count();
            $stats['surat_menunggu'] = $letters->where('status', 'Menunggu')->count();

            // Statistik pengaduan
            $complaints = Complaint::where('resident_id', $resident->id);
            $stats['total_pengaduan'] = $complaints->count();
            $stats['pengaduan_selesai'] = $complaints->where('status', 'Selesai')->count();

            // Statistik pembayaran
            $payments = Payment::where('user_id', $user->id);
            $stats['total_pembayaran'] = $payments->count();
            $stats['pembayaran_lunas'] = $payments->where('status', 'Lunas')->count();
        }

        // Riwayat aktivitas terbaru
        $recentActivities = collect();

        if ($resident) {
            // Surat terbaru
            $recentLetters = Letter::where('resident_id', $resident->id)
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($letter) {
                    return [
                        'type' => 'surat',
                        'title' => $letter->jenis_surat,
                        'description' => $letter->keterangan,
                        'status' => $letter->status,
                        'date' => $letter->created_at,
                        'icon' => 'fa-envelope'
                    ];
                });

            // Pengaduan terbaru
            $recentComplaints = Complaint::where('resident_id', $resident->id)
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($complaint) {
                    return [
                        'type' => 'pengaduan',
                        'title' => 'Pengaduan: ' . $complaint->judul,
                        'description' => $complaint->isi,
                        'status' => $complaint->status,
                        'date' => $complaint->created_at,
                        'icon' => 'fa-comments'
                    ];
                });

            $recentActivities = $recentLetters->merge($recentComplaints)
                ->sortByDesc('date')
                ->take(10);
        }

        return view('warga.profile', compact('user', 'resident', 'stats', 'recentActivities'));
    }

    /**
     * Menampilkan form edit profil
     */
    public function edit()
    {
        $user = Auth::user();
        return view('warga.edit-profile', compact('user'));
    }

    /**
     * Update data profil
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        return redirect()->route('warga.profile.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Menampilkan form ganti password
     */
    public function changePassword()
    {
        return view('warga.change-password');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('warga.profile.index')
            ->with('success', 'Password berhasil diubah.');
    }
} 