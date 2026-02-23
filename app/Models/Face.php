<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Face extends Model
{
    use HasFactory;
    // Nonaktifkan timestamps otomatis
    public $timestamps = false;
    protected $table = 'faces';
    protected $fillable = [
        'user_id','npk', 'name', 'image_path'
    ];   
    
}
