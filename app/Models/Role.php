<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    
	protected function serializeDate(\DateTimeInterface $date)
	{
	    return $date->format('Y-m-d H:i');
	}
    
    protected $fillable = [
    	'name',
	    'guard_name',
	    'title'
    ];
    
    public function admins()
    {
    	return $this->belongsToMany(AdminUser::class);
    }
    
    public function permissions()
    {
    	return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }
    
    // 获取角色所有可用权限用于显示在选择列表
    static public function allPermissions()
    {
        $permissions = Permission::whereNotNull('route')->get();
        
        // 只返回没有子节点的数据
        return $permissions;
    }
}
