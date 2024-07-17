<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrainstormingCbi extends Model
{
    use HasFactory;
    protected $table = 'brainstorming_cbi_5';
    protected $fillable = [
        'circle_id', 'anggota', 'ide_1', 'ide_2', 'ide_3'
    ];

    public function circle()
    {
        return $this->belongsTo(CircleDt::class);
    }

    public function notulen()
    {
        return $this->belongsTo(NotulenCbi5::class);
    }
}
