<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotulenCbi6 extends Model
{
    use HasFactory;
    protected $table = 'notulen_cbi_6';
    protected $fillable = [
        'judul', 'analisa', 'foto'
    ];

}
