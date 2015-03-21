<?php
return [

	'identified_by' => ['username', 'email'],

	// The Super Admin role
	// (returns true for all permissions)
	'super_admin' => 'Super Admin',

	// DB prefix for tables
	'prefix' => '',

	// Define Models if you extend them
	'models' => [
		'user' => 'Toddish\Verify\Models\User',
		'role' => 'Toddish\Verify\Models\Role',
		'permission' => 'Toddish\Verify\Models\Permission',
	]

];
