<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	protected $table = 'notifications';
	protected $fillable = [
		'lecturer_id', 
		'credit_class_id', 
		'student_id',
		'title',
		'content'
	];

	public function lecturers(){
		return $this->belongsTo('App\Models\Account', 'lecturer_id');
	}

	public function creditClasses(){
		return $this->belongsTo('App\Models\CreditClass', 'credit_class_id');
	}

	public function students(){
		return $this->belongsTo('App\Models\Account', 'student_id');
	}
}