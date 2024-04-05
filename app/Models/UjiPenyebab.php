<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UjiPenyebab extends Model
{
    use HasFactory;
    protected $table = 'uji_penyebab';
    protected $fillable = [
        'circle_id', 'notulen_id', 'akar_masalah', 'standar', 'actual', 'judge', 'metode_validasi'
    ];

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }

    public function notulen()
    {
        return $this->belongsTo(Notulen3::class);
    }
}
