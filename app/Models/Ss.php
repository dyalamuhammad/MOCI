<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ss extends Model
{
    use HasFactory;
        protected $table = 'ss';
        protected $fillable = [
        'npk', 'nama', 'januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'npk', 'npk'); // Adjust the column names as needed
    }

    public function org()
    {
        return $this->belongsTo(Org::class, 'npk', 'npk');
    }

}
