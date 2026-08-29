<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\User;
use App\Notifications\NewAnnouncementNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AnnouncementController extends Controller
{
    public function indexPublic()
    {
        $announcements = Announcement::where('is_public', true)->latest()->get();
        return view('announcements.public', compact('announcements'));
    }

    // Untuk admin
    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_public' => 'nullable|boolean',
            'send_email' => 'nullable|boolean',
        ]);

        $announcement = Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'is_public' => $request->boolean('is_public'),
            'user_id' => Auth::id(),
        ]);

        if ($request->boolean('send_email')) {
            $this->sendAnnouncementNotification($announcement);
        }

        return redirect()->route('announcements.index')
            ->with('success', 'Pengumuman berhasil dibuat.' . ($request->boolean('send_email') ? ' Email notifikasi telah dikirim ke semua warga.' : ''));
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_public' => 'nullable|boolean',
        ]);

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'is_public' => $request->boolean('is_public'),
        ]);

        return redirect()->route('announcements.index')->with('success', 'Pengumuman diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('announcements.index')->with('success', 'Pengumuman dihapus.');
    }

    /**
     * Kirim notifikasi email ke semua warga
     */
    private function sendAnnouncementNotification(Announcement $announcement)
    {
        $wargaUsers = User::where('role', 'warga')
            ->where('status_akun', 'disetujui')
            ->get();

        foreach ($wargaUsers as $user) {
            try {
                // $user->notify(new NewAnnouncementNotification($announcement));
            } catch (\Exception $e) {
                Log::error('Gagal kirim email pengumuman ke ' . $user->email . ': ' . $e->getMessage());
            }
        }
    }
}
