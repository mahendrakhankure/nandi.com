import { Router } from 'express';
import adminController from '../controllers/adminController';
import { requireAuth, requireAdmin, requireSuperAdmin } from '../middleware/auth';
import { validatePagination, validateDateRange } from '../middleware/validation';

const router = Router();

// Apply admin authentication to all routes
router.use(requireAuth, requireAdmin);

// Dashboard
router.get('/dashboard', adminController.getDashboard);

// Game Types Management
router.get('/game-types', validatePagination, adminController.getAllGameTypes);
router.post('/game-types', adminController.createGameType);
router.put('/game-types/:id', adminController.updateGameType);
router.delete('/game-types/:id', requireSuperAdmin, adminController.deleteGameType);

// Game Results Management
router.get('/game-results', validatePagination, validateDateRange, adminController.getAllGameResults);
router.post('/game-results', adminController.createGameResult);
router.put('/game-results/:id', adminController.updateGameResult);
router.delete('/game-results/:id', requireSuperAdmin, adminController.deleteGameResult);

// Currency Rates Management
router.get('/currency-rates', validatePagination, adminController.getAllCurrencyRates);
router.post('/currency-rates', adminController.createCurrencyRate);
router.put('/currency-rates/:id', adminController.updateCurrencyRate);
router.delete('/currency-rates/:id', requireSuperAdmin, adminController.deleteCurrencyRate);

export default router;

