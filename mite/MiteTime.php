<?php

namespace Mite;

/**
 * Represents a mite time entry
 *
 * @author Stefan Pasch <stefan@codeschmiede.de>
 */
class MiteTime extends MiteEntity
{
	public $date_at = null;
	public $revenue = null;
	public $billable = null;
	public $note = null;
	public $user_id = null;
	public $user_name = null;
	public $project_id = null;
	public $project_name = null;
	public $service_id = null;
	public $service_name = null;
	public $customer_id = null;
	public $customer_name = null;
	public $locked = null;
	public $minutes = null;
	public $tracking = null;
}
