# Verify - Laravel 5 Auth Package

---

A simple role/permission authentication package for Laravel 5.

For Laravel 4.2, use Verify 3.*.
For Laravel < 4.2, use Verify 2.*.

---

* Secure password storage with salt
* Role/permission based authentication
* Exceptions for intelligent handling of errors
* Configurable/extendable
* Licensed under the MIT license

---

## Installation

Add Verify to your composer.json file:

```
"require": {
	"toddish/verify": "~4.*"
}
```

Now, run a composer update on the command line from the root of your project:

    composer update

### Registering the Package

Add the Verify Service Provider to your config in ``app/config/app.php``:

```php
'providers' => [
	'Toddish\Verify\Providers\VerifyServiceProvider
],
```

### Change the driver

Then change your Auth driver to ``'verify'`` in ``app/config/auth.php``:

```php
'driver' => 'verify',
```

You may also change the ```'model'``` value to ```'Toddish\Verify\Models\User'``` if you want to be able to load Verify's User model when using ```Auth::user()```.

Alternatively, you can simply create your own User model, and extend Verify's:

```php
use Toddish\Verify\Models\User as VerifyUser;

class User extends VerifyUser
{
    // Code
}
```

### Publish the assets

Run this on the command line from the root of your project:

	php artisan vendor:publish

Or, if you want to publish parts of Verify individually:

    php artisan vendor:publish --provider="Toddish\Verify\Providers\VerifyServiceProvider" --tag="config"

The available tags are **config**, **migrations** and **seeds**.

### Migration

Now migrate the database tables for Verify. Run these on the command line from the root of your project:

    php artisan migrate
    php artisan db:seed

You should now have all the tables imported, complete with a sample user, called **admin**, with a password of **password**.

## Usage

The package is intentionally lightweight. You add Users, Roles and Permissions like any other Model.

```php
$user = new Toddish\Verify\Models\User;
$role = new Toddish\Verify\Models\Role;
$permission = new Toddish\Verify\Models\Permission;
```

etc.

**All models are in the namespace 'Toddish\Verify\Models\'.**

The relationships are as follows:

* Roles have many and belong to Users
* Users have many and belong to Roles
* Roles have many and belong to Permissions
* Permissions have many and belong to Roles

Relationships are handled via the Eloquent ORM, too:

```php
$role->permissions()->sync([$permission->id, $permission2->id]);
```

More information on relationships can be found in the [Laravel 5 Eloquent docs](http://laravel.com/docs/eloquent).

## Basic Examples

```php
// Create a new Permission
$permission = new Toddish\Verify\Models\Permission;
$permission->name = 'delete_user';
$permission->save();

// Create a new Role
$role = new Toddish\Verify\Models\Role;
$role->name = 'Moderator';
$role->level = 7;
$role->save();

// Assign the Permission to the Role
$role->permissions()->sync([$permission->id]);

// Create a new User
$user = new Toddish\Verify\Models\User;
$user->username = 'Todd';
$user->email = 'todd@toddish.co.uk';
$user->password = 'password'; // This is automatically salted and encrypted
$user->save();

// Assign the Role to the User
$user->roles()->sync(array($role->id));

// Using the public methods available on the User object
var_dump($user->is('Moderator')); // true
var_dump($user->is('Admin')); // false

var_dump($user->can('delete_user')); // true
var_dump($user->can('add_user')); // false

var_dump($user->level(7)); // true
var_dump($user->level(5, '<=')); // false
```

## Auth::verify()

Verify ships with a new login method, ```Auth::verify()```.

This method takes the same arguments as ```Auth::attempt()```, with the main difference being it returns a string, and checks if the user is disabled or verified too.

```php
use Toddish\Verify\Helpers\Verify;

switch (Auth::verify($credentials))
{
  case Verify::SUCCESS:
    // Successful log in
    break;
  case Verify::INVALID_CREDENTIALS:
  case Verify::UNVERIFIED:
  case Verify::DISABLED:
    // Error!
    break;
}
```

---

## Documentation

For full documentation, have a look at [http://docs.toddish.co.uk/verify](http://docs.toddish.co.uk/verify).