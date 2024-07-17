<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PowerMeter extends Model
{
    use HasFactory;
    protected $table = 'power_meter';
    protected $fillable = [
        'volt', 'current', 'daya', 'frekuensi', 'pf', 'energi', 'created_at'
    ];
   
}
