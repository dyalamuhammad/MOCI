<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Langkah extends Model
{
    use HasFactory;
    protected $table = 'langkah';
    protected $fillable = [
        'periode_id', 'mulai', 'sampai', 'name'// tambahkan 'npk' di sini
    ];

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
    public function circle()
{
    return $this->belongsTo(Circle::class, 'periode_id', 'id');
}
}
