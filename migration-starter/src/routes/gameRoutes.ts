import { Router } from 'express';
import gameController from '../controllers/gameController';
import { authenticate, requireAdmin, optionalAuth } from '../middleware/auth';
import { validateGame, validatePagination, validateSearch } from '../middleware/validation';
import { sanitizeBody, sanitizeQuery } from '../middleware/validation';

const router = Router();

// Apply sanitization to all routes
router.use(sanitizeBody);
router.use(sanitizeQuery);

// Public routes (with optional auth)
router.get('/search', validateSearch, gameController.searchGames);
router.get('/type/:type', validatePagination, gameController.getGamesByType);

// Protected routes - require authentication
router.use(authenticate);

// Game management routes - require admin access
router.get('/', requireAdmin, validatePagination, gameController.getAllGames);
router.get('/stats', requireAdmin, gameController.getGameStats);
router.get('/:id', requireAdmin, gameController.getGameById);
router.post('/', requireAdmin, validateGame, gameController.createGame);
router.put('/:id', requireAdmin, validateGame, gameController.updateGame);
router.delete('/:id', requireAdmin, gameController.deleteGame);
router.patch('/:id/status', requireAdmin, gameController.changeGameStatus);

export default router;

