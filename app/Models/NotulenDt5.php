<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotulenDt5 extends Model
{
    use HasFactory;
    protected $table = 'notulen_dt_5';
    protected $fillable = [
        'judul', 'analisa', 'foto'
    ];

}
