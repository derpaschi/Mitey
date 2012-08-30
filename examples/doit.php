<?php

// check input params
$endpoint = $_POST['api_endpoint'];
$key = $_POST['api_key'];
if (!isset($endpoint) || empty($endpoint) || !isset($key) || empty($key))
{
	die('Please provide your api credentials!');
}

require_once '../Mite/Mite.php';
$mite = new Mite\Mite($endpoint, $key);

function outputKeyVal($o)
{
	echo "<table><thead><tr><th>Key</th><th>Value</th></tr></thead><tbody>";
	foreach ($o as $k => $v)
	{
		echo "<tr><td>$k</td><td>";
		if (is_object($v))
		{
			outputKeyVal($v);
		}
		else
		{
			echo $v;
		}
		echo "</td></tr>";
	}
	echo "</tbody></table>";
}

try
{
	switch($_POST['method'])
	{
		case 'account':
			$acc = $mite->getAccount();
			outputKeyVal($acc);
			break;
		case 'customers':
		case 'projects':
		case 'users':
		case 'services':
			$name = $_POST['name'] ? $_POST['name'] : '';
			$email = (isset($_POST['email']) && $_POST['email']) ? $_POST['email'] : false;
			$limit = $_POST['limit'] ? $_POST['limit'] : false;
			$offset = $_POST['offset'] ? $_POST['offset'] : false;

			if ($_POST['method'] == 'customers') $e = $mite->getCustomers($name, $limit, $offset);
			elseif ($_POST['method'] == 'projects')  $e = $mite->getProjects($name, $limit, $offset);
			elseif ($_POST['method'] == 'users')  $e = $mite->getUsers($name, $email, $limit, $offset);
			elseif ($_POST['method'] == 'services')  $e = $mite->getServices($name, $limit, $offset);

			for ($e->rewind(); $e->valid(); $e->next())
			{
				outputKeyVal($e->current());
			}
			break;
		case 'times':

			$e = $mite->getTimes(array(), array(), array(), array(), null, false, false, false, false, null, 5, false);
			for ($e->rewind(); $e->valid(); $e->next())
			{
				outputKeyVal($e->current());
			}
			break;

	}
}
catch(Exception $e)
{
	die('ERROR: '.$e->getMessage());
}



