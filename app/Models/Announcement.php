<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'title',
        'content',
        'is_public',
        'user_id',
    ];

    // Relasi ke pembuat pengumuman
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
