<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
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
}
