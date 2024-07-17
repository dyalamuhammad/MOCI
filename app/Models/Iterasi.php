<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iterasi extends Model
{
    use HasFactory;
    protected $table = 'iterasi';
    protected $fillable = [
        'circle_id', 'story_before', 'story_after', 'foto'
    ];

    public function circle()
    {
        return $this->belongsTo(CircleDt::class);
    }

    public function notulen()
    {
        return $this->belongsTo(NotulenDt7::class);
    }
}
