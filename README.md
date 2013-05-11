# Verify - Laravel 4 Auth Package

---

A simple role/permission authentication package for Laravel 4

---

* Secure password storage with salt
* Role/permission based authentication
* Exceptions for intelligent handling of errors
* Configurable/extendable

---

## Installation

Add Verify to your composer.json file:

```
"require": {
	"toddish/verify": "2.0.*"
}
```

Now, run a composer update on the command line from the root of your project:

    composer update

### Registering the Package

Add the Verify Service Provider to your config in ``app/config/app.php``:

```php
'providers' => array(
	'Toddish\Verify\VerifyServiceProvider'
),
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

### Publish the config

Run this on the command line from the root of your project:

    php artisan config:publish toddish/verify

This will publish Verify's config to ``app/config/packages/toddish/verify/``.

You may also want to change the ``'db_prefix'`` value if you want a prefix on Verify's database tables.

### Migration

Now migrate the database tables for Verify. Run this on the command line from the root of your project:

    php artisan migrate --package="toddish/verify"

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
$role->permissions()->sync(array($permission->id, $permission2->id));
```

More information on relationships can be found in the [Laravel 4 Eloquent docs](http://four.laravel.com/docs/eloquent).

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
$role->permissions()->sync(array($permission->id));

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
var_dump($user->level(5, '&lt;=')); // false
```

---

## Documentation

For full documentation, have a look at [http://docs.toddish.co.uk/verify-l4](http://docs.toddish.co.uk/verify-l4).