<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotulenCbi7 extends Model
{
    use HasFactory;
    protected $table = 'notulen_cbi_7';
    protected $fillable = [
        'judul', 'analisa', 'foto'
    ];

}
