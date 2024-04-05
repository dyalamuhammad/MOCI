<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartC extends Model
{
    use HasFactory;
    protected $table = 'smart_c';
    protected $fillable = [
        'circle_id', 'notulen_id', 'category'
    ];

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }

    public function notulen()
    {
        return $this->belongsTo(Notulen1::class);
    }
}
