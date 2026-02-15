<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'nisn',
        'nama',
        'kelas',
        'jurusan',
        'password'
    ];

    // siswa -> banyak input aspirasi
    public function inputaspirasi()
    {
        return $this->hasMany(InputAspirasi::class, 'nisn', 'nisn');
    }

    // siswa -> user
    public function user()
    {
        return $this->hasOne(User::class, 'nisn', 'nisn');
    }
}
