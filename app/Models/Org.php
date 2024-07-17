<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Org extends Model
{
    use HasFactory;
    protected $table = 'org';
    protected $fillable = [
        'npk', 'grp', 'sect', 'dept', 'division'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class, 'grp', 'id_group');
    }
    public function section()
    {
        return $this->belongsTo(Section::class, 'sect', 'id_section');
    }
}
