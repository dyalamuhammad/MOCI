<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standarisasi extends Model
{
    use HasFactory;
    protected $table = 'standarisasi';
    protected $fillable = [
        'circle_id', 'notulen_id', 'what', 'how'
    ];

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }

    public function notulen()
    {
        return $this->belongsTo(Notulen7::class);
    }
}
