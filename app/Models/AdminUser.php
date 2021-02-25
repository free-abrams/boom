<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    use HasFactory;
    
    protected $fillable = [
    	'name',
	    'username',
	    'avatar',
	    'password',
	    'remember_token'
    ];
    
    public function hasRoute($currentRouteName)
    {
    	$res = $this->getPermissions();

    	return in_array($currentRouteName, $res);
    }
    
    public function getPermissions()
    {
        $route = [];
        $free = Config('AdminRbac.free');
        $action = [
        	'store',
        	'index',
	        'create',
	        'destroy',
	        'update',
	        'show',
	        'edit'
        ];

        foreach ($this->role as $k => $v) {
        	$v->permissions->map(function ($item) use ($action, &$route) {
	            if (Str::after($item->route, '.') === '*') {
	                $name = Str::before($item->route, '.');
			            foreach ($action as $key => $value) {
			                $route[] = $name.'.'.$value;
			            }
		        }
	        });
        }
        
        return array_merge($route, $free);
    }
    
    public function role()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id')->with(['permissions']);
    }
    
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
    
    public function setAvatarAttribute($value)
    {
        $this->attributes['avatar'] = $value?$value:config('admin.avatar');
    }
    
    public function assignRole($role)
    {
    	if (!is_array($role)) {
    	    $name[] = $role;
	    } else {
    		$name  = $role;
	    }
    	
    	$role = Role::whereIn('name', $name)->get()->pluck('id');
    	
    	$this->role()->attach($role);
    }
}
