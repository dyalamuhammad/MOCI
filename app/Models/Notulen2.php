<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notulen2 extends Model
{
    use HasFactory;
    protected $table = 'notulen_qcc_2';
    protected $fillable = [
        'target_smart', 'target_aspek', 'dampak'
    ];

}
