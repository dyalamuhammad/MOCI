<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryBeforeCbi extends Model
{
    use HasFactory;
    protected $table = 'story_before_cbi_6';
    protected $fillable = [
        'circle_id', 'step', 'detail'
    ];

    public function circle()
    {
        return $this->belongsTo(CircleDt::class);
    }

    public function notulen()
    {
        return $this->belongsTo(NotulenCbi6::class);
    }
}
