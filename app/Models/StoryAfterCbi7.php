<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryAfterCbi7 extends Model
{
    use HasFactory;
    protected $table = 'story_after_cbi_7';
    protected $fillable = [
        'circle_id', 'step', 'detail'
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
