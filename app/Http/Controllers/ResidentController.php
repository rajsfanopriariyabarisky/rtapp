<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ResidentsExport;
use App\Imports\ResidentsImport;

class ResidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Resident::query();

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('nik', 'like', '%' . $request->search . '%')
                  ->orWhere('alamat', 'like', '%' . $request->search . '%')
                  ->orWhere('telepon', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan jenis kelamin
        if ($request->filled('jenis_kelamin') && $request->jenis_kelamin !== 'all') {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Filter berdasarkan agama
        if ($request->filled('agama') && $request->agama !== 'all') {
            $query->where('agama', $request->agama);
        }

        // Filter berdasarkan status tinggal
        if ($request->filled('status_tinggal') && $request->status_tinggal !== 'all') {
            $query->where('status_tinggal', $request->status_tinggal);
        }

        // Filter berdasarkan RT
        if ($request->filled('rt') && $request->rt !== 'all') {
            $query->where('rt', $request->rt);
        }

        // Filter berdasarkan RW
        if ($request->filled('rw') && $request->rw !== 'all') {
            $query->where('rw', $request->rw);
        }

        // Sorting
        $sort = $request->get('sort', 'nama_lengkap');
        $direction = $request->get('direction', 'asc');
        $query->orderBy($sort, $direction);

        $residents = $query->paginate(10);

        // Data untuk dropdown filter
        $rtList = Resident::distinct()->pluck('rt')->filter()->sort();
        $rwList = Resident::distinct()->pluck('rw')->filter()->sort();
        $agamaList = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'];

        return view('residents.index', compact('residents', 'rtList', 'rwList', 'agamaList', 'sort', 'direction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Cegah user yang sudah punya data resident
        if (auth()->user()->resident) {
            return redirect()->route('warga.dashboard')->with('info', 'Data sudah dilengkapi.');
        }

        return view('residents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|numeric|digits:16|unique:residents',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu,Lainnya',
            'alamat' => 'required|string',
            'rt' => 'required',
            'rw' => 'required',
            'telepon' => 'required',
            'email' => 'required|email',
            'pekerjaan' => 'nullable|string',
            'status_perkawinan' => 'required|in:Belum Menikah,Menikah,Cerai',
            'status_tinggal' => 'required|in:Tetap,Pindah,Meninggal',
        ]);

        $request->merge(['user_id' => auth()->id()]);

        Resident::create(attributes: $request->all());

        return redirect()->route('warga.dashboard')->with('success', 'Data diri berhasil disimpan.');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resident $resident)
    {
        return view('residents.edit', compact('resident'));
    }

    public function update(Request $request, Resident $resident)
    {
        $request->validate([
            'nik' => 'required|numeric|digits:16',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu,Lainnya',
            'pekerjaan' => 'required|string|max:255',
            'status_perkawinan' => 'required|in:Belum Menikah,Menikah,Cerai',
            'status_tinggal' => 'required|in:Tetap,Pindah,Meninggal',
            'alamat' => 'required|string',
            'rt' => 'required|string',
            'rw' => 'required|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $resident->update($request->all());

        return redirect()->route('residents.index')->with('success', 'Data berhasil diperbarui.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resident $resident)
    {
        $resident->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }

    public function exportExcel()
    {
        return Excel::download(new ResidentsExport, 'data-warga.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new ResidentsImport, $request->file('file'));

        return back()->with('success', 'Data warga berhasil diimpor.');
    }

    /**
     * Menampilkan form edit data diri untuk warga
     */
    public function editWarga()
    {
        $resident = auth()->user()->resident;
        
        if (!$resident) {
            return redirect()->route('residents.create')
                ->with('error', 'Anda harus melengkapi data diri terlebih dahulu.');
        }

        return view('residents.edit-warga', compact('resident'));
    }

    /**
     * Update data diri untuk warga
     */
    public function updateWarga(Request $request)
    {
        $resident = auth()->user()->resident;
        
        if (!$resident) {
            return redirect()->route('residents.create')
                ->with('error', 'Anda harus melengkapi data diri terlebih dahulu.');
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

        return redirect()->route('warga.dashboard')
            ->with('success', 'Data diri berhasil diperbarui.');
    }
}
