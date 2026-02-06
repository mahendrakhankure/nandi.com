import { Router } from 'express';
import authController from '../controllers/authController';
import { validateLogin, validateRegister } from '../middleware/validation';
import { checkRateLimit } from '../middleware/auth';

const router = Router();

// Rate limiting for auth routes
const authRateLimit = checkRateLimit(5, 15 * 60 * 1000); // 5 requests per 15 minutes

// Public routes
router.post('/login', authRateLimit, validateLogin, authController.login);
router.post('/register', authRateLimit, validateRegister, authController.register);
router.post('/refresh-token', authRateLimit, authController.refreshToken);

// Protected routes
router.post('/logout', authController.logout);
router.get('/me', authController.getCurrentUser);

export default router;

