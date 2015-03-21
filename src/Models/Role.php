<?php

namespace Toddish\Verify\Models;

class Role extends BaseModel
{
	protected $fillable = ['name', 'description', 'level'];

	protected $to_check_cache;

	public function users()
	{
		return $this->belongsToMany(
				\Config::get('verify.models.user'),
				$this->prefix . 'role_user'
			)
		->withTimestamps();
	}

	public function permissions()
	{
		return $this->belongsToMany(
				\Config::get('verify.models.permission'),
				$this->prefix . 'permission_role'
			)
		->withTimestamps();
	}

	public function has($permissions)
	{
		$permissions = !is_array($permissions)
			? [$permissions]
			: $permissions;

		$to_check = $this->getToCheck();

		$valid = false;

		foreach ($to_check->permissions as $permission)
		{
			foreach ($permissions as $perm_to_check)
			{
				if($permission->name == $perm_to_check)
				{
					$valid = true;
					break 1;
				}
			}
		}

		return $valid;
	}

	private function getToCheck()
	{
		if (empty($this->to_check_cache))
		{
			$key = static::getKeyName();

			$to_check = static::with('permissions')
				->where($key, '=', $this->attributes[$key])
				->first();

			$this->to_check_cache = $to_check;
		}
		else
		{
			$to_check = $this->to_check_cache;
		}

		return $to_check;
	}
}
