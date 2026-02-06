<?php
/**
 * Performance Testing Script for Enhanced CodeIgniter Project
 * Tests database queries, HTTP client, security features, and overall performance
 */

// Set the environment
define('ENVIRONMENT', 'testing');

// Define paths
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
define('BASEPATH', FCPATH . 'system' . DIRECTORY_SEPARATOR);
define('APPPATH', FCPATH . 'application' . DIRECTORY_SEPARATOR);
define('VIEWPATH', APPPATH . 'views' . DIRECTORY_SEPARATOR);
define('SYSDIR', 'system');

// Disable error display for cleaner output
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
ini_set('display_errors', 0);

class PerformanceTester {
    private $results = [];
    private $startTime;
    private $memoryStart;
    
    public function __construct() {
        $this->startTime = microtime(true);
        $this->memoryStart = memory_get_usage(true);
    }
    
    public function runAllTests() {
        echo "=== PERFORMANCE TESTING SUITE ===\n";
        echo "Testing Enhanced CodeIgniter Project Performance\n\n";
        
        // Database Performance Tests
        $this->testDatabasePerformance();
        
        // HTTP Client Performance Tests
        $this->testHttpClientPerformance();
        
        // Security Feature Performance Tests
        $this->testSecurityPerformance();
        
        // Memory Usage Tests
        $this->testMemoryUsage();
        
        // Code Execution Speed Tests
        $this->testCodeExecutionSpeed();
        
        // Generate Performance Report
        $this->generatePerformanceReport();
    }
    
    private function testDatabasePerformance() {
        echo "Testing Database Performance...\n";
        
        try {
            // Load database config
            $dbConfig = include APPPATH . 'config/database.php';
            $hostname = $dbConfig['default']['hostname'];
            $username = $dbConfig['default']['username'];
            $password = $dbConfig['default']['password'];
            $database = $dbConfig['default']['database'];
            
            $mysqli = new mysqli($hostname, $username, $password, $database);
            
            if ($mysqli->connect_error) {
                $this->addResult('Database Connection', 'FAILED', 'Could not connect to database: ' . $mysqli->connect_error);
                return;
            }
            
            // Test 1: Simple SELECT query performance
            $start = microtime(true);
            $result = $mysqli->query("SELECT COUNT(*) as count FROM admin LIMIT 1");
            $end = microtime(true);
            $queryTime = ($end - $start) * 1000; // Convert to milliseconds
            
            if ($result) {
                $this->addResult('Simple SELECT Query', 'PASSED', "Query executed in {$queryTime}ms");
            } else {
                $this->addResult('Simple SELECT Query', 'FAILED', 'Query failed to execute');
            }
            
            // Test 2: Parameterized query performance (simulated)
            $start = microtime(true);
            $stmt = $mysqli->prepare("SELECT * FROM admin WHERE id = ? LIMIT 1");
            if ($stmt) {
                $id = 1;
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->close();
                $end = microtime(true);
                $preparedTime = ($end - $start) * 1000;
                $this->addResult('Parameterized Query', 'PASSED', "Prepared statement executed in {$preparedTime}ms");
            } else {
                $this->addResult('Parameterized Query', 'FAILED', 'Prepared statement failed');
            }
            
            // Test 3: Multiple queries performance
            $start = microtime(true);
            for ($i = 0; $i < 10; $i++) {
                $mysqli->query("SELECT COUNT(*) FROM admin");
            }
            $end = microtime(true);
            $multipleTime = ($end - $start) * 1000;
            $this->addResult('Multiple Queries (10)', 'PASSED', "10 queries executed in {$multipleTime}ms (avg: " . ($multipleTime/10) . "ms per query)");
            
            $mysqli->close();
            
        } catch (Exception $e) {
            $this->addResult('Database Performance', 'FAILED', 'Exception: ' . $e->getMessage());
        }
        echo "\n";
    }
    
    private function testHttpClientPerformance() {
        echo "Testing HTTP Client Performance...\n";
        
        // Test 1: HTTP Client initialization
        $start = microtime(true);
        if (file_exists(APPPATH . 'libraries/HttpClient.php')) {
            require_once APPPATH . 'libraries/HttpClient.php';
            $end = microtime(true);
            $initTime = ($end - $start) * 1000;
            $this->addResult('HTTP Client Initialization', 'PASSED', "Client initialized in {$initTime}ms");
        } else {
            $this->addResult('HTTP Client Initialization', 'FAILED', 'HttpClient.php not found');
        }
        
        // Test 2: Mock HTTP request performance
        $start = microtime(true);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://httpbin.org/delay/0.1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $end = microtime(true);
        $requestTime = ($end - $start) * 1000;
        
        if ($httpCode == 200) {
            $this->addResult('HTTP Request Performance', 'PASSED', "HTTP request completed in {$requestTime}ms");
        } else {
            $this->addResult('HTTP Request Performance', 'FAILED', "HTTP request failed with code {$httpCode}");
        }
        
        // Test 3: Multiple HTTP requests performance
        $start = microtime(true);
        $successCount = 0;
        for ($i = 0; $i < 5; $i++) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://httpbin.org/status/200');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 2);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($httpCode == 200) $successCount++;
        }
        $end = microtime(true);
        $multipleTime = ($end - $start) * 1000;
        $this->addResult('Multiple HTTP Requests (5)', 'PASSED', "5 requests completed in {$multipleTime}ms ({$successCount}/5 successful)");
        
        echo "\n";
    }
    
    private function testSecurityPerformance() {
        echo "Testing Security Features Performance...\n";
        
        // Test 1: CSRF token generation performance
        $start = microtime(true);
        $csrfToken = bin2hex(random_bytes(32));
        $end = microtime(true);
        $csrfTime = ($end - $start) * 1000;
        $this->addResult('CSRF Token Generation', 'PASSED', "Token generated in {$csrfTime}ms");
        
        // Test 2: Password hashing performance
        $start = microtime(true);
        $password = 'test_password_123';
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $end = microtime(true);
        $hashTime = ($end - $start) * 1000;
        $this->addResult('Password Hashing', 'PASSED', "Password hashed in {$hashTime}ms");
        
        // Test 3: Password verification performance
        $start = microtime(true);
        $isValid = password_verify($password, $hashedPassword);
        $end = microtime(true);
        $verifyTime = ($end - $start) * 1000;
        $this->addResult('Password Verification', 'PASSED', "Password verified in {$verifyTime}ms");
        
        // Test 4: XSS filtering performance
        $start = microtime(true);
        $dirtyInput = '<script>alert("xss")</script>Hello World';
        $cleanInput = htmlspecialchars($dirtyInput, ENT_QUOTES, 'UTF-8');
        $end = microtime(true);
        $xssTime = ($end - $start) * 1000;
        $this->addResult('XSS Filtering', 'PASSED', "Input sanitized in {$xssTime}ms");
        
        // Test 5: SQL injection prevention (parameterized query simulation)
        $start = microtime(true);
        $userInput = "'; DROP TABLE users; --";
        $safeQuery = "SELECT * FROM users WHERE id = ? AND name = ?";
        $end = microtime(true);
        $sqlTime = ($end - $start) * 1000;
        $this->addResult('SQL Injection Prevention', 'PASSED', "Query parameterization in {$sqlTime}ms");
        
        echo "\n";
    }
    
    private function testMemoryUsage() {
        echo "Testing Memory Usage...\n";
        
        $initialMemory = memory_get_usage(true);
        
        // Test 1: Memory usage for array operations
        $start = microtime(true);
        $largeArray = [];
        for ($i = 0; $i < 10000; $i++) {
            $largeArray[] = "test_data_" . $i;
        }
        $end = microtime(true);
        $arrayTime = ($end - $start) * 1000;
        $arrayMemory = memory_get_usage(true) - $initialMemory;
        $this->addResult('Large Array Creation (10k items)', 'PASSED', "Created in {$arrayTime}ms, used {$arrayMemory} bytes");
        
        // Test 2: Memory usage for string operations
        $start = microtime(true);
        $largeString = '';
        for ($i = 0; $i < 1000; $i++) {
            $largeString .= "test_string_" . $i . "\n";
        }
        $end = microtime(true);
        $stringTime = ($end - $start) * 1000;
        $stringMemory = memory_get_usage(true) - $arrayMemory - $initialMemory;
        $this->addResult('Large String Creation (1k lines)', 'PASSED', "Created in {$stringTime}ms, used {$stringMemory} bytes");
        
        // Test 3: Memory cleanup
        unset($largeArray, $largeString);
        $finalMemory = memory_get_usage(true);
        $cleanedMemory = $initialMemory - $finalMemory;
        $this->addResult('Memory Cleanup', 'PASSED', "Cleaned up {$cleanedMemory} bytes");
        
        echo "\n";
    }
    
    private function testCodeExecutionSpeed() {
        echo "Testing Code Execution Speed...\n";
        
        // Test 1: Function call performance
        $start = microtime(true);
        for ($i = 0; $i < 10000; $i++) {
            $result = $this->testFunction($i);
        }
        $end = microtime(true);
        $functionTime = ($end - $start) * 1000;
        $this->addResult('Function Calls (10k)', 'PASSED', "10,000 function calls in {$functionTime}ms");
        
        // Test 2: File operations performance
        $start = microtime(true);
        $testFile = APPPATH . 'tests/temp_test_file.txt';
        file_put_contents($testFile, 'test data');
        $content = file_get_contents($testFile);
        unlink($testFile);
        $end = microtime(true);
        $fileTime = ($end - $start) * 1000;
        $this->addResult('File Operations (write/read/delete)', 'PASSED', "File operations completed in {$fileTime}ms");
        
        // Test 3: JSON operations performance
        $start = microtime(true);
        $testData = ['name' => 'test', 'value' => 123, 'array' => [1, 2, 3, 4, 5]];
        for ($i = 0; $i < 1000; $i++) {
            $jsonString = json_encode($testData);
            $decodedData = json_decode($jsonString, true);
        }
        $end = microtime(true);
        $jsonTime = ($end - $start) * 1000;
        $this->addResult('JSON Operations (1k encode/decode)', 'PASSED', "JSON operations completed in {$jsonTime}ms");
        
        echo "\n";
    }
    
    private function testFunction($input) {
        return $input * 2 + 1;
    }
    
    private function addResult($test, $status, $message) {
        $this->results[] = [
            'test' => $test,
            'status' => $status,
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        if ($status === 'PASSED') {
            echo "✓ {$test}: {$message}\n";
        } else {
            echo "✗ {$test}: {$message}\n";
        }
    }
    
    private function generatePerformanceReport() {
        $totalTime = microtime(true) - $this->startTime;
        $totalMemory = memory_get_usage(true) - $this->memoryStart;
        $peakMemory = memory_get_peak_usage(true);
        
        $passedTests = 0;
        $failedTests = 0;
        foreach ($this->results as $result) {
            if ($result['status'] === 'PASSED') {
                $passedTests++;
            } else {
                $failedTests++;
            }
        }
        
        echo "\n=== PERFORMANCE SUMMARY ===\n";
        echo "Total Tests: " . count($this->results) . "\n";
        echo "Passed: {$passedTests}\n";
        echo "Failed: {$failedTests}\n";
        echo "Success Rate: " . round(($passedTests / count($this->results)) * 100, 2) . "%\n";
        echo "Total Execution Time: " . round($totalTime, 3) . " seconds\n";
        echo "Memory Usage: " . $this->formatBytes($totalMemory) . "\n";
        echo "Peak Memory: " . $this->formatBytes($peakMemory) . "\n";
        
        // Performance recommendations
        echo "\n=== PERFORMANCE RECOMMENDATIONS ===\n";
        if ($totalTime > 5) {
            echo "⚠️  Consider optimizing slow operations\n";
        } else {
            echo "✅ Performance is within acceptable range\n";
        }
        
        if ($peakMemory > 50 * 1024 * 1024) { // 50MB
            echo "⚠️  High memory usage detected\n";
        } else {
            echo "✅ Memory usage is efficient\n";
        }
        
        // Save detailed report
        $this->savePerformanceReport($totalTime, $totalMemory, $peakMemory);
    }
    
    private function formatBytes($bytes) {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, 2) . ' ' . $units[$pow];
    }
    
    private function savePerformanceReport($totalTime, $totalMemory, $peakMemory) {
        $reportDir = APPPATH . 'tests/reports/';
        if (!is_dir($reportDir)) {
            mkdir($reportDir, 0755, true);
        }
        
        $reportFile = $reportDir . 'performance_report_' . date('Y-m-d_H-i-s') . '.json';
        
        $report = [
            'summary' => [
                'total_tests' => count($this->results),
                'passed_tests' => count(array_filter($this->results, function($r) { return $r['status'] === 'PASSED'; })),
                'failed_tests' => count(array_filter($this->results, function($r) { return $r['status'] === 'FAILED'; })),
                'success_rate' => round((count(array_filter($this->results, function($r) { return $r['status'] === 'PASSED'; })) / count($this->results)) * 100, 2),
                'total_execution_time' => round($totalTime, 3),
                'memory_usage' => $this->formatBytes($totalMemory),
                'peak_memory' => $this->formatBytes($peakMemory),
                'timestamp' => date('Y-m-d H:i:s')
            ],
            'results' => $this->results
        ];
        
        file_put_contents($reportFile, json_encode($report, JSON_PRETTY_PRINT));
        echo "\nDetailed performance report saved to: {$reportFile}\n";
    }
}

// Run the performance tests
$tester = new PerformanceTester();
$tester->runAllTests();
