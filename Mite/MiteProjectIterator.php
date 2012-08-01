<?php

namespace Mite;

class MiteProjectIterator extends \ArrayIterator
{
	/**
	 * @return MiteProject
	 */
	public function current()
	{
		return parent::current();
	}
}
