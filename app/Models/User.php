<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;


    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class);
    }
    public function isRT()
    {
        return $this->role === 'rt';
    }
    protected $fillable = [
        'nama', 'email', 'password', 'role', 'status_akun',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function signedLetters()
    {
        return $this->hasMany(Letter::class, 'signed_by');
    }

    public function tanggapanPengaduan()
    {
        return $this->hasMany(Complaint::class, 'ditanggapi_oleh');
    }

    public function resident()
    {
        return $this->hasOne(Resident::class);
    }

    public function familyApprovals()
    {
        return $this->hasMany(FamilyApproval::class);
    }

    public function approvedFamilyApprovals()
    {
        return $this->hasMany(FamilyApproval::class, 'approved_by');
    }
}

