<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DampakPositif extends Model
{
    use HasFactory;
    protected $table = 'dampak_positif';
    protected $fillable = [
        'circle_id', 'notulen_id', 'category', 'detail'
    ];

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }

    public function notulen()
    {
        return $this->belongsTo(Notulen2::class);
    }
}
