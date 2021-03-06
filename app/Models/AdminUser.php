<?php

namespace App\Models;

use App\Handlers\Tree;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
    
	protected function serializeDate(\DateTimeInterface $date)
	{
	    return $date->format('Y-m-d H:i');
	}
    
    public function hasRoute($currentRouteName)
    {
    	if (Cache::get(config('APP_NAME', 'laravel').'permissions'.$this->id)) {
    	    $res = Cache::get(config('APP_NAME', 'laravel').'permissions'.$this->id);
	    } else {
			$res = $this->getPermissions();
			Cache::forever(config('APP_NAME', 'laravel').'permissions'.$this->id, $res);
	    }
    	
    	return in_array($currentRouteName, $res);
    }
    
    public function getPermissions()
    {
        $route = [];
        $free = Config('AdminRbac.free', []);
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
		        } else {
	            	!empty($item->route)?$route[] = $item->route:'';
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
	
	/**
	 * @param $role【string|array】
	 */
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
