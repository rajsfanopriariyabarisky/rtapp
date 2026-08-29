<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\SuratDitolakMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\SuratDisetujuiMail;



class LetterController extends Controller
{
    public function index(Request $request)
    {
        $query = Letter::with('resident');

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $query->whereHas('resident', function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan jenis surat
        if ($request->filled('jenis_surat') && $request->jenis_surat !== 'all') {
            $query->where('jenis_surat', $request->jenis_surat);
        }

        // Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->where('tanggal_pengajuan', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->where('tanggal_pengajuan', '<=', $request->tanggal_akhir);
        }

        // Sorting
        $sort = $request->get('sort', 'tanggal_pengajuan');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        $letters = $query->get();

        // Data untuk dropdown filter
        $jenisSuratList = ['SKCK', 'Domisili', 'Usaha', 'Kematian'];
        $statusList = ['Menunggu', 'Disetujui', 'Ditolak'];

        return view('letters.index', [
            'letters' => $letters,
            'total' => $letters->count(),
            'approved' => $letters->where('status', 'Disetujui')->count(),
            'rejected' => $letters->where('status', 'Ditolak')->count(),
            'jenisSuratList' => $jenisSuratList,
            'statusList' => $statusList,
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }
    public function create()
    {
        $residents = Resident::all();
        return view('letters.create', compact('residents'));
    }

    public function store(Request $request)
    {   
        $request->validate([
            'jenis_surat' => 'required|in:SKCK,Domisili,Usaha,Kematian',
            'keperluan' => 'required|string',
            'tanggal_pengajuan' => 'required|date',
        ]);

        Letter::create([
            'resident_id' => auth()->user()->resident->id,
            'jenis_surat' => $request->jenis_surat,
            'keperluan' => $request->keperluan,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'status' => 'Menunggu'
        ]);

        return redirect()->route('warga.letters.index')->with('success', 'Permohonan surat berhasil dikirim.');
    }


    public function approve($id)
    {
        $letter = Letter::with('resident')->findOrFail($id);
        
        $letter->update([
            'status' => 'Disetujui',
            'signed_by' => auth()->id(),
            'tanggal_disetujui' => now(),
        ]);

        $pdf = Pdf::loadView('letters.pdf', compact('letter'));

        $fileName = 'surat_' . $letter->id . '_' . time() . '.pdf';
        $filePath = 'surat/' . $fileName;

        Storage::put('public/' . $filePath, $pdf->output());
        $letter->update(['file_surat' => $filePath]);

        // Mail::to($letter->resident->email)->send(new SuratDisetujuiMail($letter));

        return redirect()->route('letters.index')->with('success', 'Surat berhasil disetujui dan di-generate.');
    }


    public function reject($id)
    {
        $letter = Letter::with('resident')->findOrFail($id);

        $letter->update([
            'status' => 'Ditolak',
            'signed_by' => auth()->id(),
            'tanggal_disetujui' => now(),
        ]);

        $pdf = Pdf::loadView('letters.rejected_pdf', compact('letter'));

        $fileName = 'penolakan_' . $letter->id . '_' . time() . '.pdf';
        $filePath = 'surat/' . $fileName;

        Storage::put('public/' . $filePath, $pdf->output());
        $letter->update(['file_surat' => $filePath]);

        // Mail::to($letter->resident->email)->send(new SuratDitolakMail($letter));

        return redirect()->route('letters.index')->with('success', 'Surat berhasil ditolak dan file penolakan dibuat.');
    }


    public function download($id)
    {
        $letter = Letter::findOrFail($id);

        $pdf = Pdf::loadView('letters.pdf', compact('letter'));

        $filename = 'surat_pengantar_' . $letter->id . '.pdf';
        return $pdf->download($filename);
    }

    public function show($id)
    {
        $letter = Letter::with('resident')->findOrFail($id);
        return view('letters.show', compact('letter'));
    }


    public function destroy(Letter $letter)
    {
        // Hapus file jika ada
        if ($letter->file_surat && Storage::exists('public/' . $letter->file_surat)) {
            Storage::delete('public/' . $letter->file_surat);
        }

        $letter->delete();

        return back()->with('success', 'Surat berhasil dihapus.');
    }

    public function wargaIndex()
    {
        $residentId = auth()->user()->resident->id;
        $letters = Letter::where('resident_id', $residentId)->latest()->get();

        return view('letters.warga_index', compact('letters'));
    }

}

