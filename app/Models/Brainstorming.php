<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brainstorming extends Model
{
    use HasFactory;
    protected $table = 'brainstorming';
    protected $fillable = [
        'circle_id', 'anggota', 'ide_1', 'ide_2', 'ide_3'
    ];

    public function circle()
    {
        return $this->belongsTo(CircleDt::class);
    }

    public function notulen()
    {
        return $this->belongsTo(NotulenDt5::class);
    }
}
