<?php namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Users\EloquentUser as CartalystUser;

/**
 * User Model Class
 *
 *
 * @category   Models
 * @package    Model
  * @author kasun kalya <kasun.kalya@gmail.com>
 */
class User extends CartalystUser{

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
	protected $fillable = ['first_name', 'last_name', 'permissions', 'last_login', 'email', 'username', 'password'];

	/**
	 * Login column names
	 *
	 * @var array
	 */
	protected $loginNames = ['email', 'username'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password'];

	/**
	 * Get the full name of the User
	 *
	 * @return string  		Full Name
	 */
	public function getFullNameAttribute(){
		return $this->attributes['first_name'].' '.$this->attributes['last_name'];
	}

}
