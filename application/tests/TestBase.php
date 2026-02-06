<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base test class for CodeIgniter application
 * Provides database transaction handling, common utilities, and test helpers
 */
class TestBase extends CI_Controller
{
    protected $CI;
    protected $testDb;
    protected $testData = [];
    
    public function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
        
        // Load test configuration
        $this->CI->load->config('test');
        
        // Initialize test database connection
        $this->initTestDatabase();
        
        // Load common models and helpers
        $this->CI->load->model('Admin_Login_Model');
        $this->CI->load->helper('custom');
    }
    
    /**
     * Initialize test database with transaction support
     */
    protected function initTestDatabase()
    {
        // Use test database configuration
        $testConfig = $this->CI->config->item('test_database');
        if ($testConfig) {
            $this->CI->db = $this->CI->load->database($testConfig, TRUE);
        }
        
        // Start transaction for each test
        $this->CI->db->trans_start();
    }
    
    /**
     * Clean up after each test
     */
    protected function tearDown()
    {
        // Rollback transaction
        $this->CI->db->trans_rollback();
        
        // Clear test data
        $this->testData = [];
    }
    
    /**
     * Create test user data
     */
    protected function createTestUser($data = [])
    {
        $defaultData = [
            'username' => 'test_user_' . uniqid(),
            'email' => 'test_' . uniqid() . '@example.com',
            'password' => 'test_password_123',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $userData = array_merge($defaultData, $data);
        $this->CI->db->insert('users', $userData);
        
        $this->testData['users'][] = $userData;
        return $this->CI->db->insert_id();
    }
    
    /**
     * Create test admin data
     */
    protected function createTestAdmin($data = [])
    {
        $defaultData = [
            'email' => 'admin_' . uniqid() . '@example.com',
            'password' => 'admin_password_123',
            'id' => 1,
            'status' => 'active'
        ];
        
        $adminData = array_merge($defaultData, $data);
        $this->CI->db->insert('admin', $adminData);
        
        $this->testData['admins'][] = $adminData;
        return $this->CI->db->insert_id();
    }
    
    /**
     * Create test game data
     */
    protected function createTestGame($data = [])
    {
        $defaultData = [
            'round_id' => 'TEST_' . uniqid(),
            'user_id' => 1,
            'amount' => 100,
            'status' => 'P',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $gameData = array_merge($defaultData, $data);
        $this->CI->db->insert('warli_users_game', $gameData);
        
        $this->testData['games'][] = $gameData;
        return $this->CI->db->insert_id();
    }
    
    /**
     * Assert database record exists
     */
    protected function assertRecordExists($table, $conditions)
    {
        $query = $this->CI->db->where($conditions)->get($table);
        $this->assertTrue($query->num_rows() > 0, "Record should exist in {$table}");
    }
    
    /**
     * Assert database record does not exist
     */
    protected function assertRecordNotExists($table, $conditions)
    {
        $query = $this->CI->db->where($conditions)->get($table);
        $this->assertTrue($query->num_rows() === 0, "Record should not exist in {$table}");
    }
    
    /**
     * Assert response contains expected data
     */
    protected function assertResponseContains($response, $expectedData)
    {
        foreach ($expectedData as $key => $value) {
            $this->assertArrayHasKey($key, $response, "Response should contain key: {$key}");
            $this->assertEquals($value, $response[$key], "Response value for {$key} should match");
        }
    }
    
    /**
     * Mock HTTP request
     */
    protected function mockRequest($method = 'GET', $data = [], $headers = [])
    {
        $_SERVER['REQUEST_METHOD'] = $method;
        $_POST = $method === 'POST' ? $data : [];
        $_GET = $method === 'GET' ? $data : [];
        $_REQUEST = array_merge($_GET, $_POST);
        
        // Set headers
        foreach ($headers as $key => $value) {
            $_SERVER['HTTP_' . strtoupper(str_replace('-', '_', $key))] = $value;
        }
    }
    
    /**
     * Basic assertion method
     */
    protected function assertTrue($condition, $message = '')
    {
        if (!$condition) {
            throw new Exception($message ?: 'Assertion failed');
        }
    }
    
    /**
     * Assert equals method
     */
    protected function assertEquals($expected, $actual, $message = '')
    {
        if ($expected !== $actual) {
            throw new Exception($message ?: "Expected {$expected}, got {$actual}");
        }
    }
    
    /**
     * Assert array has key method
     */
    protected function assertArrayHasKey($key, $array, $message = '')
    {
        if (!array_key_exists($key, $array)) {
            throw new Exception($message ?: "Array should contain key: {$key}");
        }
    }
}
