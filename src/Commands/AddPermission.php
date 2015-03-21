<?php

namespace Toddish\Verify\Commands;

use Illuminate\Console\Command,
	Symfony\Component\Console\Input\InputOption,
	Symfony\Component\Console\Input\InputArgument;

class AddPermission extends Command
{
	protected $name = 'verify:add-permission';

	protected $description = 'Add a new role permission.';

	public function fire()
	{
		$name = $this->argument('name');
		$description = $this->option('description');

		$this->info('-- Adding new permission - ' . $name . '.');

		$permission = \App::make(\Config::get('verify.models.permission'))
			->fill([
				'name' => $name,
				'description' => $description
			]);

		$permission->save();

		$roles = \App::make(\Config::get('verify.models.role'))
			->where('name', '!=', \Config::get('verify.super_admin'))
			->get();

		foreach ($roles as $role)
		{
			if ($this->confirm('Can ' . str_plural($role->name) . ' ' . $name . '? [y|n]'))
			{
				$permission->roles()->attach($role->id);
			}
		}

		$this->info('-- Permission ' . $name . ' has been added!');
	}

	protected function getArguments()
	{
		return [
			['name', InputArgument::REQUIRED, 'The name of the permission.']
		];
	}

	protected function getOptions()
	{
		return [
			['description', 'd', InputOption::VALUE_OPTIONAL, 'The description of the permission.', null]
		];
	}

}
