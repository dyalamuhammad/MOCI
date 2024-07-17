<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    // Nonaktifkan timestamps otomatis
    public $timestamps = false;
    protected $table = 'groupfrm';
    protected $fillable = [
        'id_group', 'nama_group', 'npk_cord', 'id_section', 'part'
    ];

   public function user()
    {
        return $this->belongsTo(User::class, 'npk', 'npk'); // Adjust the column names as needed
    }
    public function org()
    {
        return $this->belongsTo(Org::class, 'npk_cord', 'npk'); // Adjust the column names as needed
    }

    public function coordinator()
    {
        return $this->belongsTo(User::class, 'npk_cord', 'npk');
    }

   
    
}
