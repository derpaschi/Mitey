<?php

namespace Mite;

class MiteTimeIterator extends \ArrayIterator
{
	/**
	 * @return MiteTime
	 */
	public function current()
	{
		return parent::current();
	}
}
