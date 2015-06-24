<?php

namespace Toddish\Verify\Commands;

use Illuminate\Console\Command,
	Symfony\Component\Console\Input\InputArgument;

class AddCrudPermissions extends Command
{
	protected $name = 'verify:add-crud-permissions';

	protected $description = 'Add CRUD permissions';

	public function fire()
	{
		$name = $this->argument('name');

		$crud_permissions = config('verify.crud_permissions');

		$this->info('-- Adding new CRUD permissions for the ' . str_plural($name) . ' module.');

		$roles = app(config('verify.models.role'))
			->where('name', '!=', config('verify.super_admin'))
			->get();

		foreach ($crud_permissions as $crud_permission)
		{
			$new_permission = $crud_permission . $name;
			$description = $this->ask('Description for ' . $new_permission . ':');
			$this->call('verify:add-permission', ['name' => $new_permission, '--description' => $description]);
		}

		$this->info('-- CRUD permissions for the ' . str_plural($name) . ' module have been added!');
	}

	protected function getArguments()
	{
		return [
			['name', InputArgument::REQUIRED, 'The name of the CRUD module.']
		];
	}
}
