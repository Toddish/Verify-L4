<?php
namespace Toddish\Verify\Models;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends BaseModel implements UserInterface, RemindableInterface
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('username', 'password', 'salt', 'email', 'verified', 'deleted_at', 'disabled');

    /**
     * To check cache
     *
     * Stores a cached user to check against
     *
     * @var object
     */
    protected $to_check_cache;

    /**
     * Soft delete
     *
     * @var boolean
     */
    protected $softDelete = true;

    /**
     * Roles
     *
     * @return object
     */
    public function roles()
    {
        return $this->belongsToMany(
                'Toddish\Verify\Models\Role',
                $this->prefix.'role_user'
            )
            ->withTimestamps();;
    }

    /**
     * Salts and saves the password
     *
     * @param string $password
     */
    public function setPasswordAttribute($password)
    {
        $salt = md5(\Str::random(64) . time());
        $hashed = \Hash::make($salt . $password);

        $this->attributes['password'] = $hashed;
        $this->attributes['salt'] = $salt;
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    /**
     * Is the User a Role
     *
     * @param  array|string  $roles A single role or an array of roles
     * @return boolean
     */
    public function is($roles)
    {
        $roles = !is_array($roles)
            ? array($roles)
            : $roles;

        $to_check = $this->getToCheck();

        $valid = FALSE;
        foreach ($to_check->roles as $role)
        {
            if (in_array($role->name, $roles))
            {
                $valid = TRUE;
                break;
            }
        }

        return $valid;
    }

    /**
     * Can the User do something
     *
     * @param  array|string $permissions Single permission or an array or permissions
     * @return boolean
     */
    public function can($permissions)
    {
        $permissions = !is_array($permissions)
            ? array($permissions)
            : $permissions;

        $to_check = $this->getToCheck();

        // Are we a super admin?
        foreach ($to_check->roles as $role)
        {
            if ($role->name === \Config::get('verify::super_admin'))
            {
                return TRUE;
            }
        }

        $valid = FALSE;
        foreach ($to_check->roles as $role)
        {
            foreach ($role->permissions as $permission)
            {
                if (in_array($permission->name, $permissions))
                {
                    $valid = TRUE;
                    break 2;
                }
            }
        }

        return $valid;
    }

    /**
     * Is the User a certain Level
     *
     * @param  integer $level
     * @param  string $modifier [description]
     * @return boolean
     */
    public function level($level, $modifier = '>=')
    {
        $to_check = $this->getToCheck();

        $max = -1;
        $min = 100;
        $levels = array();

        foreach ($to_check->roles as $role)
        {
            $max = $role->level > $max
                ? $role->level
                : $max;

            $min = $role->level < $min
                ? $role->level
                : $min;

            $levels[] = $role->level;
        }

        switch ($modifier)
        {
            case '=':
                return in_array($level, $levels);
                break;

            case '>=':
                return $max >= $level;
                break;

            case '>':
                return $max > $level;
                break;

            case '<=':
                return $min <= $level;
                break;

            case '<':
                return $min < $level;
                break;

            default:
                return false;
                break;
        }
    }

    /**
     * Get to check
     *
     * @return object
     */
    private function getToCheck()
    {

        if(empty($this->to_check_cache))
        {
        	$key = static::getKeyName();
			
            $to_check = static::with(array('roles', 'roles.permissions'))
                ->where($key, '=', $this->attributes[$key])
                ->first();

            $this->to_check_cache = $to_check;
        }
        else
        {
            $to_check = $this->to_check_cache;
        }

        return $to_check;
    }

    /**
     * Verified scope
     *
     * @param  object $query
     * @return object
     */
    public function scopeVerified($query)
    {
        return $query->where('verified', '=', 1);
    }

    /**
     * Unverified scope
     *
     * @param  object $query
     * @return object
     */
    public function scopeUnverified($query)
    {
        return $query->where('verified', '=', 0);
    }

    /**
     * Disabled scope
     *
     * @param  object $query
     * @return object
     */
    public function scopeDisabled($query)
    {
        return $query->where('disabled', '=', 1);
    }

    /**
     * Enabled scope
     *
     * @param  object $query
     * @return object
     */
    public function scopeEnabled($query)
    {
        return $query->where('disabled', '=', 0);
    }
}
