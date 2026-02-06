<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Unit tests for custom_helper.php
 * Tests database operations and HTTP client functionality
 */
class CustomHelperTest extends TestBase
{
    protected $testTable = 'test_table';
    
    public function __construct()
    {
        parent::__construct();
        
        // Create test table
        $this->createTestTable();
    }
    
    /**
     * Create test table for database operations
     */
    protected function createTestTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS {$this->testTable} (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255),
            email VARCHAR(255),
            status ENUM('active', 'inactive') DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->CI->db->query($sql);
    }
    
    /**
     * Test getRecordById function with valid data
     */
    public function testGetRecordById()
    {
        // Insert test data
        $testData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'status' => 'active'
        ];
        $this->CI->db->insert($this->testTable, $testData);
        $insertId = $this->CI->db->insert_id();
        
        // Test getRecordById
        $result = getRecordById($this->testTable, 'id', $insertId);
        
        // Assertions
        $this->assertTrue($result !== false, 'getRecordById should return data');
        $this->assertEquals($testData['name'], $result['name'], 'Name should match');
        $this->assertEquals($testData['email'], $result['email'], 'Email should match');
        $this->assertEquals($testData['status'], $result['status'], 'Status should match');
    }
    
    /**
     * Test getRecordById function with non-existent record
     */
    public function testGetRecordByIdNotFound()
    {
        $result = getRecordById($this->testTable, 'id', 99999);
        
        // Assertions
        $this->assertTrue($result === false || $result === null, 'getRecordById should return false for non-existent record');
    }
    
    /**
     * Test getRecordById function with SQL injection attempt
     */
    public function testGetRecordByIdSqlInjection()
    {
        $sqlInjectionAttempts = [
            "1; DROP TABLE {$this->testTable}; --",
            "1 OR 1=1",
            "1 UNION SELECT * FROM users --"
        ];
        
        foreach ($sqlInjectionAttempts as $injection) {
            $result = getRecordById($this->testTable, 'id', $injection);
            $this->assertTrue($result === false || $result === null, 
                "getRecordById should fail with SQL injection: {$injection}");
        }
    }
    
    /**
     * Test deleteRecord function
     */
    public function testDeleteRecord()
    {
        // Insert test data
        $testData = [
            'name' => 'Delete Test User',
            'email' => 'delete@example.com',
            'status' => 'active'
        ];
        $this->CI->db->insert($this->testTable, $testData);
        $insertId = $this->CI->db->insert_id();
        
        // Verify record exists
        $this->assertRecordExists($this->testTable, ['id' => $insertId]);
        
        // Test deleteRecord
        $result = deleteRecord($this->testTable, 'id', $insertId);
        
        // Assertions
        $this->assertTrue($result, 'deleteRecord should return true');
        $this->assertRecordNotExists($this->testTable, ['id' => $insertId]);
    }
    
    /**
     * Test getAllcustomeRecordById function
     */
    public function testGetAllcustomeRecordById()
    {
        // Insert multiple test records
        $testData = [
            ['name' => 'User 1', 'email' => 'user1@example.com', 'status' => 'active'],
            ['name' => 'User 2', 'email' => 'user2@example.com', 'status' => 'active'],
            ['name' => 'User 3', 'email' => 'user3@example.com', 'status' => 'inactive']
        ];
        
        foreach ($testData as $data) {
            $this->CI->db->insert($this->testTable, $data);
        }
        
        // Test getAllcustomeRecordById
        $result = getAllcustomeRecordById($this->testTable, 'status', 'active');
        
        // Assertions
        $this->assertTrue($result !== false, 'getAllcustomeRecordById should return data');
        $this->assertTrue(is_array($result), 'Result should be an array');
        $this->assertTrue(count($result) >= 2, 'Should return at least 2 active records');
        
        foreach ($result as $record) {
            $this->assertEquals('active', $record['status'], 'All records should have active status');
        }
    }
    
    /**
     * Test AddUpdateTable function for insert
     */
    public function testAddUpdateTableInsert()
    {
        $testData = [
            'name' => 'Insert Test User',
            'email' => 'insert@example.com',
            'status' => 'active'
        ];
        
        // Test AddUpdateTable for insert
        $result = AddUpdateTable($this->testTable, $testData, 'id', 0);
        
        // Assertions
        $this->assertTrue($result !== false, 'AddUpdateTable should return true for insert');
        
        // Verify record was inserted
        $insertedRecord = $this->CI->db->where('email', $testData['email'])->get($this->testTable)->row_array();
        $this->assertTrue($insertedRecord !== null, 'Record should be inserted');
        $this->assertEquals($testData['name'], $insertedRecord['name'], 'Name should match');
    }
    
    /**
     * Test AddUpdateTable function for update
     */
    public function testAddUpdateTableUpdate()
    {
        // Insert test data
        $originalData = [
            'name' => 'Original Name',
            'email' => 'update@example.com',
            'status' => 'active'
        ];
        $this->CI->db->insert($this->testTable, $originalData);
        $insertId = $this->CI->db->insert_id();
        
        // Update data
        $updateData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'status' => 'inactive'
        ];
        
        // Test AddUpdateTable for update
        $result = AddUpdateTable($this->testTable, $updateData, 'id', $insertId);
        
        // Assertions
        $this->assertTrue($result !== false, 'AddUpdateTable should return true for update');
        
        // Verify record was updated
        $updatedRecord = $this->CI->db->where('id', $insertId)->get($this->testTable)->row_array();
        $this->assertEquals($updateData['name'], $updatedRecord['name'], 'Name should be updated');
        $this->assertEquals($updateData['email'], $updatedRecord['email'], 'Email should be updated');
        $this->assertEquals($updateData['status'], $updatedRecord['status'], 'Status should be updated');
    }
    
    /**
     * Test HTTP client functionality with mocked responses
     */
    public function testHttpClientFunctionality()
    {
        // Load HttpClient
        $this->CI->load->library('HttpClient');
        $httpClient = new HttpClient();
        
        // Test GET request (will use mock response)
        $response = $httpClient->get('https://kuberbets.com/api/sattaMatka');
        
        // Assertions
        $this->assertTrue(isset($response['code']), 'Response should have code');
        $this->assertTrue(isset($response['body']), 'Response should have body');
        
        // Test POST request
        $postData = ['test' => 'data'];
        $response = $httpClient->post('https://kuberbets.com/api/sattaMatka', $postData);
        
        // Assertions
        $this->assertTrue(isset($response['code']), 'POST response should have code');
        $this->assertTrue(isset($response['body']), 'POST response should have body');
    }
    
    /**
     * Test requestForMultiClient function
     */
    public function testRequestForMultiClient()
    {
        $urls = [
            'https://kuberbets.com/api/sattaMatka',
            'https://kuberbets.vip/api/sattaMatka',
            'https://laxminarayan.live/api/sattaMatka'
        ];
        
        $postData = ['test' => 'multi_client_data'];
        
        // Test requestForMultiClient
        $results = requestForMultiClient($urls, $postData);
        
        // Assertions
        $this->assertTrue(is_array($results), 'Results should be an array');
        $this->assertEquals(count($urls), count($results), 'Should return results for all URLs');
        
        foreach ($results as $result) {
            $this->assertTrue(isset($result['code']), 'Each result should have code');
            $this->assertTrue(isset($result['body']), 'Each result should have body');
        }
    }
    
    /**
     * Test requestForClient function
     */
    public function testRequestForClient()
    {
        $url = 'https://kuberbets.com/api/sattaMatka';
        $postData = ['test' => 'single_client_data'];
        
        // Test requestForClient
        $result = requestForClient($url, $postData);
        
        // Assertions
        $this->assertTrue(isset($result['code']), 'Result should have code');
        $this->assertTrue(isset($result['body']), 'Result should have body');
    }
    
    /**
     * Test requestForBalance function
     */
    public function testRequestForBalance()
    {
        $url = 'https://kuberbets.com/api/balance';
        $postData = ['user_id' => 123];
        
        // Test requestForBalance
        $result = requestForBalance($url, $postData);
        
        // Assertions
        $this->assertTrue(isset($result['code']), 'Balance result should have code');
        $this->assertTrue(isset($result['body']), 'Balance result should have body');
    }
    
    /**
     * Test notifyUser function
     */
    public function testNotifyUser()
    {
        $url = 'https://api.ultramsg.com/api/send';
        $postData = [
            'phone' => '1234567890',
            'message' => 'Test notification'
        ];
        
        // Test notifyUser
        $result = notifyUser($url, $postData);
        
        // Assertions
        $this->assertTrue(isset($result['code']), 'Notification result should have code');
        $this->assertTrue(isset($result['body']), 'Notification result should have body');
    }
    
    /**
     * Clean up after each test
     */
    public function __destruct()
    {
        // Drop test table
        $this->CI->db->query("DROP TABLE IF EXISTS {$this->testTable}");
        $this->tearDown();
    }
}
