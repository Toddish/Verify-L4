<?php

namespace Toddish\Verify\Models;

class Permission extends BaseModel
{
	protected $fillable = ['name', 'description'];

	public function roles()
	{
		return $this->belongsToMany(
				config('verify.models.role'),
				$this->prefix . 'permission_role'
			)
		->withTimestamps();
	}
}
