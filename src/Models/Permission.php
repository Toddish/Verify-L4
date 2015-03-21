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
                \Config::get('verify::models.role'),
                $this->prefix.'permission_role'
            )
        ->withTimestamps();
    }
}
