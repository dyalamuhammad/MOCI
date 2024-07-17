<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotulenCbi1 extends Model
{
    use HasFactory;
    protected $table = 'notulen_cbi_1';
    protected $fillable = [
        'judul', 'analisa', 'foto'
    ];

}
