import { Router } from 'express';
import clientController from '../controllers/clientController';
import { requireAuth, validateRequest } from '../middleware/auth';
import { validatePagination, validateDateRange } from '../middleware/validation';

const router = Router();

// Client Dashboard
router.get('/dashboard', requireAuth, clientController.getClientDashboard);

// Game Types
router.get('/game-types', clientController.getAvailableGameTypes);

// Betting Operations
router.post('/place-bet', requireAuth, clientController.placeBet);
router.get('/betting-history', requireAuth, validatePagination, validateDateRange, clientController.getBettingHistory);

// Game Results
router.get('/game-results', validatePagination, validateDateRange, clientController.getGameResults);

// User Profile
router.get('/profile', requireAuth, clientController.getUserProfile);
router.put('/profile', requireAuth, clientController.updateUserProfile);

// User Statistics
router.get('/stats', requireAuth, validateDateRange, clientController.getUserStats);

export default router;

