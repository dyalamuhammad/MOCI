<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'section';
    protected $fillable = [
        'id_section', 'section', 'npk_cord', 'id_dept', 'part'
    ];

    public function coordinator()
    {
        return $this->belongsTo(User::class, 'npk_cord', 'npk');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'npk', 'npk'); // Adjust the column names as needed
    }
}
