<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\AccountApprovalNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function pending()
    {
        
        $users = User::where('status_akun', 'pending')->get();
        return view('users.pending', compact('users'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status_akun' => 'disetujui']);
        // $user->notify(new AccountApprovalNotification('disetujui'));

        return back()->with('success', 'Akun disetujui dan notifikasi dikirim.');
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status_akun' => 'ditolak']);
        // $user->notify(new AccountApprovalNotification('ditolak'));

        return back()->with('success', 'Akun ditolak dan notifikasi dikirim.');
    }
    public function active(Request $request)
    {
        $query = User::where('status_akun', 'disetujui');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        $sort = $request->get('sort', 'nama');
        $direction = $request->get('direction', 'asc');

        $query = User::where('status_akun', 'disetujui')
            ->orderBy($sort, $direction);

        $users = $query->paginate(10)->withQueryString(); // 10 item per halaman + simpan query URL

        return view('users.active', compact('users', 'sort', 'direction'));
    }

     public function getFilteredUsers(Request $request)
    {
        $query = User::where('status_akun', 'disetujui');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        return $query->get();
    }

    public function exportPdf(Request $request)
    {
        $users = $this->getFilteredUsers($request); 
        $pdf = Pdf::loadView('users.export.pdf', compact('users'));
        return $pdf->download('user-list.pdf');

    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new UsersExport($request), 'user-list.xlsx');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,rt,rw,warga',
        ]);

        $user->update($validated);

        return redirect()->route('users.active')->with('success', 'Data pengguna diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.active')->with('success', 'Akun berhasil dihapus.');
    }
}
