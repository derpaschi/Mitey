<?php

namespace Mite;

/**
 * Represents the current loggedin user
 *
 * @author Stefan Pasch <stefan@codeschmiede.de>
 */
class MiteUser extends MiteEntity
{
	public $name = null;
	public $email = null;
	public $note = null;
	public $archived = null;
	public $role = null;
	public $language = null;
}
