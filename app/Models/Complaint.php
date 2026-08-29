<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id', 'judul', 'isi', 'foto', 'status',
        'ditanggapi_oleh', 'tanggal_pengaduan', 'tanggal_tanggapan'
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    public function ditanggapiOleh()
    {
        return $this->belongsTo(User::class, 'ditanggapi_oleh');
    }
}

