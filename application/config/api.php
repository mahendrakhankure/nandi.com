<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Central HTTP client configuration
| - Timeouts, retries, and endpoint token mapping via environment variables
| -------------------------------------------------------------------------
*/

$config['http'] = array(
	'timeout' => 20,
	'connect_timeout' => 3,
	'retry' => array(
		'max_retries' => 3,
		'base_delay_ms' => 200,
		'max_delay_ms' => 2000,
		'retry_on_http_codes' => array(429, 500, 502, 503, 504)
	),
	'endpoints' => array(
		'kuberbets.com' => array('bearer_env' => 'KUBERBETS_TOKEN'),
		'kuberbets.vip' => array('bearer_env' => 'KUBERBETS_VIP_TOKEN'),
		'https://laxminarayan.live/api/sattaMatka' => array('bearer_env' => '2ba24f5e18fff8a504f84d22a2c160db'),
		'fairbets.ph' => array('bearer_env' => 'FAIRBETS_PH_TOKEN'),
		'admin999hanuman.com' => array('bearer_env' => 'ADMIN999HANUMAN_COM_TOKEN'),
		'admin999hanuman.vip' => array('bearer_env' => 'ADMIN999HANUMAN_VIP_TOKEN'),
		'fairbetsglobalstaging.xyz' => array('bearer_env' => 'FAIRBETSGLOBALSTAGING_TOKEN'),
		'kubergames.net' => array('bearer_env' => 'KUBERGAMES_TOKEN'),
		'fairbets.co' => array('bearer_env' => 'FAIRBETS_CO_TOKEN'),
		'node.dpbosses.live' => array('bearer_env' => 'DPBOSSES_NODE_TOKEN'),
		'matka.livedealersol.com' => array('bearer_env' => null),
		'api.ultramsg.com' => array('bearer_env' => 'ULTRAMSG_TOKEN')
	),
	'default_bearer_env' => '2ba24f5e18fff8a504f84d22a2c160db'
);


