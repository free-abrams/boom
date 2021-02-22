<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    use HasFactory;
    use HasRoles;
    
    protected $fillable = [
    	'name',
	    'username',
	    'avatar',
	    'remember_token'
    ];
    
    public static function creating($callback)
    {
    
    }
}
