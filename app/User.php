<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password', 'blocked', 'blocked_until'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * A user can have many trainings
	*/
	public function trainings() {
		return $this->hasMany('App\Training');
	}

	/**
	 * A user can have many ratings
	*/
	public function ratings() {
		return $this->hasMany('App\Rating');
	}

	/**
	 * A user can have many comments
	*/
	public function comments() {
		return $this->hasMany('App\Comment');
	}

	/**
	 * A user can have many notifications
	*/
	public function notifications() {
		return $this->hasMany('App\Notification');
	}

	/**
	 * If is admin
	*/
	public function isAdmin() {
		return $this->role == 'admin';
	}
}
