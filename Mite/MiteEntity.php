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
			if ($key == "time_entries_params") {
				$this->time_entries_params = array();
				foreach ($val as $filter_key => $filter_value) {
					$this->time_entries_params[$filter_key] = $filter_value;
				}
			} else {
				$this->{str_replace('-', '_', $key)} = $val;
			}
		}
	}
}
