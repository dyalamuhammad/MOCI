<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_ACTIVE = 'active';
    const STATUS_DELETED = 'deleted';
    const SLIDES = 'slides';
    const SERVICES = 'services';
    const ABOUTUS = 'aboutus';
    const CLIENTS = 'clients';
    const PROGRAMS = 'programs';
    const PROJECTS = 'projects';
}
