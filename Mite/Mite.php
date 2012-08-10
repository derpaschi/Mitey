<?php

namespace Mite;

use Mite\Rest\Resty;
use Mite\MiteException;
use Mite\MiteEntity;
use Mite\MiteCustomerIterator;
use Mite\MiteCustomer;
use Mite\MiteProjectIterator;
use Mite\MiteProject;
use Mite\MiteAccount;
use Mite\MiteUserIterator;
use Mite\MiteUser;
use Mite\MiteTimeIterator;
use Mite\MiteTime;

/**
 * mite API Wrapper
 *
 * provides easy access to the mite API.
 *
 * @see http://mite.yo.lk/api/index.html
 * @author Stefan Pasch <stefan@codeschmiede.de>
 */
class Mite
{
	/**
	 * Your mite address
	 * @var string
	 */
	protected $address = null;

	/**
	 * Your mite API key
	 * @var string
	 */
	protected $apiKey  = null;

	/**
	 * Resty instance
	 * @var Resty
	 */
	private $Resty = null;

	function __construct($address, $apiKey, $agent = 'Mitey/v0.1')
	{
		// check for Resty, we need it!
		if (!class_exists('Mite\Rest\Resty'))
		{
			throw new \Exception('Needed class "Resty" does not exist.');
		}

		$this->address = $address;
		$this->apiKey  = $apiKey;

		$this->Resty = new Resty($this->address, 'json');

		$this->Resty->setHeader('X-MiteApiKey', $this->apiKey)
					->setHeader('User-Agent', $agent)
					// TODO set correct ssl data
					->setSSL(false);
	}

	/**
	 * Get array of mite customers by defined filters
	 *
	 * @param string $name
	 * @param int $limit
	 * @param int $offset
	 *
	 * @return MiteCustomerIterator
	 */
	public function getCustomers($name = '', $limit = false, $offset = false)
	{
		return $this->getEntities(
			'customers.json',
			'MiteCustomerIterator',
			'MiteCustomer',
			'customer',
			array('name' => $name),
			$limit,
			$offset
		);
	}

	/**
	 * Generic method to fetch different types of entities of the mite API
	 *
	 * @param string $endpoint			API url
	 * @param string $iterator			Classname of the returned iterator class
	 * @param string $entity_class		Classname of intatiated entity type
	 * @param string $property			Property name of returned API response
	 * @param array $params				Filter properties
	 * @param int $limit
	 * @param int $offset
	 */
	private function getEntities($endpoint, $iterator = 'ArrayIterator', $entity_class = 'MiteEntity', $property = '', Array $params = array(), $limit = false, $offset = false)
	{
		$limit && $params['limit'] = $limit;
		$offset && $params['page'] = $offset;

		try
		{
			$response = $this->Resty->get($endpoint, $params);

			if (!is_array($response))
			{
				throw new MiteException(__FUNCTION__.'(): No response from REST interface.');
			}

			$iterator = '\\Mite\\'.$iterator;
			$entity_class = '\\Mite\\'.$entity_class;
			$entities = new $iterator();
			foreach ($response as $r)
			{
				$entities->append(new $entity_class($r->$property));
			}

			return $entities;
		}
		catch (\Exception $e)
		{
			throw new MiteException($e->getMessage());
		}
	}

	/**
	 * Get specified customer object
	 *
	 * @param int $id The customer id
	 * @return MiteCustomer
	 */
	public function getCustomer($id)
	{
		return $this->getEntity('customers/'.$id.'.json', 'customer', 'MiteCustomer');
	}

	/**
	 * Get specified project object
	 *
	 * @param int $id The project id
	 * @return MiteProject
	 */
	public function getProject($id)
	{
		return $this->getEntity('projects/'.$id.'.json', 'project', 'MiteProject');
	}

	/**
	 * Get specified entity object
	 *
	 * @param string $endpoint
	 * @param string $property
	 * @param string $entity_class
	 */
	private function getEntity($endpoint, $property, $entity_class = 'MiteEntity')
	{
		try
		{
			$response = $this->Resty->get($endpoint);
			if ($response->$property)
			{
				$entity_class = '\\Mite\\'.$entity_class;
				return new $entity_class($response->$property);
			}
		}
		catch(\Exception $e) {}

		throw new MiteException('Entity of type '.ucfirst($property).' not found (Endpoint: '.$endpoint.').');
	}

	/**
	 * API Testing Customer ID 170653
	 *	default note: Testkunde zum Testen und Entwickeln der API Anbindung zu facturandum.
	 *
	 * Update customer data
	 *
	 * @param int $id		the customer id
	 * @param Array $data	data to be updated
	 * @return boolean
	 */
	public function updateCustomer($id, Array $data)
	{
		return $this->updateEntity('customers/'.$id.'.json', array('customer' => $data));
	}

	/**
	 * Update project data
	 *
	 * @param int $id		the project id
	 * @param Array $data	data to be updated
	 * @return boolean
	 */
	public function updateProject($id, Array $data)
	{
		return $this->updateEntity('projects/'.$id.'.json', array('project' => $data));
	}

	/**
	 * Update specified mite entity
	 *
	 * @param string $endpoint
	 * @param Array $data
	 * @throws MiteException
	 * @return boolean;
	 */
	private function updateEntity($endpoint, Array $data)
	{
		try
		{
			$response = $this->Resty->put($endpoint, $data);
			if ($this->Resty->getInfo('http_code') == '200')
			{
				return true;
			}
		}
		catch (\Exception $e)
		{
			throw new MiteException('Entity update failed. '.$e->getMessage());
		}
	}

	/**
	 * Add a new customer
	 *
	 * @param array $data 	Associative array with customer data to be saved
	 * 						Take a look at http://mite.yo.lk/api/kunden.html for parameters
	 * @return MiteCustomer
	 */
	public function addCustomer(Array $data)
	{
		return $this->addEntity('customers.json', array('customer' => $data), 'customer');
	}

	/**
	 * Add a new project
	 *
	 * @param array $data 	Associative array with project data to be saved
	 * 						Take a look at http://mite.yo.lk/api/projekte.html for parameters
	 * @return MiteProject
	 */
	public function addProject(Array $data)
	{
		return $this->addEntity('projects.json', array('project' => $data), 'project');
	}

	/**
	 * Add entity
	 *
	 * @param string $endpoint
	 * @param array $params
	 * @param string $prop
	 */
	private function addEntity($endpoint, Array $params = array(), $prop = '', $entity_class = false)
	{
		try
		{
			$response = $this->Resty->post($endpoint, $params);

			if ($this->Resty->getInfo('http_code') == '201')
			{
				if ($entity_class)
				{
					$entity_class = '\\Mite\\'.$entity_class;
					return new $entity_class($response->$prop);
				}

				return $response->$prop;
			}
		}
		catch(\Exception $e)
		{
			throw new MiteException('Entity couldn\'t be added ('.$e->getMessage().').');
		}

		return false;
	}

	/**
	 * Delete specified customer
	 *
	 * @param int $id
	 * @return boolean
	 */
	public function deleteCustomer($id)
	{
		return $this->deleteEntity('customers/'.$id.'.json');
	}

	/**
	 * Delete specified project
	 *
	 * @param int $id
	 * @return boolean
	 */
	public function deleteProject($id)
	{
		return $this->deleteEntity('projects/'.$id.'.json');
	}

	/**
	 * Deletes a entity
	 *
	 * @param string $endpoint
	 * @throws MiteException
	 * @return boolean
	 */
	private function deleteEntity($endpoint)
	{
		try
		{
			$response = $this->Resty->delete($endpoint);
			if ($this->Resty->getInfo('http_code') == '200')
			{
				return true;
			}
		}
		catch (\Exception $e)
		{
			throw new MiteException('Entity deletion failed "'.$endpoint.'" ('.$e->getMessage().').');
		}

		return false;
	}

	/**
	 * Get all projects by defined filters
	 *
	 * @param string $name
	 * @param int $limit
	 * @param int $offset
	 */
	public function getProjects($name = '', $limit = false, $offset = false)
	{
		return $this->getEntities(
			'projects.json',
			'MiteProjectIterator',
			'MiteProject',
			'project',
			array('name' => $name),
			$limit,
			$offset
		);
	}

	/**
	 * Get all archived projects
	 *
	 * @param string $name
	 * @return MiteProjectIterator
	 */
	public function getArchivedProjects($name = '')
	{
		return $this->getEntities(
			'projects/archived.json',
			'MiteProjectIterator',
			'MiteProject',
			'project',
			array('name' => $name)
		);
	}

	/**
	 * Get current used mite account infos
	 *
	 * @return MiteAccount
	 */
	public function getAccount()
	{
		return $this->getEntity('account.json', 'account');
	}

	/**
	 * Get current logged user
	 *
	 * @return MiteUser
	 */
	public function getMyself()
	{
		return $this->getEntity('myself.json', 'user');
	}

	/**
	 * Get time entries by defined filters
	 *
	 * @param Array $customers	array of customer id's
	 * @param Array $projects	array of project id's
	 * @param Array $services	array of service id's
	 * @param Array $users		array of user id's
	 * @param boolean $billable	true: return only billable entries, false: return only not billable entries, null return all
	 * @param string $note		will search in notes field of time entries
	 * @param string $at		today, yesterday, this_week, last_week, this_month, last_month or date in format YYYY-MM-DD or false
	 * @param string $from		date in format YYYY-MM-DD or false
	 * @param string $to		date in format YYYY-MM-DD or false
	 * @param boolean $locked	true: return only locked, false: return only unlocked, null: return all
	 * @param int $limit		optional limit
	 * @param int $offset		optional offset
	 *
	 * @return MiteTimeIterator
	 */
	public function getTimes(Array $customers = array(), Array $projects = array(), Array $services = array(),
							 Array $users = array(), $billable = null, $note = false, $at = false, $from = false,
							 $to = false, $locked = null, $limit = false, $offset = false)
	{
		$params = array();

		// produce proper filter array
		!empty($customers) && $params['customer_id'] = implode(',', $customers);
		!empty($projects) && $params['project_id'] = implode(',', $projects);
		!empty($services) && $params['service_id'] = implode(',', $services);
		!empty($users) && $params['user_id'] = implode(',', $users);
		($billable !== null) && $params['billable'] = $billable;
		$note && $params['note'] = $note;

		preg_match('/^today|yesterday|this_week|this_month|last_month|\d{4}-\d{2}-\d{2}$/', $at) && $params['at'] = $at;
		preg_match('/^\d{4}-\d{2}-\d{2}$/', $from) && $params['from'] = $from;
		preg_match('/^\d{4}-\d{2}-\d{2}$/', $to) && $params['to'] = $to;
		($locked !== null) && $params['locked'] = $locked;

		return $this->getEntities(
			'time_entries.json',
			'MiteTimeIterator',
			'MiteTime',
			'time_entry',
			$params,
			$limit,
			$offset
		);
	}

	/**
	 * Add a new time entry
	 *
	 * @param string $date
	 * @param int $minutes
	 * @param string $note
	 * @param int $user
	 * @param int $project
	 * @param int $service
	 *
	 * @return MiteTime
	 */
	public function addTime($date = false, $minutes = false, $note = false, $user = false, $project = false, $service = false)
	{
		$params = array();

		($date && preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) && $params['date_at'] = $date;
		$minutes && $params['minutes'] = $minutes;
		$note && $params['note'] = $note;
		$user && $params['user_id'] = $user;
		$project && $params['project_id'] = $project;
		$service && $params['service_id'] = $service;

		return $this->addEntity('time_entries.json', array('time-entry' => $params), 'time_entry', 'MiteTime');
	}

	/**
	 * Update existing time entry
	 *
	 * @param int $id
	 * @param string $date
	 * @param int $minutes
	 * @param string $note
	 * @param int $user
	 * @param int $project
	 * @param int $service
	 */
	public function updateTime($id, $date = false, $minutes = false, $note = false, $user = false, $project = false, $service = false)
	{
		$params = array();

		($date && preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) && $params['date_at'] = $date;
		$minutes && $params['minutes'] = $minutes;
		$note && $params['note'] = $note;
		$user && $params['user_id'] = $user;
		$project && $params['project_id'] = $project;
		$service && $params['service_id'] = $service;

		return $this->updateEntity('time_entries/'.$id.'.json', array('time-entry' => $params));
	}

	/**
	 * Delete a existing time entry
	 *
	 * @param int $id
	 */
	public function deleteTime($id)
	{
		return $this->deleteEntity('time_entries/'.$id.'.json');
	}

	/**
	 * Get users
	 *
	 * @param string $name
	 * @param string $email
	 * @param int $limit
	 * @param int $offset
	 */
	public function getUsers($name = false, $email = false, $limit = false, $offset = false)
	{
		$params = array();

		$name && $params['name'] = $name;
		$email && $params['email'] = $email;
		$limit && $params['limit'] = $limit;
		$offset && $params['offset'] = $offset;

		return $this->getEntities(
			'users.json',
			'MiteUserIterator',
			'MiteUser',
			'user',
			$params,
			$limit,
			$offset
		);
	}

	/**
	 * Get a specified mite User
	 *
	 * @param int $id
	 */
	public function getUser($id)
	{
		return $this->getEntity('users/'.$id.'.json', 'user', 'MiteUser');
	}
}

spl_autoload_register(function($class) {
	$file = implode(DIRECTORY_SEPARATOR, explode('\\', ltrim($class, '\\')));
	$path = dirname(__DIR__) . DIRECTORY_SEPARATOR . $file . '.php';
	if(file_exists($path)) include $path;
	else throw new \Exception ('Can\'t load needed library "' . $path . '"');
});

