<?php

namespace Toddish\Verify\Models;

class Permission extends BaseModel
{
	protected $fillable = ['name', 'description'];

	public function roles()
	{
		return $this->belongsToMany(
				\Config::get('verify.models.role'),
				$this->prefix . 'permission_role'
			)
		->withTimestamps();
	}
}
