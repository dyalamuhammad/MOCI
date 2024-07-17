<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notulen6 extends Model
{
    use HasFactory;
    protected $table = 'notulen_qcc_6';
    protected $fillable = [
        'id', 'circle_id', 'safety', 'cost', 'environment', 'delivery', 'quality', 'moral'
    ];

}
