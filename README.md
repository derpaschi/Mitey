Mitey - PHP Wrapper for the mite API
====================================
This script provides easy access to the [mite API](http://mite.yo.lk/api/index.html) via php objects. You'll be able to use code hinting in your IDE.

Requirements
------------
Mitey requires the following
* PHP 5.3.0 or higher
* PHP cURL

Quick start
-----------
Clone this repo into any webserver and call `examples/index.php`, there you can put in your mite API credentials and
test some methods and check the response values this script provides. If you are, for whatever reason, not able to
clone this, you can go to [http://dev.codeschmiede.de/Mitey/examples/](http://dev.codeschmiede.de/Mitey/examples/) for the example page.

Usage
-----
```php
<?php
// include the Mite class
require_once 'mite/Mite.php';
// instantiate the object with your credentials
$mite = new Mite\Mite('YOUR-MITE-API-ENDPOINT', 'YOUR-MITE-API-KEY');
```

Now you have access to all methods the mite API has, for example get objects of all your customers
```php
<?php
$customers = $mite->getCustomers();
for ($customers->rewind(); $customers->valid(); $customers->next())
{
	$customer = $customers->current();
	echo $customer->name . "<br />";
}

// all this methods will return iterator objects
$iterator = $mite->getArchivedProjects();
$iterator = $mite->getCustomers();
$iterator = $mite->getProjects();
$iterator = $mite->getTimes();
$iterator = $mite->getGroupedTimes(array('week, project'));
$iterator = $mite->getUsers();
```

Get customer details of a specified account
```php
<?php
$customer = $mite->getCustomer(1234); // 1234 is the needed customer id
// $customer contains a object of type MiteCustomer
```

Add new stuff to your mite account (customers, projects, times)
```php
<?php
// new customer
$newCustomer = $mite->addCustomer(array(
	'name' => 'My new customer name',
	'note' => 'Generated via Mitey, totally easy. Whoop whoop.'
));

// new project
$newProject = $mite->addProject(array(
	'name' => 'My brand new project',
	'note' => 'Generated via Mitey, totally easy. Whoop whoop.',
	'customer_id' => $newCustomer->id
));

// new time entry
$newtime = $mite->addTime(
	date('Y-m-d'), 			// date of time entry
	666, 					// time in seconds
	'My workdescription, created via Mitey, whoop whoop.',
	$mite->getMyself()->id,	// user id
	$newProject->id,		// optional: project id
	false					// optional: service id
);
```

Look into the code `Mite/Mite.php` for a complete list of methods this library provides.

Contact
-------
In case you wanna get in touch, it's easy!
* Twitter: [@hubeRsen](http://twitter.com/hubeRsen)
* Website: [http://codeschmiede.de](http://codeschmiede.de)
* E-mail: [stefan@codeschmiede.de](mailto:stefan@codeschmiede.de)
