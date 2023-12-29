<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
	protected $fillable = ['name', 'slug', 'description', 'faculty_id'];

	public function faculties(){
		return $this->belongsTo('App\Models\Faculty', 'faculty_id');
	}
}