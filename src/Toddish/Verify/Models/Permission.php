<?php
namespace Toddish\Verify\Models;

class Permission extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    /**
     * Roles
     *
     * @return object
     */
    public function roles()
    {
        return $this->belongsToMany(
                'Toddish\Verify\Models\Role',
                $this->prefix.'permission_role'
            )
        ->withTimestamps();
    }
}