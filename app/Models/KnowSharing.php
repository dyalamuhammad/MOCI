<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class KnowSharing extends Model
{
    use HasFactory, HasApiTokens, Notifiable;
    protected $table = 'knowledge_sharing';
    protected $fillable = [
        'category', 'file'
    ];
    const SAFETY = 'safety';
    const QUALITY = 'quality';
    const MORALE = 'morale';
    const ENVIRONMENT = 'environment';
    const DELIVERY = 'delivery';
    const COST = 'cost';
}
