<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements JWTSubject, AuthenticatableContract, AuthorizableContract {
	use Authenticatable, Authorizable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'full_name',
		'username',
		'email',
		'password'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
	];

	/**
	 * @return mixed
	 */
	public function getJWTIdentifier() {
		// TODO: Implement getJWTIdentifier() method.
		return $this->getKey();
	}

	/**
	 * @return array
	 */
	public function getJWTCustomClaims() {
		// TODO: Implement getJWTCustomClaims() method.
		return [];
	}

}
