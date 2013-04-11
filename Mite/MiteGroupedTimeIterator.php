<?php

namespace Mite;

class MiteGroupedTimeIterator extends \ArrayIterator
{
	/**
	 * @return MiteTime
	 */
	public function current()
	{
		return parent::current();
	}
}
