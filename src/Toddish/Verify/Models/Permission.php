<?php

namespace Toddish\Verify\Models;

class Permission
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = array('name', 'description');

	/**
	 * Roles
	 *
	 * @return object
	 */
	public function roles()
	{
		return $this->has_many_and_belongs_to(
				'Toddish\Verify\Models\Role',
				$this->prefix.'permission_role'
			)
		->withTimestamps();
	}
}