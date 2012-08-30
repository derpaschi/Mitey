<?php

namespace Mite;

class MiteServiceIterator extends \ArrayIterator
{
	/**
	 * @return MiteService
	 */
	public function current()
	{
		return parent::current();
	}
}
