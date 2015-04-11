<?php
namespace Toddish\Verify\Providers;

use Illuminate\Contracts\Auth\UserProvider,
	Illuminate\Auth\EloquentUserProvider,
	Illuminate\Contracts\Hashing\Hasher as HasherContract,
	Illuminate\Contracts\Auth\Authenticatable as UserContract;

class VerifyUserProvider extends EloquentUserProvider implements UserProvider
{
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
}