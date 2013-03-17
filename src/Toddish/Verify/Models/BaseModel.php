<?php

namespace Toddish\Verify\Models;

class BaseModel extends \Eloquent
{
    /**
     * Table prefix
     *
     * @var string
     */
    protected $prefix = '';

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        // Set the prefix
        $this->prefix = \Config::get('verify::prefix', 'test');
    }

    /**
     * Get the table name
     *
     * @return string
     */
    protected function getTableName()
    {
        return $this->prefix.parent::table();
    }
}