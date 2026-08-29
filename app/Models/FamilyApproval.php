<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'nik', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir',
        'jenis_kelamin', 'agama', 'pekerjaan', 'status_perkawinan',
        'status_tinggal', 'alamat', 'rt', 'rw', 'telepon', 'email',
        'hubungan_keluarga', 'status', 'alasan_penolakan', 'approved_by', 'approved_at'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'approved_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'Menunggu');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'Disetujui');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'Ditolak');
    }

    // Methods
    public function approve($approvedByUserId, $alasan = null)
    {
        $this->update([
            'status' => 'Disetujui',
            'approved_by' => $approvedByUserId,
            'approved_at' => now(),
            'alasan_penolakan' => $alasan
        ]);
    }

    public function reject($rejectedByUserId, $alasan)
    {
        $this->update([
            'status' => 'Ditolak',
            'approved_by' => $rejectedByUserId,
            'approved_at' => now(),
            'alasan_penolakan' => $alasan
        ]);
    }

    public function isPending()
    {
        return $this->status === 'Menunggu';
    }

    public function isApproved()
    {
        return $this->status === 'Disetujui';
    }

    public function isRejected()
    {
        return $this->status === 'Ditolak';
    }
}
