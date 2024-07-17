<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotulenDt6 extends Model
{
    use HasFactory;
    protected $table = 'notulen_dt_6';
    protected $fillable = [
        'judul', 'analisa', 'foto'
    ];

}
