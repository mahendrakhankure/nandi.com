<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Test Runner for CodeIgniter Application
 * Executes all tests and generates reports
 */
class TestRunner
{
    protected $CI;
    protected $testResults = [];
    protected $startTime;
    protected $totalTests = 0;
    protected $passedTests = 0;
    protected $failedTests = 0;
    
    public function __construct()
    {
        $this->CI = &get_instance();
        $this->startTime = microtime(true);
    }
    
    /**
     * Run all tests
     */
    public function runAllTests()
    {
        echo "Starting Test Suite...\n";
        echo "=====================\n\n";
        
        // Define test classes
        $testClasses = [
            'AdminLoginTest',
            'CustomHelperTest', 
            'InstantWorliControllerTest'
        ];
        
        foreach ($testClasses as $testClass) {
            $this->runTestClass($testClass);
        }
        
        $this->generateReport();
    }
    
    /**
     * Run a specific test class
     */
    public function runTestClass($className)
    {
        echo "Running {$className}...\n";
        echo str_repeat('-', strlen($className) + 10) . "\n";
        
        try {
            // Load test file
            $testFile = APPPATH . 'tests/' . $className . '.php';
            if (!file_exists($testFile)) {
                throw new Exception("Test file not found: {$testFile}");
            }
            
            require_once $testFile;
            
            // Create test instance
            $testInstance = new $className();
            
            // Get all test methods
            $testMethods = $this->getTestMethods($testInstance);
            
            foreach ($testMethods as $method) {
                $this->runTestMethod($testInstance, $method);
            }
            
        } catch (Exception $e) {
            $this->recordTestResult($className, 'class_initialization', false, $e->getMessage());
            echo "ERROR: " . $e->getMessage() . "\n";
        }
        
        echo "\n";
    }
    
    /**
     * Run a specific test method
     */
    public function runTestMethod($testInstance, $methodName)
    {
        $this->totalTests++;
        
        try {
            // Run the test method
            $testInstance->$methodName();
            
            // If no exception was thrown, test passed
            $this->passedTests++;
            $this->recordTestResult(get_class($testInstance), $methodName, true);
            echo "✓ {$methodName}\n";
            
        } catch (Exception $e) {
            $this->failedTests++;
            $this->recordTestResult(get_class($testInstance), $methodName, false, $e->getMessage());
            echo "✗ {$methodName} - " . $e->getMessage() . "\n";
        }
    }
    
    /**
     * Get all test methods from a test class
     */
    protected function getTestMethods($testInstance)
    {
        $methods = [];
        $reflection = new ReflectionClass($testInstance);
        
        foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if (strpos($method->getName(), 'test') === 0) {
                $methods[] = $method->getName();
            }
        }
        
        return $methods;
    }
    
    /**
     * Record test result
     */
    protected function recordTestResult($className, $methodName, $passed, $errorMessage = '')
    {
        $this->testResults[] = [
            'class' => $className,
            'method' => $methodName,
            'passed' => $passed,
            'error' => $errorMessage,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
    
    /**
     * Generate test report
     */
    protected function generateReport()
    {
        $endTime = microtime(true);
        $duration = round($endTime - $this->startTime, 2);
        
        echo "\n" . str_repeat('=', 50) . "\n";
        echo "TEST REPORT\n";
        echo str_repeat('=', 50) . "\n";
        echo "Total Tests: {$this->totalTests}\n";
        echo "Passed: {$this->passedTests}\n";
        echo "Failed: {$this->failedTests}\n";
        echo "Success Rate: " . round(($this->passedTests / $this->totalTests) * 100, 2) . "%\n";
        echo "Duration: {$duration} seconds\n\n";
        
        if ($this->failedTests > 0) {
            echo "FAILED TESTS:\n";
            echo str_repeat('-', 15) . "\n";
            
            foreach ($this->testResults as $result) {
                if (!$result['passed']) {
                    echo "{$result['class']}::{$result['method']}\n";
                    echo "Error: {$result['error']}\n\n";
                }
            }
        }
        
        // Save report to file
        $this->saveReport();
    }
    
    /**
     * Save test report to file
     */
    protected function saveReport()
    {
        $reportDir = APPPATH . 'tests/reports/';
        if (!is_dir($reportDir)) {
            mkdir($reportDir, 0755, true);
        }
        
        $reportFile = $reportDir . 'test_report_' . date('Y-m-d_H-i-s') . '.json';
        
        $report = [
            'summary' => [
                'total_tests' => $this->totalTests,
                'passed_tests' => $this->passedTests,
                'failed_tests' => $this->failedTests,
                'success_rate' => round(($this->passedTests / $this->totalTests) * 100, 2),
                'duration' => round(microtime(true) - $this->startTime, 2),
                'timestamp' => date('Y-m-d H:i:s')
            ],
            'results' => $this->testResults
        ];
        
        file_put_contents($reportFile, json_encode($report, JSON_PRETTY_PRINT));
        echo "Report saved to: {$reportFile}\n";
    }
    
    /**
     * Run specific test class
     */
    public function runClass($className)
    {
        echo "Running {$className}...\n";
        $this->runTestClass($className);
        $this->generateReport();
    }
    
    /**
     * Run tests with coverage (if available)
     */
    public function runWithCoverage()
    {
        if (!extension_loaded('xdebug')) {
            echo "Xdebug not available. Running tests without coverage.\n";
            $this->runAllTests();
            return;
        }
        
        echo "Running tests with coverage...\n";
        
        // Enable code coverage
        xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);
        
        $this->runAllTests();
        
        // Stop coverage and get results
        $coverage = xdebug_get_code_coverage();
        xdebug_stop_code_coverage();
        
        $this->generateCoverageReport($coverage);
    }
    
    /**
     * Generate coverage report
     */
    protected function generateCoverageReport($coverage)
    {
        $reportDir = APPPATH . 'tests/reports/';
        $coverageFile = $reportDir . 'coverage_report_' . date('Y-m-d_H-i-s') . '.json';
        
        file_put_contents($coverageFile, json_encode($coverage, JSON_PRETTY_PRINT));
        echo "Coverage report saved to: {$coverageFile}\n";
    }
}

// Command line usage
if (php_sapi_name() === 'cli') {
    // Initialize CodeIgniter
    require_once 'index.php';
    
    $runner = new TestRunner();
    
    // Parse command line arguments
    $args = $argv;
    array_shift($args); // Remove script name
    
    if (empty($args)) {
        $runner->runAllTests();
    } elseif ($args[0] === '--class' && isset($args[1])) {
        $runner->runClass($args[1]);
    } elseif ($args[0] === '--coverage') {
        $runner->runWithCoverage();
    } else {
        echo "Usage:\n";
        echo "php TestRunner.php                    # Run all tests\n";
        echo "php TestRunner.php --class ClassName  # Run specific test class\n";
        echo "php TestRunner.php --coverage         # Run tests with coverage\n";
    }
}
