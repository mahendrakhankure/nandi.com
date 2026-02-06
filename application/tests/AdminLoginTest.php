<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Unit tests for Admin_Login_Model
 * Tests authentication functionality with database isolation
 */
class AdminLoginTest extends TestBase
{
    protected $adminModel;
    
    public function __construct()
    {
        parent::__construct();
        $this->adminModel = new Admin_Login_Model();
    }
    
    /**
     * Test successful admin login with valid credentials
     */
    public function testValidLogin()
    {
        // Create test admin
        $adminData = [
            'email' => 'test_admin@example.com',
            'password' => 'test_password_123',
            'id' => 1
        ];
        $this->createTestAdmin($adminData);
        
        // Test login
        $result = $this->adminModel->validatelogin($adminData['email'], $adminData['password']);
        
        // Assertions
        $this->assertTrue($result !== false, 'Login should succeed with valid credentials');
        $this->assertEquals($adminData['email'], $result['email'], 'Returned email should match');
        $this->assertEquals($adminData['password'], $result['password'], 'Returned password should match');
        $this->assertEquals(1, $result['id'], 'Admin ID should be 1');
    }
    
    /**
     * Test admin login with invalid email
     */
    public function testInvalidEmail()
    {
        // Create test admin
        $adminData = [
            'email' => 'test_admin@example.com',
            'password' => 'test_password_123',
            'id' => 1
        ];
        $this->createTestAdmin($adminData);
        
        // Test login with wrong email
        $result = $this->adminModel->validatelogin('wrong_email@example.com', $adminData['password']);
        
        // Assertions
        $this->assertTrue($result === false || $result === null, 'Login should fail with invalid email');
    }
    
    /**
     * Test admin login with invalid password
     */
    public function testInvalidPassword()
    {
        // Create test admin
        $adminData = [
            'email' => 'test_admin@example.com',
            'password' => 'test_password_123',
            'id' => 1
        ];
        $this->createTestAdmin($adminData);
        
        // Test login with wrong password
        $result = $this->adminModel->validatelogin($adminData['email'], 'wrong_password');
        
        // Assertions
        $this->assertTrue($result === false || $result === null, 'Login should fail with invalid password');
    }
    
    /**
     * Test admin login with SQL injection attempt
     */
    public function testSqlInjectionProtection()
    {
        // Create test admin
        $adminData = [
            'email' => 'test_admin@example.com',
            'password' => 'test_password_123',
            'id' => 1
        ];
        $this->createTestAdmin($adminData);
        
        // Test SQL injection attempts
        $sqlInjectionAttempts = [
            "'; DROP TABLE admin; --",
            "' OR '1'='1",
            "' UNION SELECT * FROM admin --",
            "'; INSERT INTO admin VALUES (999, 'hacker@evil.com', 'hacked'); --"
        ];
        
        foreach ($sqlInjectionAttempts as $injection) {
            $result = $this->adminModel->validatelogin($injection, $injection);
            $this->assertTrue($result === false || $result === null, 
                "Login should fail with SQL injection attempt: {$injection}");
        }
    }
    
    /**
     * Test admin login with empty credentials
     */
    public function testEmptyCredentials()
    {
        // Test empty email
        $result = $this->adminModel->validatelogin('', 'test_password');
        $this->assertTrue($result === false || $result === null, 'Login should fail with empty email');
        
        // Test empty password
        $result = $this->adminModel->validatelogin('test@example.com', '');
        $this->assertTrue($result === false || $result === null, 'Login should fail with empty password');
        
        // Test both empty
        $result = $this->adminModel->validatelogin('', '');
        $this->assertTrue($result === false || $result === null, 'Login should fail with empty credentials');
    }
    
    /**
     * Test admin login with special characters
     */
    public function testSpecialCharacters()
    {
        // Create test admin with special characters
        $adminData = [
            'email' => 'test+admin@example.com',
            'password' => 'test@#$%^&*()_+',
            'id' => 1
        ];
        $this->createTestAdmin($adminData);
        
        // Test login
        $result = $this->adminModel->validatelogin($adminData['email'], $adminData['password']);
        
        // Assertions
        $this->assertTrue($result !== false, 'Login should succeed with special characters');
        $this->assertEquals($adminData['email'], $result['email'], 'Returned email should match');
    }
    
    /**
     * Test admin login with very long credentials
     */
    public function testLongCredentials()
    {
        // Create test admin with long credentials
        $longEmail = str_repeat('a', 100) . '@example.com';
        $longPassword = str_repeat('b', 100);
        
        $adminData = [
            'email' => $longEmail,
            'password' => $longPassword,
            'id' => 1
        ];
        $this->createTestAdmin($adminData);
        
        // Test login
        $result = $this->adminModel->validatelogin($adminData['email'], $adminData['password']);
        
        // Assertions
        $this->assertTrue($result !== false, 'Login should succeed with long credentials');
        $this->assertEquals($adminData['email'], $result['email'], 'Returned email should match');
    }
    
    /**
     * Clean up after each test
     */
    public function __destruct()
    {
        $this->tearDown();
    }
}
