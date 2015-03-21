<?php
namespace Toddish\Verify\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
	protected $prefix = '';

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);

		$this->prefix = \Config::get('verify.prefix', '');
		$this->table = $this->prefix . $this->getTable();
	}
}
