<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable {
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	// protected $fillable = [
	//     'name', 'email', 'password',
	// ];
	const rules = [
	'avatar' => 'image',
	'name' => 'required',
	'email' => 'required|email',
	'position' => 'required',
	'station' => 'required',
	'question' => 'required',
	'answer' => 'required',
	'password' => 'confirmed|min:6|max:20'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	// protected $hidden = [
	//     'password', 'remember_token',
	// ];


	public function getRouteKeyName()
	{
		return 'employee_id';
	}
	protected $fillable = ['employee_id', 'password', 'access_level'];
	/**
	 * Get the employee that owns the account.
	 */
	public function employee() {
		return $this->belongsTo('App\Employee', 'employee_id', 'user_id');
	}

	public function setPasswordAttribute($value) {
		return $this->attributes['password'] = Hash::make($value);
	}
}
