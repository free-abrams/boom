<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use HasFactory;
    use SoftDeletes;

	protected function serializeDate(\DateTimeInterface $date)
	{
	    return $date->format('Y-m-d H:i');
	}
}
