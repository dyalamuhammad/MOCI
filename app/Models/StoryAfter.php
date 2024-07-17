<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryAfter extends Model
{
    use HasFactory;
    protected $table = 'story_after';
    protected $fillable = [
        'circle_id', 'step', 'detail'
    ];

    public function circle()
    {
        return $this->belongsTo(CircleDt::class);
    }

    public function notulen()
    {
        return $this->belongsTo(NotulenDt6::class);
    }
}
