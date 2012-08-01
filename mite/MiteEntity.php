<?php

namespace Mite;

class MiteEntity
{
	public $id = null;
	public $created_at = null;
	public $updated_at = null;

	function __construct($data)
	{
		foreach ($data as $key => $val)
		{
			$this->{str_replace('-', '_', $key)} = $val;
		}
	}
}
