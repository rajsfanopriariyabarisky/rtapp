<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\Letter;
use App\Models\Complaint;
use App\Models\Payment;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            // Statistik pengguna untuk admin
            $totalUsers = User::count();
            $pendingUsers = User::where('status_akun', 'pending')->count();
            $approvedUsers = User::where('status_akun', 'disetujui')->count();
            $rejectedUsers = User::where('status_akun', 'ditolak')->count();
            
            // Statistik bulanan
            $currentMonth = now()->format('m');
            $currentYear = now()->format('Y');
            $usersThisMonth = User::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)->count();
            
            // Data terbaru untuk ditampilkan
            $recentUsers = User::latest()->take(5)->get();
            
            return view('admin.dashboard', compact(
                'totalUsers', 'pendingUsers', 'approvedUsers', 'rejectedUsers',
                'recentUsers', 'usersThisMonth'
            ));
        }

        if ($user->role === 'rt') {
            // Statistik pengaduan
            $totalComplaints = Complaint::count();
            $pendingComplaints = Complaint::where('status', 'Diterima')->count();
            $processingComplaints = Complaint::where('status', 'Diproses')->count();
            $completedComplaints = Complaint::where('status', 'Selesai')->count();
            
            // Statistik surat
            $totalLetters = Letter::count();
            $approvedLetters = Letter::where('status', 'Disetujui')->count();
            $rejectedLetters = Letter::where('status', 'Ditolak')->count();
            $pendingLetters = Letter::where('status', 'Menunggu')->count();
            
            // Statistik warga
            $totalResidents = Resident::count();
            $maleResidents = Resident::where('jenis_kelamin', 'L')->count();
            $femaleResidents = Resident::where('jenis_kelamin', 'P')->count();
            
            // Data terbaru untuk ditampilkan
            $recentComplaints = Complaint::with('resident.user')->latest()->take(5)->get();
            $recentLetters = Letter::with('resident.user')->latest()->take(5)->get();
            $recentResidents = Resident::latest()->take(5)->get();
            
            // Statistik bulanan
            $currentMonth = now()->format('m');
            $currentYear = now()->format('Y');
            $complaintsThisMonth = Complaint::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)->count();
            $lettersThisMonth = Letter::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)->count();
            
            return view('rt.dashboard', compact(
                'totalComplaints', 'pendingComplaints', 'processingComplaints', 'completedComplaints',
                'totalLetters', 'approvedLetters', 'rejectedLetters', 'pendingLetters',
                'totalResidents', 'maleResidents', 'femaleResidents',
                'recentComplaints', 'recentLetters', 'recentResidents',
                'complaintsThisMonth', 'lettersThisMonth'
            ));
        }

        if ($user->role === 'rw') {
            return view('rw.dashboard', [
                'totalResidents' => Resident::count(),
            ]);
        }

        if ($user->role === 'warga') {
            $resident = $user->resident;

            // Data kosong default
            $letters = collect();
            $familyMembers = collect();
            $jumlahSurat = 0;
            $jumlahKeluarga = 0;
            $jumlahPengaduan = 0;

            if ($resident) {
                // Ambil data surat warga
                $letters = Letter::where('resident_id', $resident->id)
                    ->latest()
                    ->take(5)
                    ->get();
                $jumlahSurat = Letter::where('resident_id', $resident->id)->count();

                // Ambil data keluarga
                $familyMembers = Resident::where('user_id', $user->id)
                    ->where('id', '!=', $resident->id)
                    ->latest()
                    ->take(5)
                    ->get();
                $jumlahKeluarga = Resident::where('user_id', $user->id)->count();

                // Ambil data pengaduan
                $jumlahPengaduan = Complaint::where('resident_id', $resident->id)->count();
            }

            return view('warga.dashboard', compact(
                'letters', 'familyMembers', 'jumlahSurat', 'jumlahKeluarga', 'jumlahPengaduan'
            ));
        }

        // Default fallback
        return view('dashboard.index');
    }

    public function statistikPengaduan()
    {
        $total = Complaint::count();
        $menunggu = Complaint::where('status', 'Menunggu')->count();
        $diproses = Complaint::where('status', 'Diproses')->count();
        $selesai = Complaint::where('status', 'Selesai')->count();

        return view('rt.dashboard', compact('total', 'menunggu', 'diproses', 'selesai'));
    }
}

