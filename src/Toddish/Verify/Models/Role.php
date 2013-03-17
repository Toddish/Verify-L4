<?php

namespace Toddish\Verify\Models;

class Role extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('name', 'description', 'level');

    /**
     * Users
     *
     * @return object
     */
    public function users()
    {
        return $this->has_many_and_belongs_to(
                'Toddish\Verify\Models\User',
                $this->prefix.'role_user'
            )
        ->withTimestamps();
    }

    /**
     * Permissions
     *
     * @return object
     */
    public function permissions()
    {
        return $this->has_many_and_belongs_to(
                'Toddish\Verify\Models\Permission',
                $this->prefix.'permission_role'
            )
        ->withTimestamps();
    }
}