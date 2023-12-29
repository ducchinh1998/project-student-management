<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditClass extends Model
{
	protected $table = 'credit_classes';
	protected $fillable = [
		'name', 
		'code', 
		'lecturer_id', 
		'subject_id', 
		'faculty_id',
		'school_year_id',
		'revise_weight',
		'middle_test_weight',
		'practice_weight',
		'attendance_weight',
		'finish_test_weight',
		'start_time',
		'end_time',
	];

	public function faculties(){
		return $this->belongsTo('App\Models\Faculty', 'faculty_id');
	}

	public function lecturers(){
		return $this->belongsTo('App\Models\Account', 'lecturer_id');
	}

	public function subjects(){
		return $this->belongsTo('App\Models\Subject', 'subject_id');
	}

	public function schoolYears(){
		return $this->belongsTo('App\Models\SchoolYear', 'school_year_id');
	}
}