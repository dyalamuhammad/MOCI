<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotulenDt7 extends Model
{
    use HasFactory;
    protected $table = 'notulen_dt_7';
    protected $fillable = [
        'judul', 'analisa', 'foto'
    ];

}
