<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
	protected $fillable = ['name', 'slug', 'session', 'start_time', 'end_time'];
}