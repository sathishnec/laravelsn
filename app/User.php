<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;


class User extends Model implements Authenticatable
{
	// If the table name is different is from the model name, specify the table name here...
	// Also change it on the config/auth.php 'providers' array
    //protected $table = "User2";


    use \Illuminate\Auth\Authenticatable;

    public function posts() 
    {
    	return $this->hasMany('App\Post');
    }




}
