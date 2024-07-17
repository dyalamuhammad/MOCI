<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'department';
    protected $fillable = [
        'id_dept', 'dept', 'npk_cord', 'id_div', 'part'
    ];
}
