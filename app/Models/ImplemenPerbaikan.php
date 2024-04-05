<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImplemenPerbaikan extends Model
{
    use HasFactory;
    protected $table = 'implemen_perbaikan';
    protected $fillable = [
        'circle_id', 'notulen_id', 'what', 'how','why','where','who','when', 'how_much'
    ];

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }

    public function notulen()
    {
        return $this->belongsTo(Notulen5::class);
    }
}
