<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    
	protected function serializeDate(\DateTimeInterface $date)
	{
	    return $date->format('Y-m-d H:i');
	}
 
	protected $fillable = [
		'name',
		'guard_name',
		'title',
		'route',
		'sort',
		'level'
	];
}
