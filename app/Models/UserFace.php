<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class UserFace extends Model
{
    use HasFactory;
    protected $keyType = 'string';

    protected $table = 'user_faces';
    protected $fillable = [
        'user_id', 'name', 'image'
    ];

    // Gunakan UUID untuk kolom ID
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = Str::uuid();  // Membuat UUID jika ID tidak ada
            }
        });
    }

 
}
