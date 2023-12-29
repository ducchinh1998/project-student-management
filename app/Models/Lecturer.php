<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
  protected $guard = 'lecturer';
  protected $table = 'lecturers';
  protected $fillable = [
      'working_process', 
      'faculty_id', 
      'account_id',
      'class_id',
  ];

  public function faculties(){
    return $this->belongsTo('App\Models\Faculty', 'faculty_id');
  }

  public function classes(){
    return $this->belongsTo('App\Models\Classes', 'class_id');
  }


  public function accounts(){
    return $this->belongsTo('App\Models\Account', 'account_id');
  }
}
