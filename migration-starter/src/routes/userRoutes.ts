import { Router } from 'express';
import userController from '../controllers/userController';
import { authenticate, requireAdmin, requireRole } from '../middleware/auth';
import { validateUserUpdate, validatePagination, validateSearch } from '../middleware/validation';
import { sanitizeBody, sanitizeQuery } from '../middleware/validation';

const router = Router();

// Apply sanitization to all routes
router.use(sanitizeBody);
router.use(sanitizeQuery);

// Public routes (with optional auth)
router.get('/search', validateSearch, userController.searchUsers);

// Protected routes - require authentication
router.use(authenticate);

// User management routes - require admin access
router.get('/', requireAdmin, validatePagination, userController.getAllUsers);
router.get('/stats', requireAdmin, userController.getUserStats);
router.get('/:id', requireAdmin, userController.getUserById);
router.put('/:id', requireAdmin, validateUserUpdate, userController.updateUser);
router.delete('/:id', requireRole(['admin', 'super_admin']), userController.deleteUser);
router.patch('/:id/status', requireAdmin, userController.changeUserStatus);

export default router;

