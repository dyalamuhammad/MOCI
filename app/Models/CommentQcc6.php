<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentQcc6 extends Model
{
    use HasFactory;
    protected $table = 'comments_qcc_6';
    protected $fillable = [
        'circle_id', 'notulen_id', 'comment'
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
