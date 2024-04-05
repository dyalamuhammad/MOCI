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
}