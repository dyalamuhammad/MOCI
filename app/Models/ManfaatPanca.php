<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManfaatPanca extends Model
{
    use HasFactory;
    protected $table = 'manfaat_panca';
    protected $fillable = [
        'circle_id', 'notulen_id', 'safety', 'quality','cost','delivery','moral','environment'
    ];

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }

    public function notulen()
    {
        return $this->belongsTo(Notulen6::class);
    }
}
