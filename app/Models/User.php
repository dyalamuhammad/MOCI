<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    const TM = 'tm';
    const TL = 'tl';
    const SPV = 'spv';
    const MNG = 'mng';
    const FRM = 'frm';
    const DH = 'dh';
    const SUPERADMIN = 'Superadmin';
    const name = 'name';
    const npk = 'npk';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'npk',
        'name',
        'password',
        'jabatan',
        'shift',
        'status',
        'section'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'password' => 'hashed',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class, 'npk', 'npk_cord'); // Adjust the column names as needed
    }
    public function department()
    {
        return $this->belongsTo(Departemen::class, 'npk', 'npk_cord'); // Adjust the column names as needed
    }
    public function group()
    {
        return $this->belongsTo(Group::class, 'npk', 'npk_cord'); // Adjust the column names as needed
    }
    public function org()
    {
        return $this->belongsTo(Org::class, 'npk', 'npk'); // Adjust the column names as needed
    }
    public function circle()
    {
        return $this->belongsTo(Circle::class, 'npk', 'npk_leader'); // Adjust the column names as needed
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
    public function member()
    {
        return $this->belongsTo(Member::class, 'npk', 'npk_anggota'); // Adjust the column names as needed
    }
    public function leaderCircles()
    {
        return $this->hasMany(Circle::class, 'npk_leader', 'npk');
    }
}
