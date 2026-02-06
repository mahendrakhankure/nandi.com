import { Request, Response, NextFunction } from 'express';
import jwt from 'jsonwebtoken';
import { User } from '../models/User';
import { Admin } from '../models/Admin';

// Extend Express Request interface to include user
declare global {
  namespace Express {
    interface Request {
      user?: {
        id: string;
        email: string;
        userType: string;
        role?: string;
      };
    }
  }
}

export interface JWTPayload {
  userId: string;
  email: string;
  userType: string;
  role?: string;
}

// Authentication middleware
export const authenticate = async (req: Request, res: Response, next: NextFunction): Promise<void> => {
  try {
    const authHeader = req.headers.authorization;
    
    if (!authHeader || !authHeader.startsWith('Bearer ')) {
      res.status(401).json({
        success: false,
        message: 'Access token required'
      });
      return;
    }

    const token = authHeader.substring(7); // Remove 'Bearer ' prefix

    // Verify token
    const decoded = jwt.verify(token, process.env.JWT_SECRET!) as JWTPayload;
    
    if (!decoded) {
      res.status(401).json({
        success: false,
        message: 'Invalid token'
      });
      return;
    }

    // Find user based on user type
    const Model = decoded.userType === 'admin' ? Admin : User;
    const user = await Model.findById(decoded.userId).select('-password -refreshToken');

    if (!user) {
      res.status(401).json({
        success: false,
        message: 'User not found'
      });
      return;
    }

    // Check if user is active
    if (user.status !== 'active') {
      res.status(401).json({
        success: false,
        message: 'Account is not active'
      });
      return;
    }

    // Attach user to request
    req.user = {
      id: user._id.toString(),
      email: user.email,
      userType: decoded.userType,
      role: user.role
    };

    next();

  } catch (error) {
    console.error('Authentication error:', error);
    
    if (error instanceof jwt.JsonWebTokenError) {
      res.status(401).json({
        success: false,
        message: 'Invalid token'
      });
      return;
    }

    if (error instanceof jwt.TokenExpiredError) {
      res.status(401).json({
        success: false,
        message: 'Token expired'
      });
      return;
    }

    res.status(500).json({
      success: false,
      message: 'Authentication failed'
    });
  }
};

// Admin authorization middleware
export const requireAdmin = (req: Request, res: Response, next: NextFunction): void => {
  if (!req.user) {
    res.status(401).json({
      success: false,
      message: 'Authentication required'
    });
    return;
  }

  if (req.user.userType !== 'admin') {
    res.status(403).json({
      success: false,
      message: 'Admin access required'
    });
    return;
  }

  next();
};

// Role-based authorization middleware
export const requireRole = (roles: string[]) => {
  return (req: Request, res: Response, next: NextFunction): void => {
    if (!req.user) {
      res.status(401).json({
        success: false,
        message: 'Authentication required'
      });
      return;
    }

    if (!req.user.role || !roles.includes(req.user.role)) {
      res.status(403).json({
        success: false,
        message: 'Insufficient permissions'
      });
      return;
    }

    next();
  };
};

// Super admin authorization middleware
export const requireSuperAdmin = (req: Request, res: Response, next: NextFunction): void => {
  if (!req.user) {
    res.status(401).json({
      success: false,
      message: 'Authentication required'
    });
    return;
  }

  if (req.user.userType !== 'admin' || req.user.role !== 'super_admin') {
    res.status(403).json({
      success: false,
      message: 'Super admin access required'
    });
    return;
  }

  next();
};

// Optional authentication middleware (doesn't fail if no token)
export const optionalAuth = async (req: Request, res: Response, next: NextFunction): Promise<void> => {
  try {
    const authHeader = req.headers.authorization;
    
    if (!authHeader || !authHeader.startsWith('Bearer ')) {
      next();
      return;
    }

    const token = authHeader.substring(7);

    const decoded = jwt.verify(token, process.env.JWT_SECRET!) as JWTPayload;
    
    if (!decoded) {
      next();
      return;
    }

    const Model = decoded.userType === 'admin' ? Admin : User;
    const user = await Model.findById(decoded.userId).select('-password -refreshToken');

    if (user && user.status === 'active') {
      req.user = {
        id: user._id.toString(),
        email: user.email,
        userType: decoded.userType,
        role: user.role
      };
    }

    next();

  } catch (error) {
    // Don't fail on authentication errors, just continue without user
    next();
  }
};

// Rate limiting helper
export const checkRateLimit = (maxRequests: number, windowMs: number) => {
  const requests = new Map<string, { count: number; resetTime: number }>();

  return (req: Request, res: Response, next: NextFunction): void => {
    const key = req.ip || 'unknown';
    const now = Date.now();

    const userRequests = requests.get(key);
    
    if (!userRequests || now > userRequests.resetTime) {
      requests.set(key, { count: 1, resetTime: now + windowMs });
      next();
      return;
    }

    if (userRequests.count >= maxRequests) {
      res.status(429).json({
        success: false,
        message: 'Too many requests, please try again later'
      });
      return;
    }

    userRequests.count++;
    next();
  };
};

