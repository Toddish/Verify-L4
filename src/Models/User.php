<?php

namespace Toddish\Verify\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract,
	Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract,
	Illuminate\Database\Eloquent\SoftDeletes,
	Illuminate\Auth\Authenticatable,
	Illuminate\Auth\Passwords\CanResetPassword;

class User extends BaseModel implements AuthenticatableContract, CanResetPasswordContract
{
	use SoftDeletes, Authenticatable, CanResetPassword;

	protected $hidden = ['password', 'salt', 'remember_token'];

	protected $dates = ['deleted_at'];

	protected $fillable = [
		'username',
		'password',
		'email',
		'verified',
		'disabled'
	];

	protected $to_check_cache = null;

	public function roles()
	{
		return $this->belongsToMany(
				config('verify.models.role'),
				$this->prefix . 'role_user'
			)
			->withTimestamps();
	}

	public function setPasswordAttribute($password)
	{
		$salt = md5(str_random(64) . time());

		$this->attributes['password'] = \Hash::make($salt . $password);
		$this->attributes['salt'] = $salt;
	}

	public function is($roles)
	{
		$roles = !is_array($roles)
			? [$roles]
			: $roles;

		$to_check = $this->getToCheck();

		$valid = false;
		foreach ($to_check->roles as $role)
		{
			if (in_array($role->name, $roles))
			{
				$valid = true;
				break;
			}
		}

		return $valid;
	}

	public function can($permissions)
	{
		$permissions = !is_array($permissions)
			? [$permissions]
			: $permissions;

		$to_check = $this->getToCheck();

		foreach ($to_check->roles as $role)
		{
			if ($role->name === config('verify.super_admin'))
			{
				return true;
			}
		}

		$valid = false;
		foreach ($to_check->roles as $role)
		{
			foreach ($role->permissions as $permission)
			{
				if (in_array($permission->name, $permissions))
				{
					$valid = true;
					break 2;
				}
			}
		}

		return $valid;
	}

	public function level($level, $modifier = '>=')
	{
		$to_check = $this->getToCheck();

		$max = -1;
		$min = 100;
		$levels = [];

		foreach ($to_check->roles as $role)
		{
			$max = $role->level > $max
				? $role->level
				: $max;

			$min = $role->level < $min
				? $role->level
				: $min;

			$levels[] = $role->level;
		}

		switch ($modifier)
		{
			case '=':
				return in_array($level, $levels);
				break;
			case '>=':
				return $max >= $level;
				break;
			case '>':
				return $max > $level;
				break;
			case '<=':
				return $min <= $level;
				break;
			case '<':
				return $min < $level;
				break;
			case '!=':
				return !in_array($level, $levels);
				break;
			default:
				return false;
				break;
		}
	}

	private function getToCheck()
	{
		if (empty($this->to_check_cache))
		{
			$key = static::getKeyName();

			$to_check = static::with(['roles', 'roles.permissions'])
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

	public function scopeVerified($query)
	{
		return $query->where('verified', 1);
	}

	public function scopeUnverified($query)
	{
		return $query->where('verified', 0);
	}

	public function scopeDisabled($query)
	{
		return $query->where('disabled', 1);
	}

	public function scopeEnabled($query)
	{
		return $query->where('disabled', 0);
	}
}
