<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Account;

class Student extends Model
{
    protected $guard = 'student';
    protected $table = 'students';
    protected $fillable = [
        'cpa', 
        'tpa', 
		'warning_level', 
        'account_id', 
        'faculty_id', 
        'class_id', 
    ];

    public function account(){
        return $this->belongsTo(Account::class, 'account_id', 'id');
	}

    public function faculties(){
		return $this->belongsTo('App\Models\Faculty', 'faculty_id');
	}

    public function classes(){
		return $this->belongsTo('App\Models\Classes', 'class_id');
	}
}
