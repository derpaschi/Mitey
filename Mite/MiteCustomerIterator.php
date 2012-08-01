<?php

namespace Mite;

class MiteCustomerIterator extends \ArrayIterator
{
	/**
	 * @return MiteCustomer
	 */
	public function current()
	{
		return parent::current();
	}
}
