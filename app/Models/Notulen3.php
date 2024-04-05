<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notulen3 extends Model
{
    use HasFactory;
    protected $table = 'notulen_qcc_3';
    protected $fillable = [
        'id', 'circle_id', 'analisa_4m1e', 'uji_penyebab'
    ];

}
