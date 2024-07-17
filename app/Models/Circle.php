<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Circle extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'npk_leader', 'l1', 'l2','l3','l4','l5','l6','l7','l8','nqi', 'periode' // tambahkan 'npk' di sini
    ];
    protected $attributes = [
        'l1' => 0,
        'l2' => 0,
        'l3' => 0,
        'l4' => 0,
        'l5' => 0,
        'l6' => 0,
        'l7' => 0,
        'l8' => 0,
        'nqi' => 0,
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'npk_leader', 'npk'); // Adjust the column names as needed
    }
    public function members()
    {
        return $this->hasMany(Member::class , 'circle_id');
    }
    public function npkMembers()
    {
        return $this->hasMany(Member::class, 'circle_id');
    }
    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
    public function leader()
    {
        return $this->belongsTo(User::class, 'npk_leader', 'npk');
    }

    public function org()
    {
        return $this->belongsTo(Org::class, 'npk_leader', 'npk');
    }
}
