<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aspirasi extends Model
{
    use HasFactory;

    protected $table = 'aspirasi';

    protected $fillable = [
        'inputaspirasi_id',
        'status',
        'tgl_aspirasi'
    ];

    public function inputaspirasi()
    {
        return $this->belongsTo(InputAspirasi::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }
}
