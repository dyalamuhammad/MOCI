<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','periode', 'tema', 'tanggal_mulai', 'tanggal_akhir', 'status'
    ];

    public static $rules = [
        'periode' => 'unique:periodes', // Aturan unik untuk kolom periode
        // Aturan validasi lainnya
    ];
}

