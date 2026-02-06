<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HttpClient
{
	/** @var CI_Controller */
	protected $ci;

	/** @var array */
	protected $config;

	public function __construct()
	{
		$this->ci = &get_instance();
		$this->ci->load->config('api');
		$this->config = $this->ci->config->item('http');
	}

	public function post($url, $data = array(), $headers = array())
	{
		return $this->request('POST', $url, $data, $headers);
	}

	public function get($url, $headers = array())
	{
		return $this->request('GET', $url, array(), $headers);
	}

	protected function request($method, $url, $data = array(), $headers = array())
	{
		$retry = isset($this->config['retry']) ? $this->config['retry'] : array();
		$maxRetries = isset($retry['max_retries']) ? (int)$retry['max_retries'] : 0;
		$baseDelay = isset($retry['base_delay_ms']) ? (int)$retry['base_delay_ms'] : 100;
		$maxDelay = isset($retry['max_delay_ms']) ? (int)$retry['max_delay_ms'] : 1000;
		$retryOn = isset($retry['retry_on_http_codes']) ? $retry['retry_on_http_codes'] : array();

		$attempt = 0;
		do {
			$attempt++;
			$response = $this->sendOnce($method, $url, $data, $headers);
			$code = isset($response['code']) ? (int)$response['code'] : 0;
			if ($code && !in_array($code, $retryOn)) {
				return $response;
			}
			if ($attempt > $maxRetries) {
				return $response;
			}
			$delay = min($maxDelay, $baseDelay * pow(2, $attempt - 1));
			usleep($delay * 1000);
		} while (true);
	}

	protected function sendOnce($method, $url, $data = array(), $headers = array())
	{
		$timeout = isset($this->config['timeout']) ? (int)$this->config['timeout'] : 20;
		$connectTimeout = isset($this->config['connect_timeout']) ? (int)$this->config['connect_timeout'] : 3;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_ENCODING, '');
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connectTimeout);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

		$normalizedHeaders = $this->injectAuthHeader($url, $headers);
		if (!empty($normalizedHeaders)) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $normalizedHeaders);
		}

		if (strtoupper($method) === 'POST') {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}

		$body = curl_exec($ch);
		$error = curl_error($ch);
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if ($error) {
			return array('code' => 0, 'error' => $error, 'body' => null);
		}
		return array('code' => $code, 'error' => null, 'body' => $body);
	}

	protected function injectAuthHeader($url, $headers)
	{
		$byHost = isset($this->config['endpoints']) ? $this->config['endpoints'] : array();
        echo "<pre>";
        print_r($url);
        print_r($byHost);
        die();
		$defaultEnv = isset($this->config['default_bearer_env']) ? $this->config['default_bearer_env'] : null;

		$parsed = parse_url($url);
		$host = isset($parsed['host']) ? $parsed['host'] : '';
		$bearer = null;
		if (isset($byHost[$host]) && isset($byHost[$host]['bearer_env']) && $byHost[$host]['bearer_env']) {
			$envKey = $byHost[$host]['bearer_env'];
			$bearer = getenv($envKey) ?: null;
		}
		if (!$bearer && $defaultEnv) {
			$bearer = getenv($defaultEnv) ?: null;
		}
        
		$normalized = array();
		$hasAuth = false;
		foreach ($headers as $h) {
			if (stripos($h, 'authorization:') === 0) {
				$hasAuth = true;
			}
			$normalized[] = $h;
		}
		if ($bearer && !$hasAuth) {
			$normalized[] = 'Authorization: Bearer '.$bearer;
		}
		return $normalized;
	}
}


