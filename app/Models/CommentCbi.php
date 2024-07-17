<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentCbi extends Model
{
    use HasFactory;
    protected $table = 'comments_cbi_1';
    protected $fillable = [
        'circle_id', 'notulen_id', 'comment'
    ];

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }

    public function notulen()
    {
        return $this->belongsTo(NotulenCbi1::class);
    }
}
