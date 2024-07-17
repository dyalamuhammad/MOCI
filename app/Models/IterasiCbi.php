<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IterasiCbi extends Model
{
    use HasFactory;
    protected $table = 'iterasi_cbi_7';
    protected $fillable = [
        'circle_id', 'story_before', 'story_after', 'foto'
    ];

    public function circle()
    {
        return $this->belongsTo(CircleDt::class);
    }

    public function notulen()
    {
        return $this->belongsTo(NotulenCbi7::class);
    }
}
