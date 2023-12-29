<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
	protected $fillable = ['name', 'code', 'description', 'number_of_credits', 'faculty_id'];

	public function faculties(){
		return $this->belongsTo('App\Models\Faculty', 'faculty_id');
	}
}