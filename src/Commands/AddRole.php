<?php

namespace Toddish\Verify\Commands;

use Illuminate\Console\Command,
	Symfony\Component\Console\Input\InputOption,
	Symfony\Component\Console\Input\InputArgument;

class AddRole extends Command
{
	protected $name = 'verify:add-role';

	protected $description = 'Add a new user role';

	public function fire()
	{
		$name = $this->argument('name');
		$level = $this->argument('level');
		$description = $this->option('description');

		$this->info('-- Adding new role - ' . $name . '.');

		$role = app(config('verify.models.role'))
			->fill([
				'name' => $name,
				'level' => $level,
				'description' => $description
			]);

		$role->save();

		$permissions = app(config('verify.models.permission'))
			->get();

		foreach ($permissions as $permission)
		{
			if ($this->confirm('Can ' . str_plural($name) . ' ' . $permission->name . '? [y|n]'))
			{
				$role->permissions()->attach($permission->id);
			}
		}

		$this->info('-- Role ' . $name . ' has been added!');
	}

	protected function getArguments()
	{
		return [
			['name', InputArgument::REQUIRED, 'The name of the role.'],
			['level', InputArgument::REQUIRED, 'The level of the role.']
		];
	}

	protected function getOptions()
	{
		return [
			['description', 'd', InputOption::VALUE_OPTIONAL, 'The description of the role.', null]
		];
	}
}
