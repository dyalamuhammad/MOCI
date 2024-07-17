<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberDt extends Model
{

    use HasFactory;
    protected $table = 'members_dt';
    protected $fillable = [
        'circle_id', 'user_id', 'npk', 'name', 'npk_anggota', 'l1', 'l2', 'l3', 'l4', 'l5', 'l6', 'l7', 'l8', 'nqi' // tambahkan 'npk' di sini
    ];
    public function circle()
    {
        return $this->belongsTo(CircleDt::class);
    }
    public function user()
    {
        // return $this->belongsTo(User::class);
        return $this->belongsTo(User::class, 'npk_anggota', 'npk'); // Adjust the column names accordingly
    }
}
