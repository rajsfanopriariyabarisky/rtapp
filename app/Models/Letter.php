<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id', 'jenis_surat', 'keperluan', 'tanggal_pengajuan',
        'status', 'file_surat', 'signed_by', 'tanggal_disetujui'
    ];
    
    protected $casts = [
    'tanggal_pengajuan' => 'datetime',
];

    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }

    public function signedBy()
    {
        return $this->belongsTo(User::class, 'signed_by');
    }
}

