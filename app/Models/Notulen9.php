<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notulen9 extends Model
{
    use HasFactory;
    protected $table = 'notulen_qcc_9';
    protected $fillable = [
        'id', 'circle_id', 'manfaat', 'benefit', 'file'
    ];

}
