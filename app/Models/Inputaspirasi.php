<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InputAspirasi extends Model
{
    use HasFactory;

    protected $table = 'inputaspirasi';

    protected $fillable = [
        'nisn',
        'kategori_id',
        'lokasi',
        'keterangan',
        'tgl_input'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nisn', 'nisn');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function aspirasi()
    {
        return $this->hasOne(Aspirasi::class);
    }
}
