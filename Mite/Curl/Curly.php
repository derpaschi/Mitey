<?php

namespace Mite\Curl;

use Mite\Curl\CurlyResponse;

class Curly
{
	/**
	 * cURL url to handle
	 * @var string
	 */
	protected $url = '';

	/**
	 * the cURL session handle
	 * @var mixed
	 */
	protected $handle = null;

	/**
	 * cURL request options
	 * @var array
	 */
	protected $options = array();

	/**
	 * extra heades for the request
	 * @var array
	 */
	protected $headers = array();

	/**
	 * cURL response
	 * @var mixed
	 */
	protected $response = null;

	/**
	 * cURL response infos
	 * @var mixed
	 */
	protected $response_infos = null;

	protected $response_error = null;
	protected $response_errno = null;

	function __construct($url = '')
	{
		if (!function_exists('curl_init'))
		{
			throw new \Exception('PHP was not built with cURL enabled.');
		}

		$url && $this->create($url);
	}

	public function create($url)
	{
		// TODO: check for valid url
		if ( /*TODO: not a valid url*/ false )
		{
			throw new \Exception('Not a valid url "'.$url.'".');
		}

		$this->url = $url;
		$this->handle = curl_init($url);

		return $this;
	}

	public function setOption($code, $value)
	{
		if (is_string($code) && !is_numeric($code))
		{
			if (!preg_match('/^CURLOPT\_/', $code))
			{
				$code = 'CURLOPT_'.$code;
			}

			$code = constant(strtoupper($code));
		}

		$this->options[$code] = $value;

		return $this;
	}

	public function setOptions(Array $options = array())
	{
		foreach ($options as $code => $val)
		{
			$this->setOption($code, $val);
		}

		if (count($this->options))
		{
			foreach ($this->options as $k => $v)
			{
				curl_setopt($this->handle, $k, $v);
			}
		}

		return $this;
	}

	public function setHeader($header, $content = false)
	{
		$this->headers[] = $content !== false ? $header . ': ' . $content : $header;

		return $this;
	}

	public function setMethod($method)
	{
		$this->setOption('CUSTOMREQUEST', strtoupper($method));

		return $this;
	}

	public function setSSL($verify_peer = true, $verify_host = 2, $ca_info = null)
	{
		if ($verify_peer)
		{
			$this->setOption('SSL_VERIFYPEER', true);
			$this->setOption('SSL_VERIFYHOST', $verify_host);
			$this->setOption('CAINFO', $ca_info);
		}
		else
		{
			$this->setOption('SSL_VERIFYPEER', false);
		}

		return $this;
	}

	public function setHttpLogin($login, $password, $type = 'any')
	{
		$this->setOption('HTTPAUTH', constant('CURLAUTH_' . strtoupper($type)));
		$this->setOption('USERPWD', $login . ':' . $password);
		return $this;
	}

	public function get(Array $params = array(), Array $options = array(), $url = false)
	{
		// set request url if given
		$url && $this->create($url);

		if (count($params))
		{
			$this->url .= (strpos($this->url, '?') ? '&' : '?') . http_build_query($params, null, '&');
		}

		return $this->doRequest($options);
	}

	public function post($body = '', Array $options = array(), $url = false)
	{
		$url && $this->create($url);

		if (empty($body))
		{
			throw new \Exception('Nothing to POST, $body is empty!');
		}

		$length = strlen($body);

		$this->setOption('POST', true);
		$this->setMethod('post');
		$this->setHeader('Content-Length', $length);
		$this->setOption('POSTFIELDS', $body);

		return $this->doRequest($options);
	}

	public function put($body = '', Array $options = array(), $url = false)
	{
		$url && $this->create($url);

		if (empty($body))
		{
			throw new \Exception('Nothing to PUT, $body is empty!');
		}

		$length = strlen($body);

		$this->setMethod('put');

		$this->setHeader('Content-Length', $length);
		$this->setOption('POSTFIELDS', $body);

		return $this->doRequest($options);
	}

	public function delete(Array $params = array(), Array $options = array(), $url = false)
	{
		$url && $this->create($url);

		if (count($params))
		{
			$this->setOption('POSTFIELDS', http_build_query($params, null, '&'));
		}

		$this->setMethod('delete');

		return $this->doRequest($options);
	}

	/**
	 * executes request and returns the response
	 *
	 * @param array $options
	 * @return CurlyResponse
	 */
	private function doRequest(Array $options = array())
	{
		$this->setDefaultOptions();

		if (!empty($this->headers))
		{
			$this->setOption('HTTPHEADER', $this->headers);
		}

		$this->setOptions($options);

		$this->response = curl_exec($this->handle);
		$this->response_infos = curl_getinfo($this->handle);

		$response = new CurlyResponse();

		if ($this->response === false)
		{
			$response->error = curl_error($this->handle);
			$response->errno = curl_errno($this->handle);
		}
		else
		{
			$response->response = $this->response;
			$response->infos = $this->response_infos;
		}

		curl_close($this->handle);

		$this->reset();

		return $response;
	}

	private function setDefaultOptions()
	{
		$defaults = array(
			CURLOPT_TIMEOUT => 30,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FAILONERROR => true,
			// CURLOPT_FOLLOWLOCATION => true
		);

		foreach ($defaults as $code => $val)
		{
			if (!isset($this->options[$code]))
			{
				$this->setOption($code, $val);
			}
		}
	}

	private function reset()
	{
		$this->options = array();
		$this->headers = array();
		$this->handle = null;
		$this->response = null;
		$this->response_errno = null;
		$this->response_error = null;
		$this->response_infos = null;
		$this->url = null;
	}


}