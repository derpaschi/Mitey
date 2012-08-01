<?php

namespace Mite;

class MiteUserIterator extends \ArrayIterator
{
	/**
	 * @return MiteUser
	 */
	public function current()
	{
		return parent::current();
	}
}
