<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir',
        'jenis_kelamin', 'agama', 'pekerjaan', 'status_perkawinan',
        'status_tinggal', 'alamat', 'rt', 'rw', 'telepon', 'email', 'user_id', 'hubungan_keluarga'
    ];

    public function letters()
    {
        return $this->hasMany(Letter::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

