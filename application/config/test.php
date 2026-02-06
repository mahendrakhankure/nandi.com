<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Test Configuration
|--------------------------------------------------------------------------
| Configuration for testing environment
|
*/

// Test database configuration
$config['test_database'] = array(
    'dsn'          => '',
    'hostname'     => 'localhost',
    'username'     => 'root',
    'password'     => '',
    'database'     => 'nandi_test', // Separate test database
    'dbdriver'     => 'mysqli',
    'dbprefix'     => '',
    'pconnect'     => FALSE,
    'db_debug'     => FALSE, // Disable debug in tests
    'cache_on'     => FALSE,
    'cachedir'     => '',
    'char_set'     => 'utf8',
    'dbcollat'     => 'utf8_general_ci',
    'swap_pre'     => '',
    'encrypt'      => FALSE,
    'compress'     => FALSE,
    'stricton'     => FALSE,
    'failover'     => array(),
    'save_queries' => FALSE
);

// Test-specific settings
$config['test'] = array(
    'enable_logging' => FALSE,
    'mock_external_apis' => TRUE,
    'test_timeout' => 30,
    'fixtures_path' => APPPATH . 'tests/fixtures/',
    'coverage_enabled' => FALSE
);

// Mock external API responses for testing
$config['mock_responses'] = array(
    'kuberbets.com' => array(
        'status' => 'success',
        'data' => array(
            'result' => '123',
            'time' => '2024-01-01 12:00:00'
        )
    ),
    'kuberbets.vip' => array(
        'status' => 'success',
        'data' => array(
            'result' => '456',
            'time' => '2024-01-01 12:00:00'
        )
    ),
    'laxminarayan.live' => array(
        'status' => 'success',
        'data' => array(
            'result' => '789',
            'time' => '2024-01-01 12:00:00'
        )
    )
);

// Test user credentials
$config['test_users'] = array(
    'admin' => array(
        'email' => 'test_admin@example.com',
        'password' => 'test_admin_password'
    ),
    'user' => array(
        'username' => 'test_user',
        'email' => 'test_user@example.com',
        'password' => 'test_user_password'
    )
);
