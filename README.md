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
test some methods and check the response values this script provides.

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
$customers = $mite->getCustomers(); // will return a iterator object
for ($customers->rewind(); $customers->valid(); $customers->next())
{
	$customer = $customers->current();
	echo $customer->name . "<br />";
}
```

The following methods will return php iterator objects
```php
<?php
$mite->getArchivedProjects();
$mite->getCustomers();
$mite->getProjects();
$mite->getTimes();
$mite->getUsers();
```

Contact
-------
In case you wanna get in touch, it's easy!
* Twitter: [@hubeRsen](http://twitter.com/hubeRsen)
* Website: [http://codeschmiede.de](http://codeschmiede.de)
* E-mail: [stefan@codeschmiede.de](mailto:stefan@codeschmiede.de)
