<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notulen7 extends Model
{
    use HasFactory;
    protected $table = 'notulen_qcc_7';
    protected $fillable = [
        'id', 'circle_id', 'rencana_perbaikan', 'design_improve'
    ];

}
