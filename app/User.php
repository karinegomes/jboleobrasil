<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  /**
   * The attributes that are not mass assignable.
   *
   * @var array
   */
  protected $guarded = [
    'id', 'remember_token'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token'
  ];

  public function interactions(){
    return $this->hasMany('App\Models\Interaction');
  }

  public function appointments(){
    return $this->hasMany('App\Models\Appointment');
  }

  public function orders(){
    return $this->hasMany('App\Models\Order');
  }

  public function clients(){
    return $this->hasMany('App\Models\Client');
  }

  public function isAdmin(){
    return boolval($this->is_admin);
  }

  public static function register($data){
    try {
      $user = new User($data);

      if($user){
        $user->password = bcrypt($data['password']);

        return $user->save();
      } else {
        return false;
      }
    } catch (\Exception $e) {
      return false;
    }
  }
}
