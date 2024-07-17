<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Dashboard extends Model
{
    use HasFactory, HasApiTokens, Notifiable;
    protected $table = 'dashboard';
    protected $fillable = [
        'category', 'foto'
    ];

    CONST FYADM = 'FY-ADM';
    CONST FYBODY = 'FY-BODY';
    CONST BODYMAPS = 'BODY-MAPS';
    CONST STRUCTURE = 'STRUCTURE';
  
}
