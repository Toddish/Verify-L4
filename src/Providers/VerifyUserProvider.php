<?php
namespace Toddish\Verify\Providers;

use Illuminate\Contracts\Auth\UserProvider,
	Illuminate\Contracts\Hashing\Hasher as HasherContract,
	Illuminate\Contracts\Auth\Authenticatable as UserContract;

class VerifyUserProvider implements UserProvider
{
	protected $hasher;

	protected $model;

	public function __construct(HasherContract $hasher, $model)
	{
		$this->model = $model;
		$this->hasher = $hasher;
	}

	public function retrieveByID($identifier)
	{
		return $this->createModel()
			->newQuery()
			->find($identifier);
	}

	public function retrieveByToken($identifier, $token)
	{
		$model = $this->createModel();

		return $model->newQuery()
			->where($model->getKeyName(), $identifier)
			->where($model->getRememberTokenName(), $token)
			->first();
	}

	public function updateRememberToken(UserContract $user, $token)
	{
		$user->setRememberToken($token);
		$user->save();
	}

	public function retrieveByCredentials(array $credentials)
	{
		if (array_key_exists('identifier', $credentials))
		{
			foreach (\Config::get('verify.identified_by') as $identified_by)
			{
				$query = $this->createModel()
					->newQuery()
					->where($identified_by, $credentials['identifier']);

				$this->appendQueryConditions($query, $credentials, ['password', 'identifier']);

				if ($query->count() !== 0)
				{
					break;
				}
			}
		}
		else
		{
			$query = $this->createModel()->newQuery();
			$this->appendQueryConditions($query, $credentials);
		}

		return $query->first();
	}

	protected function appendQueryConditions($query, $conditions, $exclude = ['password'])
	{
		foreach ($conditions as $key => $value)
		{
			if (!in_array($key, $exclude))
			{
				$query->where($key, $value);
			}
		}
	}

	public function validateCredentials(UserContract $user, array $credentials)
	{
		$plain = $credentials['password'];

		return $this->hasher
			->check($user->salt . $plain, $user->getAuthPassword());
	}

	public function createModel()
	{
		$class = '\\' . ltrim($this->model, '\\');
		return new $class;
	}
}