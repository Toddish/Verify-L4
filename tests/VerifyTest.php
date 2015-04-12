<?php

use Toddish\Verify\Models\User,
	Toddish\Verify\Helpers\Verify as VerifyHelper;

class VerifyTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();

		Artisan::call('migrate');

		$super_admin_role = Toddish\Verify\Models\Role::create([
			'name' => config('verify.super_admin'),
			'level' => 10
		]);

		$admin_role = Toddish\Verify\Models\Role::create([
			'name' => 'Admin',
			'level' => 7
		]);

		$create_permission = Toddish\Verify\Models\Permission::create([
			'name' => 'create_users'
		]);

		$this->user_1 = User::create([
			'username' => 'Super Admin',
			'password' => 'password',
			'email' => 'admin@email.com'
		]);

		$this->user_2 = User::create([
			'username' => 'Admin',
			'password' => 'password',
			'email' => 'admin2@email.com',
			'verified' => 1
		]);

		$admin_role->permissions()->attach(1);

		$this->user_1->roles()->attach(1);
		$this->user_2->roles()->attach(2);
	}

	public function testSuperAdminCanDoAnything()
	{
		$this->assertTrue($this->user_1->can('do_anything'));
		$this->assertTrue($this->user_1->can('create_users'));
	}


	public function testUserIs()
	{
		$this->assertFalse($this->user_2->is('User'));
		$this->assertTrue($this->user_2->is('Admin'));
	}

	public function testUserCan()
	{
		$this->assertFalse($this->user_2->can('edit_users'));
		$this->assertTrue($this->user_2->can('create_users'));
	}

	public function testUserLevel()
	{
		$this->assertFalse($this->user_2->level(10));
		$this->assertTrue($this->user_2->level(7));
		$this->assertTrue($this->user_2->level(10, '<'));
		$this->assertTrue($this->user_2->level(7, '<='));
		$this->assertTrue($this->user_2->level(5, '>'));
		$this->assertTrue($this->user_2->level(7, '>='));
		$this->assertTrue($this->user_2->level(7, '='));
	}

	public function testDisabledLoginAttempt()
	{
		$this->user_2->disabled = 1;
		$this->user_2->save();

		$attempt = \Auth::attempt([
			'username' => 'Admin',
			'password' => 'password',
			'disabled' => 0
		], false, false);
		$this->assertFalse($attempt);

		$this->user_2->disabled = 0;
		$this->user_2->save();
	}

	public function testUnverifiedLoginAttempt()
	{
		$this->user_2->verified = 0;
		$this->user_2->save();

		$attempt = \Auth::attempt([
			'username' => 'Admin',
			'password' => 'password',
			'verified' => 1
		], false, false);
		$this->assertFalse($attempt);

		$this->user_2->verified = 1;
		$this->user_2->save();
	}

	public function testValidLoginAttempt()
	{
		$attempt = \Auth::attempt([
			'username' => 'Admin',
			'password' => 'password',
			'verified' => 1,
			'disabled' => 0
		], false, false);
		$this->assertTrue($attempt);
	}

	public function testValidIdentifierLoginAttempt()
	{
		$attempt = \Auth::attempt([
			'identifier' => 'Admin',
			'password' => 'password',
			'verified' => 1,
			'disabled' => 0
		], false, false);
		$this->assertTrue($attempt);
	}

	public function testInvalidCredentialsVerifyLoginAttempt()
	{
		$attempt = \Auth::verify([
			'username' => 'Foo',
			'password' => 'Bar'
		], false, false);
		$this->assertEquals($attempt, VerifyHelper::INVALID_CREDENTIALS);
	}

	public function testDisabledVerifyLoginAttempt()
	{
		$this->user_2->disabled = 1;
		$this->user_2->save();

		$attempt = \Auth::verify([
			'username' => 'Admin',
			'password' => 'password'
		], false, false);
		$this->assertEquals($attempt, VerifyHelper::DISABLED);

		$this->user_2->disabled = 0;
		$this->user_2->save();
	}

	public function testUnverifiedVerifyLoginAttempt()
	{
		$this->user_2->verified = 0;
		$this->user_2->save();

		$attempt = \Auth::verify([
			'username' => 'Admin',
			'password' => 'password'
		], false, false);
		$this->assertEquals($attempt, VerifyHelper::UNVERIFIED);

		$this->user_2->verified = 1;
		$this->user_2->save();
	}

	public function testSuccessVerifyLoginAttempt()
	{
		$attempt = \Auth::verify([
			'username' => 'Admin',
			'password' => 'password'
		], false, false);
		$this->assertEquals($attempt, VerifyHelper::SUCCESS);
	}
}