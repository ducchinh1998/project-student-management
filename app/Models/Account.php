<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Student;

class Account extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guard = 'account';
    protected $table = 'accounts';
    protected $fillable = [
        'username', 
		'avatar', 
		'password',
		'first_name',
		'last_name',
		'phone',
        'code',
		'email',
		'address',
		'gender',
		'birthday',
		'field',
		'description',
		'status',
		'position',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
