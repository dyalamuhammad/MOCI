<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotulenDt9 extends Model
{
    use HasFactory;
    protected $table = 'notulen_dt_9';
    protected $fillable = [
        'judul', 'analisa', 'foto'
    ];

}
