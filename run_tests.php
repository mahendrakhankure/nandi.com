<?php
/**
 * Standalone Test Runner for CodeIgniter Application
 * This script can be run from command line to execute all tests
 */

// Set the environment
define('ENVIRONMENT', 'testing');

// Define all required CodeIgniter paths
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
define('BASEPATH', FCPATH . 'system' . DIRECTORY_SEPARATOR);
define('APPPATH', FCPATH . 'application' . DIRECTORY_SEPARATOR);
define('VIEWPATH', APPPATH . 'views' . DIRECTORY_SEPARATOR);
define('SYSDIR', 'system');

// Disable error display for cleaner output
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
ini_set('display_errors', 0);

// Simple test runner that doesn't require full CodeIgniter initialization
class SimpleTestRunner {
    private $testResults = [];
    private $totalTests = 0;
    private $passedTests = 0;
    private $failedTests = 0;
    private $startTime;
    
    public function __construct() {
        $this->startTime = microtime(true);
    }
    
    public function runAllTests() {
        echo "=== SIMPLE TEST RUNNER ===\n";
        echo "Starting test execution...\n\n";
        
        // Test database connection
        $this->testDatabaseConnection();
        
        // Test configuration files
        $this->testConfigurationFiles();
        
        // Test security features
        $this->testSecurityFeatures();
        
        // Test file structure
        $this->testFileStructure();
        
        // Generate report
        $this->generateReport();
    }
    
    private function testDatabaseConnection() {
        echo "Testing Database Connection...\n";
        
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
            } else {
                $this->addResult('Database Connection', 'PASSED', 'Successfully connected to database');
                $mysqli->close();
            }
        } catch (Exception $e) {
            $this->addResult('Database Connection', 'FAILED', 'Exception: ' . $e->getMessage());
        }
        echo "\n";
    }
    
    private function testConfigurationFiles() {
        echo "Testing Configuration Files...\n";
        
        $configFiles = [
            'config.php' => 'Main configuration',
            'database.php' => 'Database configuration',
            'api.php' => 'API configuration',
            'test.php' => 'Test configuration'
        ];
        
        foreach ($configFiles as $file => $description) {
            $filePath = APPPATH . 'config/' . $file;
            if (file_exists($filePath)) {
                $this->addResult($description, 'PASSED', "File exists: {$file}");
            } else {
                $this->addResult($description, 'FAILED', "File missing: {$file}");
            }
        }
        echo "\n";
    }
    
    private function testSecurityFeatures() {
        echo "Testing Security Features...\n";
        
        // Test config.php security settings
        $configPath = APPPATH . 'config/config.php';
        if (file_exists($configPath)) {
            $configContent = file_get_contents($configPath);
            
            $securityChecks = [
                'CSRF Protection' => 'csrf_protection.*TRUE',
                'XSS Protection' => 'global_xss_filtering.*TRUE',
                'HTTPOnly Cookies' => 'cookie_httponly.*TRUE',
                'Secure Log Path' => 'log_path.*APPPATH'
            ];
            
            foreach ($securityChecks as $feature => $pattern) {
                if (preg_match('/' . $pattern . '/', $configContent)) {
                    $this->addResult($feature, 'PASSED', 'Security feature enabled');
                } else {
                    $this->addResult($feature, 'FAILED', 'Security feature not found or disabled');
                }
            }
        } else {
            $this->addResult('Security Features', 'FAILED', 'Config file not found');
        }
        echo "\n";
    }
    
    private function testFileStructure() {
        echo "Testing File Structure...\n";
        
        $requiredDirs = [
            'application/controllers' => 'Controllers directory',
            'application/models' => 'Models directory',
            'application/views' => 'Views directory',
            'application/config' => 'Config directory',
            'application/libraries' => 'Libraries directory',
            'application/tests' => 'Tests directory'
        ];
        
        foreach ($requiredDirs as $dir => $description) {
            if (is_dir($dir)) {
                $this->addResult($description, 'PASSED', "Directory exists: {$dir}");
            } else {
                $this->addResult($description, 'FAILED', "Directory missing: {$dir}");
            }
        }
        echo "\n";
    }
    
    private function addResult($test, $status, $message) {
        $this->totalTests++;
        if ($status === 'PASSED') {
            $this->passedTests++;
            echo "✓ {$test}: {$message}\n";
        } else {
            $this->failedTests++;
            echo "✗ {$test}: {$message}\n";
        }
        
        $this->testResults[] = [
            'test' => $test,
            'status' => $status,
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
    
    private function generateReport() {
        $duration = round(microtime(true) - $this->startTime, 2);
        $successRate = $this->totalTests > 0 ? round(($this->passedTests / $this->totalTests) * 100, 2) : 0;
        
        echo "\n=== TEST SUMMARY ===\n";
        echo "Total Tests: {$this->totalTests}\n";
        echo "Passed: {$this->passedTests}\n";
        echo "Failed: {$this->failedTests}\n";
        echo "Success Rate: {$successRate}%\n";
        echo "Duration: {$duration} seconds\n";
        
        if ($this->failedTests > 0) {
            echo "\n=== FAILED TESTS ===\n";
            foreach ($this->testResults as $result) {
                if ($result['status'] === 'FAILED') {
                    echo "✗ {$result['test']}: {$result['message']}\n";
                }
            }
        }
        
        // Save report
        $this->saveReport();
    }
    
    private function saveReport() {
        $reportDir = APPPATH . 'tests/reports/';
        if (!is_dir($reportDir)) {
            mkdir($reportDir, 0755, true);
        }
        
        $reportFile = $reportDir . 'simple_test_report_' . date('Y-m-d_H-i-s') . '.json';
        
        $report = [
            'summary' => [
                'total_tests' => $this->totalTests,
                'passed_tests' => $this->passedTests,
                'failed_tests' => $this->failedTests,
                'success_rate' => $this->totalTests > 0 ? round(($this->passedTests / $this->totalTests) * 100, 2) : 0,
                'duration' => round(microtime(true) - $this->startTime, 2),
                'timestamp' => date('Y-m-d H:i:s')
            ],
            'results' => $this->testResults
        ];
        
        file_put_contents($reportFile, json_encode($report, JSON_PRETTY_PRINT));
        echo "\nReport saved to: {$reportFile}\n";
    }
}

// Run the tests
$runner = new SimpleTestRunner();
$runner->runAllTests();
