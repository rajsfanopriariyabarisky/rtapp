<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Resident;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->role === 'warga') {
            $resident = Resident::where('user_id', $user->id)->first();
            $query = Complaint::where('resident_id', $resident ? $resident->id : 0);
        } elseif ($user->role === 'rt') {
            $query = Complaint::with('resident');
        } else {
            $query = Complaint::with('resident');
        }

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('isi', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
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

        $complaints = $query->get();

        // Data untuk dropdown filter
        $statusList = ['Diterima', 'Diproses', 'Selesai'];

        if ($user->role === 'warga') {
            return view('complaints.index', compact('complaints', 'statusList', 'sort', 'direction'))->with('route', '/complainat');
        } elseif ($user->role === 'rt') {
            return view('complaints.index', compact('complaints', 'statusList', 'sort', 'direction'))->with('route', 'rt/complaint');
        } else {
            return view('complaints.index', compact('complaints', 'statusList', 'sort', 'direction'));
        }
    }

    public function create()
    {
        $residents = Resident::all();
        return view('complaints.create', compact('residents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $resident = Resident::where('user_id', auth()->id())->first();
        if (!$resident) {
            return back()->with('error', 'Data warga tidak ditemukan. Silakan lengkapi data diri Anda.');
        }

        $data = $request->only('judul', 'isi');
        $data['resident_id'] = $resident->id;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('complaints', 'public');
        }

        Complaint::create($data);

        return redirect()->route('complaints.index')->with('success', 'Laporan berhasil dikirim.');
    }

    public function edit($id)
    {
        $complaint = Complaint::findOrFail($id);
        return view('complaints.edit', compact('complaint'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Selesai,Diterima,Ditolak',
            'tanggapan' => 'nullable|string|max:1000',
        ]);

        $complaint = Complaint::findOrFail($id);
        $complaint->status = $request->status;
        $complaint->tanggapan = $request->tanggapan;
        $complaint->ditanggapi_oleh = auth()->id();
        $complaint->tanggal_tanggapan= now();
        $complaint->save();

        return redirect('rt/complaints')->with('success', 'Pengaduan berhasil ditanggapi.');
    }

    public function show(Complaint $complaint)
    {
        $complaint->load([
            'resident.user',        // The resident and their user account
            'ditanggapiOleh',       // The user who responded (RT/RW)
        ]);
        return view('complaints.show', compact('complaint'));
    }
}

