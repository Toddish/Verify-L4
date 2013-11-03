<?php

class VerifyUserSeeder extends Seeder {

	public function __construct()
	{
		// Get the prefix
		$this->prefix = Config::get('verify::prefix', '');
	}

	public function run()
	{
		// Bring to local scope
		$prefix = $this->prefix;

		$role_id = DB::table($prefix.'roles')->insertGetId(array(
			'name' => Config::get('verify::super_admin'),
			'level' => 10,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		));

		$user_id = DB::table($prefix.'users')->insertGetId(array(
			'username' => 'admin',
			'password' => '$2a$08$rqN6idpy0FwezH72fQcdqunbJp7GJVm8j94atsTOqCeuNvc3PzH3m',
			'salt' => 'a227383075861e775d0af6281ea05a49',
			'email' => 'admin@example.com',
			'verified' => 1,
			'disabled' => 0,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		));

		DB::table($prefix.'role_user')->insert(array(
			'role_id' => $role_id,
			'user_id' => $user_id,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		));
	}
}