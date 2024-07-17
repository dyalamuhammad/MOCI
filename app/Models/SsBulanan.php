<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SsBulanan extends Model
{
    use HasFactory;
        protected $table = 'ss_bulanan';
        protected $fillable = [
        'npk', 'nama', 'foreman', 'supervisor', 'finish', 'status', 'bulan', 'tahun'
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
