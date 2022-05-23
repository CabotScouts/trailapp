<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

  protected $hidden = [ 'password', 'created_at', 'updated_at', 'remember_token' ];
  protected $fillable = ['username', 'password'];

}
