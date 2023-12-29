<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterClass extends Model
{
	protected $table = 'student_register_credit_classes';
	public $timestamps = false;
	protected $fillable = [
		'student_id', 
		'credit_class_id', 
		'registered_at',

		'attendance_point',
		'revise_point',
		'practice_point',
		'middle_test_point',
		'finish_test_point',
		'avg_point',
	];

	public function students(){
		return $this->belongsTo('App\Models\Student', 'student_id');
	}

	public function creditClass(){
		return $this->belongsTo('App\Models\CreditClass', 'credit_class_id');
	}
}