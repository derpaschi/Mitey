<?php

namespace Mite;

/**
 * Represents a mite Service and all its properties
 *
 * @author Stefan Pasch <stefan@codeschmiede.de>
 */
class MiteService extends MiteEntity
{
	public $name = null;
	public $note = null;
	public $billable = null;
	public $hourly_rate = null;
	public $archived = null;
}
