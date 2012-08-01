<?php

namespace Mite\Rest;

use Mite\Curl\Curly;

class Resty
{
	protected $server = '';

	/**
	 * Reference to Curly instance
	 * @var Curly
	 */
	protected $Curly = null;

	protected $format = '';

	protected $mimes = array(
		'json' => 'application/json',
		'xml'  => 'application/xml'
	);

	protected $headers = array();
	protected $options = array();
	protected $httpLogin = false;
	protected $httpPass  = false;
	protected $httpAuth  = false;

	protected $sslPeer = null;
	protected $sslHost = null;
	protected $sslCa   = null;

	/**
	 * cURL response object
	 * @var CurlyResponse
	 */
	protected $response = null;

	/**
	 * initialize REST client with optional parameters
	 *
	 * @param string $server	Restserver name
	 * @param string $format	The format of request and response strings, possible types: json, xml
	 * @param string $auth		optional auth type (ANY, BASIC, DIGEST, GSSNEGOTIATE, NTLM, ANYSAFE)
	 * @param string $user		Username
	 * @param string $pass		Password
	 */
	function __construct($server, $format, $user = '', $pass = '', $auth = '')
	{
		if (!class_exists('Mite\Curl\Curly'))
		{
			throw new \Exception('Required cURL Library "Curly" not exists.');
		}

		if (!empty($server))
		{
			if (substr($server, -1, 1) != '/')
			{
				$server .= '/';
			}

			$this->server = $server;
		}

		if (!empty($user) && !empty($pass))
		{
			$this->httpLogin($user, $pass, $auth);
		}

		$this->Curly = new Curly();

		$this->format = $format;
	}

	public function httpLogin($login, $password, $type = 'any')
	{
		$this->httpLogin = $login;
		$this->httpPass  = $password;
		$this->httpAuth  = $type;

		return $this;
	}

	public function setFormat($format)
	{
		if (!array_key_exists($format, $this->mimes))
		{
			throw new \Exception('Format "'.$format.'" is not supported');
		}

		$this->format = $format;
	}

	public function get($uri, Array $params = array())
	{
		if (!empty($params))
		{
			$uri .= (strpos($uri, '?') ? '&' : '?') . http_build_query($params);
		}

		return $this->doRequest('get', $uri);
	}

	public function post($uri, $params = array())
	{
		$body = $this->formatParams($params);

		return $this->doRequest('post', $uri, $body);
	}

	public function delete($uri, Array $params = array())
	{
		return $this->doRequest('delete', $uri, $params);
	}

	public function put($uri, $params = array())
	{
		$body = $this->formatParams($params);

		return $this->doRequest('put', $uri, $body);
	}

	private function formatParams($params)
	{
		switch ($this->format)
		{
			case 'json':
				return json_encode($params);
				break;

			case 'xml':
				// TODO format xml stuff here
				break;
		}
	}

	public function setSSL($verify_peer = true, $verify_host = 2, $ca_info = null)
	{
		$this->sslPeer = $verify_peer;
		$this->sslHost = $verify_host;
		$this->sslCa   = $ca_info;

		return $this;
	}

	private function doRequest($method, $uri, $params = array())
	{
		$this->Curly->create($this->server.$uri);

		if (!empty($this->format))
		{
			$this->Curly->setHeader('Accept', $this->mimes[$this->format]);
			$this->Curly->setHeader('Content-type', $this->mimes[$this->format]);
		}

		if ($this->sslPeer !== null)
		{
			$this->Curly->setSSL($this->sslPeer, $this->sslHost, $this->sslCa);
		}

		if ($this->httpLogin !== false)
		{
			$this->Curly->setHttpLogin($this->httpLogin, $this->httpPass, $this->httpAuth);
		}

		foreach ($this->headers as $name => $val)
		{
			$this->Curly->setHeader($name, $val);
		}

		foreach ($this->options as $name => $val)
		{
			$this->Curly->setOption($name, $val);
		}

		$this->response = $this->Curly->{$method}($params);

		return $this->formatResponse();
	}

	private function formatResponse()
	{
		if ($this->response->response === false)
		{
			throw new \Exception('cURL returned an error: '.$this->response->error.'.');
		}

		if (empty($this->response->response))
		{
			return array();
		}

		switch ($this->format)
		{
			case 'json':
				return json_decode($this->response->response);
				break;

			case 'xml':
				return simplexml_load_string($this->response->response, 'SimpleXMLElement', LIBXML_NOCDATA);
				break;
		}
	}

	public function getInfo($key = '')
	{
		if (array_key_exists($key, $this->response->infos))
		{
			return $this->response->infos[$key];
		}

		return $this->response->infos;
	}

	public function getStatus()
	{
		return $this->getInfo('http_code');
	}

	public function setOption($name, $val)
	{
		$this->options[$name] = $val;
		return $this;
	}

	public function setHeader($name, $val)
	{
		$this->headers[$name] = $val;
		return $this;
	}
}