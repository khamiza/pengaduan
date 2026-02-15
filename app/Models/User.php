<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'username',
        'password',
        'nama',
        'role',
        'nisn'
    ];

    protected $hidden = ['password'];

    // user (role siswa) -> 1 siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nisn', 'nisn');
    }

    // user (admin) -> banyak feedback
    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }
}
