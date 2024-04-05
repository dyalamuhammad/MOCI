<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackgroundL8 extends Model
{
    use HasFactory;
    protected $table = 'background_l8';
    protected $fillable = [
        'circle_id', 'notulen_id', 'actual', 'judge'
    ];

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }

    public function notulen()
    {
        return $this->belongsTo(Notulen8::class);
    }
}
