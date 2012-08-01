<?php

namespace Mite;

/**
 * Represents a mite Project and all its properties
 *
 * @author Stefan Pasch <stefan@codeschmiede.de>
 */
class MiteProject extends MiteEntity
{
	public $name = null;
	public $note = null;
	public $budget = null;
	public $budget_type = null;
	public $archived = null;
	public $customer_id = null;
	public $customer_name = null;
	public $hourly_rate = null;
	public $active_hourly_rate = null;
	public $hourly_rates_per_service = null;
}
