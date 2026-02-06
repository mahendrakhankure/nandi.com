# Testing Framework for CodeIgniter Application

This testing framework provides comprehensive unit and integration tests for the CodeIgniter application, focusing on database operations, controllers, and helper functions.

## Overview

The testing framework includes:

- **TestBase**: Base class with common utilities and database transaction handling
- **Unit Tests**: Tests for individual components (models, helpers)
- **Integration Tests**: Tests for controller logic and database interactions
- **Test Runner**: Command-line tool to execute tests and generate reports
- **Test Configuration**: Separate test database and mock configurations

## Test Structure

```
application/tests/
├── TestBase.php                    # Base test class
├── AdminLoginTest.php              # Unit tests for Admin_Login_Model
├── CustomHelperTest.php            # Unit tests for custom_helper.php
├── InstantWorliControllerTest.php  # Integration tests for InstantWorli controllers
├── TestRunner.php                  # Test execution and reporting
├── README.md                       # This file
└── reports/                        # Generated test reports
```

## Features

### Database Testing
- **Transaction-based**: Each test runs in a transaction that gets rolled back
- **Isolated**: Tests don't affect each other
- **Test data creation**: Helper methods to create test users, admins, and games
- **SQL injection testing**: Tests for security vulnerabilities

### HTTP Client Testing
- **Mocked responses**: External API calls are mocked for consistent testing
- **Retry logic testing**: Tests for HTTP retry and backoff mechanisms
- **Authentication testing**: Tests for Bearer token injection

### Security Testing
- **SQL injection protection**: Tests for parameterized queries
- **Input validation**: Tests for edge cases and malicious input
- **Authentication bypass**: Tests for login security

## Setup

### 1. Create Test Database

```sql
CREATE DATABASE nandi_test;
```

### 2. Configure Test Environment

Update `application/config/test.php` with your test database credentials:

```php
$config['test_database'] = array(
    'hostname' => 'localhost',
    'username' => 'your_username',
    'password' => 'your_password',
    'database' => 'nandi_test',
    // ... other settings
);
```

### 3. Set Environment Variables

Set the required environment variables for API tokens:

```bash
export KUBERBETS_TOKEN="your_token_here"
export KUBERBETS_VIP_TOKEN="your_vip_token_here"
export LAXMINARAYAN_TOKEN="your_laxminarayan_token_here"
# ... other tokens
```

## Running Tests

### Command Line Usage

```bash
# Run all tests
php application/tests/TestRunner.php

# Run specific test class
php application/tests/TestRunner.php --class AdminLoginTest

# Run tests with code coverage (requires Xdebug)
php application/tests/TestRunner.php --coverage
```

### Web Interface

You can also run tests through a web interface by creating a controller:

```php
// application/controllers/Test.php
class Test extends CI_Controller {
    public function run() {
        $this->load->file(APPPATH . 'tests/TestRunner.php');
        $runner = new TestRunner();
        $runner->runAllTests();
    }
}
```

Then visit: `http://your-domain/test/run`

## Test Categories

### 1. Unit Tests (AdminLoginTest.php)

Tests individual model functionality:

- **Valid login**: Tests successful authentication
- **Invalid credentials**: Tests failed login attempts
- **SQL injection protection**: Tests security against malicious input
- **Edge cases**: Tests empty credentials, special characters, long inputs

### 2. Helper Function Tests (CustomHelperTest.php)

Tests database helper functions:

- **CRUD operations**: Tests getRecordById, deleteRecord, AddUpdateTable
- **HTTP client**: Tests requestForMultiClient, requestForClient
- **Security**: Tests SQL injection protection in helper functions
- **Error handling**: Tests function behavior with invalid input

### 3. Integration Tests (InstantWorliControllerTest.php)

Tests controller logic and database interactions:

- **Game creation**: Tests game record creation and validation
- **Status updates**: Tests game status transitions (P → W/L)
- **Balance calculations**: Tests user balance updates
- **Concurrent operations**: Tests race conditions and data integrity

## Writing New Tests

### 1. Create Test Class

```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MyNewTest extends TestBase
{
    public function __construct()
    {
        parent::__construct();
        // Load your models/helpers here
    }
    
    public function testMyFunction()
    {
        // Arrange
        $testData = $this->createTestUser(['email' => 'test@example.com']);
        
        // Act
        $result = someFunction($testData);
        
        // Assert
        $this->assertTrue($result !== false, 'Function should return valid result');
        $this->assertEquals('expected', $result['field'], 'Field should match expected value');
    }
}
```

### 2. Test Method Naming

- Use `test` prefix: `testValidLogin()`
- Descriptive names: `testSqlInjectionProtection()`
- Group related tests: `testGameStatusUpdate*()`

### 3. Test Structure (AAA Pattern)

```php
public function testExample()
{
    // Arrange - Set up test data
    $user = $this->createTestUser();
    
    // Act - Execute the function being tested
    $result = $this->someFunction($user);
    
    // Assert - Verify the results
    $this->assertTrue($result !== false);
    $this->assertEquals('expected', $result['field']);
}
```

## Best Practices

### 1. Test Isolation
- Each test should be independent
- Use transactions to rollback changes
- Create fresh test data for each test

### 2. Test Data Management
```php
// Good - Create specific test data
$user = $this->createTestUser(['email' => 'specific@test.com']);

// Bad - Rely on existing data
$user = $this->CI->db->where('email', 'admin@example.com')->get('users')->row();
```

### 3. Assertion Messages
```php
// Good - Descriptive assertion messages
$this->assertTrue($result !== false, 'Login should succeed with valid credentials');

// Bad - Generic messages
$this->assertTrue($result !== false);
```

### 4. Security Testing
```php
// Test SQL injection attempts
$sqlInjectionAttempts = [
    "'; DROP TABLE users; --",
    "' OR '1'='1",
    "'; INSERT INTO users VALUES (999, 'hacker@evil.com'); --"
];

foreach ($sqlInjectionAttempts as $injection) {
    $result = $this->functionUnderTest($injection);
    $this->assertTrue($result === false, "Should fail with SQL injection: {$injection}");
}
```

## Test Reports

Test reports are automatically generated and saved to `application/tests/reports/`:

- **JSON format**: Machine-readable test results
- **Summary statistics**: Total tests, passed/failed counts, success rate
- **Detailed results**: Individual test results with error messages
- **Timestamps**: When tests were run

### Sample Report Structure

```json
{
  "summary": {
    "total_tests": 25,
    "passed_tests": 23,
    "failed_tests": 2,
    "success_rate": 92.0,
    "duration": 3.45,
    "timestamp": "2024-01-15 10:30:00"
  },
  "results": [
    {
      "class": "AdminLoginTest",
      "method": "testValidLogin",
      "passed": true,
      "error": "",
      "timestamp": "2024-01-15 10:30:00"
    }
  ]
}
```

## Continuous Integration

### GitHub Actions Example

```yaml
name: Tests
on: [push, pull_request]
jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '7.4'
      - name: Install dependencies
        run: composer install
      - name: Run tests
        run: php application/tests/TestRunner.php
```

## Troubleshooting

### Common Issues

1. **Database connection errors**
   - Verify test database exists
   - Check credentials in `test.php`
   - Ensure MySQL service is running

2. **Test failures due to missing tables**
   - Run database migrations
   - Check if test tables are created properly

3. **HTTP client test failures**
   - Verify environment variables are set
   - Check if external APIs are accessible
   - Review mock response configurations

### Debug Mode

Enable debug mode in `application/config/test.php`:

```php
$config['test']['debug'] = true;
```

This will provide more detailed error messages and stack traces.

## Security Considerations

- **Test database**: Use separate database for testing
- **Environment variables**: Never commit real API tokens to version control
- **Test data**: Use fake data, never real user information
- **Cleanup**: Ensure test data is properly cleaned up after tests

## Performance

- **Database transactions**: Fast rollback instead of cleanup
- **Mocked HTTP calls**: Avoid real API calls during testing
- **Test isolation**: Parallel test execution possible
- **Minimal setup**: Only create necessary test data

## Future Enhancements

- **API endpoint testing**: Test REST API endpoints
- **Frontend testing**: JavaScript and UI testing
- **Performance testing**: Load and stress testing
- **Security scanning**: Automated vulnerability testing
- **Test coverage reporting**: HTML coverage reports
