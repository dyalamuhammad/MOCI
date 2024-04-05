<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analisa4m1e extends Model
{
    use HasFactory;
    protected $table = 'analisa_4m1e';
    protected $fillable = [
        'circle_id', 'notulen_id', 'category', 'why1','why2','why3','why4','why5', 'judge'
    ];

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }

    public function notulen()
    {
        return $this->belongsTo(Notulen3::class);
    }
}
