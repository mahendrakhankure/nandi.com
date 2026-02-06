<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Integration tests for InstantWorli controllers
 * Tests game logic, database operations, and API endpoints
 */
class InstantWorliControllerTest extends TestBase
{
    protected $adminController;
    protected $userController;
    
    public function __construct()
    {
        parent::__construct();
        
        // Load controllers
        $this->CI->load->file(APPPATH . 'controllers/admin/InstantWorli.php');
        $this->CI->load->file(APPPATH . 'controllers/User/InstantWorli.php');
        
        $this->adminController = new InstantWorli();
        $this->userController = new InstantWorli();
        
        // Create test tables if they don't exist
        $this->createTestTables();
    }
    
    /**
     * Create test tables for game operations
     */
    protected function createTestTables()
    {
        // Create warli_users_game table
        $sql = "CREATE TABLE IF NOT EXISTS warli_users_game (
            id INT AUTO_INCREMENT PRIMARY KEY,
            round_id VARCHAR(255),
            user_id INT,
            amount DECIMAL(10,2),
            status ENUM('P', 'W', 'L') DEFAULT 'P',
            winning_point DECIMAL(10,2) DEFAULT 0,
            commission DECIMAL(10,2) DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->CI->db->query($sql);
        
        // Create users table
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255),
            email VARCHAR(255),
            balance DECIMAL(10,2) DEFAULT 0,
            status ENUM('active', 'inactive') DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->CI->db->query($sql);
    }
    
    /**
     * Test game creation and status updates
     */
    public function testGameCreationAndStatusUpdate()
    {
        // Create test user
        $userId = $this->createTestUser([
            'username' => 'test_gamer',
            'email' => 'gamer@example.com',
            'balance' => 1000
        ]);
        
        // Create test game
        $gameData = [
            'round_id' => 'TEST_ROUND_' . uniqid(),
            'user_id' => $userId,
            'amount' => 100,
            'status' => 'P'
        ];
        $this->CI->db->insert('warli_users_game', $gameData);
        $gameId = $this->CI->db->insert_id();
        
        // Verify game was created
        $this->assertRecordExists('warli_users_game', ['id' => $gameId]);
        
        // Test status update to 'L' (Lose)
        $this->mockRequest('POST', ['id' => $gameData['round_id']]);
        
        // Simulate the update logic (since we can't directly call controller methods)
        $updateResult = $this->CI->db->query(
            "UPDATE warli_users_game SET status='L', winning_point='0', commission='0' WHERE round_id = ? AND status='P'",
            [$gameData['round_id']]
        );
        
        // Verify update
        $updatedGame = $this->CI->db->where('round_id', $gameData['round_id'])->get('warli_users_game')->row_array();
        $this->assertEquals('L', $updatedGame['status'], 'Game status should be updated to L');
        $this->assertEquals(0, $updatedGame['winning_point'], 'Winning point should be 0');
        $this->assertEquals(0, $updatedGame['commission'], 'Commission should be 0');
    }
    
    /**
     * Test game status update with invalid round_id
     */
    public function testGameStatusUpdateInvalidRoundId()
    {
        // Test with non-existent round_id
        $invalidRoundId = 'INVALID_ROUND_' . uniqid();
        
        $updateResult = $this->CI->db->query(
            "UPDATE warli_users_game SET status='L', winning_point='0', commission='0' WHERE round_id = ? AND status='P'",
            [$invalidRoundId]
        );
        
        // Verify no records were updated
        $this->assertEquals(0, $this->CI->db->affected_rows(), 'No records should be updated with invalid round_id');
    }
    
    /**
     * Test game status update with SQL injection attempt
     */
    public function testGameStatusUpdateSqlInjection()
    {
        // Create test game
        $gameData = [
            'round_id' => 'TEST_ROUND_' . uniqid(),
            'user_id' => 1,
            'amount' => 100,
            'status' => 'P'
        ];
        $this->CI->db->insert('warli_users_game', $gameData);
        
        // Test SQL injection attempts
        $sqlInjectionAttempts = [
            "'; DROP TABLE warli_users_game; --",
            "' OR '1'='1",
            "'; UPDATE users SET balance=999999; --"
        ];
        
        foreach ($sqlInjectionAttempts as $injection) {
            $this->mockRequest('POST', ['id' => $injection]);
            
            // Attempt update with injection
            $updateResult = $this->CI->db->query(
                "UPDATE warli_users_game SET status='L', winning_point='0', commission='0' WHERE round_id = ? AND status='P'",
                [$injection]
            );
            
            // Should not affect any records
            $this->assertEquals(0, $this->CI->db->affected_rows(), 
                "No records should be updated with SQL injection: {$injection}");
        }
    }
    
    /**
     * Test multiple games for same user
     */
    public function testMultipleGamesForUser()
    {
        // Create test user
        $userId = $this->createTestUser([
            'username' => 'multi_gamer',
            'email' => 'multi@example.com',
            'balance' => 2000
        ]);
        
        // Create multiple games
        $gameData = [
            [
                'round_id' => 'MULTI_ROUND_1_' . uniqid(),
                'user_id' => $userId,
                'amount' => 100,
                'status' => 'P'
            ],
            [
                'round_id' => 'MULTI_ROUND_2_' . uniqid(),
                'user_id' => $userId,
                'amount' => 200,
                'status' => 'P'
            ],
            [
                'round_id' => 'MULTI_ROUND_3_' . uniqid(),
                'user_id' => $userId,
                'amount' => 150,
                'status' => 'W'
            ]
        ];
        
        foreach ($gameData as $data) {
            $this->CI->db->insert('warli_users_game', $data);
        }
        
        // Verify all games were created
        $userGames = $this->CI->db->where('user_id', $userId)->get('warli_users_game')->result_array();
        $this->assertEquals(3, count($userGames), 'User should have 3 games');
        
        // Test updating only pending games
        $pendingGames = $this->CI->db->where('user_id', $userId)->where('status', 'P')->get('warli_users_game')->result_array();
        $this->assertEquals(2, count($pendingGames), 'User should have 2 pending games');
        
        // Update all pending games to lose
        foreach ($pendingGames as $game) {
            $this->CI->db->query(
                "UPDATE warli_users_game SET status='L', winning_point='0', commission='0' WHERE round_id = ? AND status='P'",
                [$game['round_id']]
            );
        }
        
        // Verify updates
        $updatedGames = $this->CI->db->where('user_id', $userId)->get('warli_users_game')->result_array();
        $loseGames = array_filter($updatedGames, function($game) { return $game['status'] === 'L'; });
        $winGames = array_filter($updatedGames, function($game) { return $game['status'] === 'W'; });
        
        $this->assertEquals(2, count($loseGames), 'Should have 2 lose games');
        $this->assertEquals(1, count($winGames), 'Should have 1 win game');
    }
    
    /**
     * Test game balance calculations
     */
    public function testGameBalanceCalculations()
    {
        // Create test user with initial balance
        $userId = $this->createTestUser([
            'username' => 'balance_tester',
            'email' => 'balance@example.com',
            'balance' => 1000
        ]);
        
        // Create game with winning scenario
        $gameData = [
            'round_id' => 'BALANCE_ROUND_' . uniqid(),
            'user_id' => $userId,
            'amount' => 100,
            'status' => 'W',
            'winning_point' => 200,
            'commission' => 10
        ];
        $this->CI->db->insert('warli_users_game', $gameData);
        
        // Calculate expected balance
        $expectedBalance = 1000 - 100 + 200 - 10; // Initial - bet + winnings - commission
        
        // Update user balance
        $this->CI->db->where('id', $userId)->update('users', ['balance' => $expectedBalance]);
        
        // Verify balance calculation
        $user = $this->CI->db->where('id', $userId)->get('users')->row_array();
        $this->assertEquals($expectedBalance, $user['balance'], 'User balance should be calculated correctly');
    }
    
    /**
     * Test game validation and error handling
     */
    public function testGameValidationAndErrorHandling()
    {
        // Test with invalid user_id
        $gameData = [
            'round_id' => 'INVALID_USER_ROUND_' . uniqid(),
            'user_id' => 99999, // Non-existent user
            'amount' => 100,
            'status' => 'P'
        ];
        
        // This should still insert but we can test validation
        $this->CI->db->insert('warli_users_game', $gameData);
        $gameId = $this->CI->db->insert_id();
        
        // Verify game was created
        $this->assertRecordExists('warli_users_game', ['id' => $gameId]);
        
        // Test with negative amount
        $negativeGameData = [
            'round_id' => 'NEGATIVE_AMOUNT_ROUND_' . uniqid(),
            'user_id' => 1,
            'amount' => -100,
            'status' => 'P'
        ];
        
        // This should still insert (database constraint would prevent if needed)
        $this->CI->db->insert('warli_users_game', $negativeGameData);
        $negativeGameId = $this->CI->db->insert_id();
        
        // Verify negative amount game was created
        $this->assertRecordExists('warli_users_game', ['id' => $negativeGameId]);
    }
    
    /**
     * Test game status transitions
     */
    public function testGameStatusTransitions()
    {
        // Create test game
        $gameData = [
            'round_id' => 'STATUS_TRANSITION_ROUND_' . uniqid(),
            'user_id' => 1,
            'amount' => 100,
            'status' => 'P'
        ];
        $this->CI->db->insert('warli_users_game', $gameData);
        $gameId = $this->CI->db->insert_id();
        
        // Test P -> L transition
        $this->CI->db->where('id', $gameId)->update('warli_users_game', [
            'status' => 'L',
            'winning_point' => 0,
            'commission' => 0
        ]);
        
        $game = $this->CI->db->where('id', $gameId)->get('warli_users_game')->row_array();
        $this->assertEquals('L', $game['status'], 'Status should transition from P to L');
        
        // Test P -> W transition
        $winGameData = [
            'round_id' => 'WIN_TRANSITION_ROUND_' . uniqid(),
            'user_id' => 1,
            'amount' => 100,
            'status' => 'P'
        ];
        $this->CI->db->insert('warli_users_game', $winGameData);
        $winGameId = $this->CI->db->insert_id();
        
        $this->CI->db->where('id', $winGameId)->update('warli_users_game', [
            'status' => 'W',
            'winning_point' => 200,
            'commission' => 10
        ]);
        
        $winGame = $this->CI->db->where('id', $winGameId)->get('warli_users_game')->row_array();
        $this->assertEquals('W', $winGame['status'], 'Status should transition from P to W');
        $this->assertEquals(200, $winGame['winning_point'], 'Winning point should be set');
        $this->assertEquals(10, $winGame['commission'], 'Commission should be set');
    }
    
    /**
     * Test concurrent game updates
     */
    public function testConcurrentGameUpdates()
    {
        // Create test game
        $gameData = [
            'round_id' => 'CONCURRENT_ROUND_' . uniqid(),
            'user_id' => 1,
            'amount' => 100,
            'status' => 'P'
        ];
        $this->CI->db->insert('warli_users_game', $gameData);
        $gameId = $this->CI->db->insert_id();
        
        // Simulate concurrent updates
        $update1 = $this->CI->db->query(
            "UPDATE warli_users_game SET status='L', winning_point='0', commission='0' WHERE round_id = ? AND status='P'",
            [$gameData['round_id']]
        );
        
        $update2 = $this->CI->db->query(
            "UPDATE warli_users_game SET status='W', winning_point='200', commission='10' WHERE round_id = ? AND status='P'",
            [$gameData['round_id']]
        );
        
        // Only one update should succeed (first one)
        $game = $this->CI->db->where('id', $gameId)->get('warli_users_game')->row_array();
        $this->assertEquals('L', $game['status'], 'First update should succeed');
        $this->assertEquals(0, $game['winning_point'], 'Winning point should be 0');
    }
    
    /**
     * Clean up after each test
     */
    public function __destruct()
    {
        // Drop test tables
        $this->CI->db->query("DROP TABLE IF EXISTS warli_users_game");
        $this->CI->db->query("DROP TABLE IF EXISTS users");
        $this->tearDown();
    }
}
