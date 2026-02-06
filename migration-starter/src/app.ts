import express from 'express';
import cors from 'cors';
import helmet from 'helmet';
import compression from 'compression';
import rateLimit from 'express-rate-limit';
import dotenv from 'dotenv';

// Import routes
import authRoutes from './routes/authRoutes';
import userRoutes from './routes/userRoutes';
import gameRoutes from './routes/gameRoutes';
import clientRoutes from './routes/clientRoutes';
import adminRoutes from './routes/adminRoutes';

// Import services
import DatabaseService from './services/DatabaseService';

// Load environment variables
dotenv.config();

const app = express();
const PORT = process.env.PORT || 3000;

// Security middleware
app.use(helmet({
  contentSecurityPolicy: {
    directives: {
      defaultSrc: ["'self'"],
      styleSrc: ["'self'", "'unsafe-inline'"],
      scriptSrc: ["'self'"],
      imgSrc: ["'self'", "data:", "https:"],
    },
  },
  crossOriginEmbedderPolicy: false,
}));

// CORS configuration
app.use(cors({
  origin: process.env.ALLOWED_ORIGINS?.split(',') || ['http://localhost:3000'],
  credentials: true,
  methods: ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
  allowedHeaders: ['Content-Type', 'Authorization']
}));

// Rate limiting
const limiter = rateLimit({
  windowMs: 15 * 60 * 1000, // 15 minutes
  max: 100, // limit each IP to 100 requests per windowMs
  message: {
    success: false,
    message: 'Too many requests from this IP, please try again later.'
  },
  standardHeaders: true,
  legacyHeaders: false,
});

app.use(limiter);

// Body parsing middleware
app.use(express.json({ limit: '10mb' }));
app.use(express.urlencoded({ extended: true, limit: '10mb' }));

// Compression middleware
app.use(compression());

// Request logging middleware
app.use((req, res, next) => {
  console.log(`${new Date().toISOString()} - ${req.method} ${req.path} - ${req.ip}`);
  next();
});

// Health check endpoint
app.get('/health', async (req, res) => {
  try {
    const dbStatus = await DatabaseService.healthCheck();
    
    res.status(200).json({
      success: true,
      message: 'Server is healthy',
      timestamp: new Date().toISOString(),
      database: dbStatus,
      uptime: process.uptime(),
      environment: process.env.NODE_ENV || 'development'
    });
  } catch (error) {
    console.error('Health check failed:', error);
    res.status(503).json({
      success: false,
      message: 'Server is unhealthy',
      timestamp: new Date().toISOString(),
      error: error instanceof Error ? error.message : 'Unknown error'
    });
  }
});

// API routes
app.use('/api/auth', authRoutes);
app.use('/api/users', userRoutes);
app.use('/api/games', gameRoutes);
app.use('/api/client', clientRoutes);
app.use('/api/admin', adminRoutes);

// API documentation endpoint
app.get('/api', (req, res) => {
  res.json({
    success: true,
    message: 'Nandi Live API',
    version: '1.0.0',
    endpoints: {
      auth: {
        'POST /api/auth/login': 'User login',
        'POST /api/auth/register': 'User registration',
        'POST /api/auth/refresh-token': 'Refresh access token',
        'POST /api/auth/logout': 'User logout',
        'GET /api/auth/me': 'Get current user'
      },
      users: {
        'GET /api/users': 'Get all users (admin only)',
        'GET /api/users/stats': 'Get user statistics (admin only)',
        'GET /api/users/:id': 'Get user by ID (admin only)',
        'PUT /api/users/:id': 'Update user (admin only)',
        'DELETE /api/users/:id': 'Delete user (admin only)',
        'PATCH /api/users/:id/status': 'Change user status (admin only)',
        'GET /api/users/search': 'Search users (public)'
      },
      games: {
        'GET /api/games': 'Get all games (admin only)',
        'GET /api/games/stats': 'Get game statistics (admin only)',
        'GET /api/games/:id': 'Get game by ID (admin only)',
        'POST /api/games': 'Create new game (admin only)',
        'PUT /api/games/:id': 'Update game (admin only)',
        'DELETE /api/games/:id': 'Delete game (admin only)',
        'PATCH /api/games/:id/status': 'Change game status (admin only)',
        'GET /api/games/search': 'Search games (public)',
        'GET /api/games/type/:type': 'Get games by type (public)'
      },
      client: {
        'GET /api/client/dashboard': 'Get client dashboard (authenticated)',
        'GET /api/client/game-types': 'Get available game types (public)',
        'POST /api/client/place-bet': 'Place a bet (authenticated)',
        'GET /api/client/betting-history': 'Get betting history (authenticated)',
        'GET /api/client/game-results': 'Get game results (public)',
        'GET /api/client/profile': 'Get user profile (authenticated)',
        'PUT /api/client/profile': 'Update user profile (authenticated)',
        'GET /api/client/stats': 'Get user statistics (authenticated)'
      },
      admin: {
        'GET /api/admin/dashboard': 'Get admin dashboard (admin only)',
        'GET /api/admin/game-types': 'Get all game types (admin only)',
        'POST /api/admin/game-types': 'Create game type (admin only)',
        'PUT /api/admin/game-types/:id': 'Update game type (admin only)',
        'DELETE /api/admin/game-types/:id': 'Delete game type (super admin only)',
        'GET /api/admin/game-results': 'Get all game results (admin only)',
        'POST /api/admin/game-results': 'Create game result (admin only)',
        'PUT /api/admin/game-results/:id': 'Update game result (admin only)',
        'DELETE /api/admin/game-results/:id': 'Delete game result (super admin only)',
        'GET /api/admin/currency-rates': 'Get all currency rates (admin only)',
        'POST /api/admin/currency-rates': 'Create currency rate (admin only)',
        'PUT /api/admin/currency-rates/:id': 'Update currency rate (admin only)',
        'DELETE /api/admin/currency-rates/:id': 'Delete currency rate (super admin only)'
      }
    },
    authentication: 'Bearer token required for protected routes',
    rateLimit: '100 requests per 15 minutes per IP'
  });
});

// 404 handler
app.use('*', (req, res) => {
  res.status(404).json({
    success: false,
    message: 'Endpoint not found',
    path: req.originalUrl,
    method: req.method
  });
});

// Global error handler
app.use((error: any, req: express.Request, res: express.Response, next: express.NextFunction) => {
  console.error('Global error handler:', error);
  
  // Handle specific error types
  if (error.name === 'ValidationError') {
    return res.status(400).json({
      success: false,
      message: 'Validation error',
      errors: Object.values(error.errors).map((err: any) => err.message)
    });
  }
  
  if (error.name === 'CastError') {
    return res.status(400).json({
      success: false,
      message: 'Invalid ID format'
    });
  }
  
  if (error.code === 11000) {
    return res.status(400).json({
      success: false,
      message: 'Duplicate field value'
    });
  }
  
  // Default error response
  res.status(500).json({
    success: false,
    message: process.env.NODE_ENV === 'production' 
      ? 'Internal server error' 
      : error.message,
    ...(process.env.NODE_ENV !== 'production' && { stack: error.stack })
  });
});

// Graceful shutdown
process.on('SIGTERM', async () => {
  console.log('SIGTERM received, shutting down gracefully');
  await DatabaseService.disconnect();
  process.exit(0);
});

process.on('SIGINT', async () => {
  console.log('SIGINT received, shutting down gracefully');
  await DatabaseService.disconnect();
  process.exit(0);
});

// Start server
const startServer = async () => {
  try {
    // Initialize database connection
    await DatabaseService.connect();
    
    app.listen(PORT, () => {
      console.log(`🚀 Server running on port ${PORT}`);
      console.log(`📚 API Documentation: http://localhost:${PORT}/api`);
      console.log(`🏥 Health Check: http://localhost:${PORT}/health`);
      console.log(`🌍 Environment: ${process.env.NODE_ENV || 'development'}`);
    });
  } catch (error) {
    console.error('Failed to start server:', error);
    process.exit(1);
  }
};

// Handle unhandled promise rejections
process.on('unhandledRejection', (reason, promise) => {
  console.error('Unhandled Rejection at:', promise, 'reason:', reason);
  process.exit(1);
});

// Handle uncaught exceptions
process.on('uncaughtException', (error) => {
  console.error('Uncaught Exception:', error);
  process.exit(1);
});

startServer();

export default app;
