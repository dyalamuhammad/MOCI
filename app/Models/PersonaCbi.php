<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonaCbi extends Model
{
    use HasFactory;
    protected $table = 'pemilihan_persona_cbi_1';
    protected $fillable = [
        'circle_id', 'notulen_id', 'nama', 'asal', 'usia', 'apa', 'motivasi'
    ];

    public function circle()
    {
        return $this->belongsTo(CircleDt::class);
    }

    public function notulen()
    {
        return $this->belongsTo(NotulenCbi1::class);
    }
}
