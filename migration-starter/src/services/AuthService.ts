import jwt from 'jsonwebtoken';
import bcrypt from 'bcryptjs';
import { User } from '../models/User';
import { Admin } from '../models/Admin';

export interface JWTPayload {
  userId: string;
  email: string;
  userType: string;
  role?: string;
}

export interface RefreshTokenPayload {
  userId: string;
  tokenId: string;
}

class AuthService {
  private readonly JWT_SECRET: string;
  private readonly JWT_REFRESH_SECRET: string;
  private readonly JWT_EXPIRES_IN: string;
  private readonly JWT_REFRESH_EXPIRES_IN: string;

  constructor() {
    this.JWT_SECRET = process.env.JWT_SECRET || 'your-super-secret-jwt-key-change-this-in-production';
    this.JWT_REFRESH_SECRET = process.env.JWT_REFRESH_SECRET || 'your-super-secret-refresh-key-change-this-in-production';
    this.JWT_EXPIRES_IN = process.env.JWT_EXPIRES_IN || '15m';
    this.JWT_REFRESH_EXPIRES_IN = process.env.JWT_REFRESH_EXPIRES_IN || '7d';
  }

  // Generate JWT token
  generateToken(userId: string, userType: string, role?: string): string {
    const payload: JWTPayload = {
      userId,
      userType,
      role
    };

    return jwt.sign(payload, this.JWT_SECRET, {
      expiresIn: this.JWT_EXPIRES_IN
    });
  }

  // Generate refresh token
  generateRefreshToken(userId: string): string {
    const tokenId = this.generateTokenId();
    const payload: RefreshTokenPayload = {
      userId,
      tokenId
    };

    return jwt.sign(payload, this.JWT_REFRESH_SECRET, {
      expiresIn: this.JWT_REFRESH_EXPIRES_IN
    });
  }

  // Verify JWT token
  verifyToken(token: string): JWTPayload | null {
    try {
      return jwt.verify(token, this.JWT_SECRET) as JWTPayload;
    } catch (error) {
      return null;
    }
  }

  // Verify refresh token
  verifyRefreshToken(token: string): RefreshTokenPayload | null {
    try {
      return jwt.verify(token, this.JWT_REFRESH_SECRET) as RefreshTokenPayload;
    } catch (error) {
      return null;
    }
  }

  // Generate token ID for refresh tokens
  private generateTokenId(): string {
    return Math.random().toString(36).substring(2) + Date.now().toString(36);
  }

  // Hash password
  async hashPassword(password: string): Promise<string> {
    const saltRounds = 12;
    return bcrypt.hash(password, saltRounds);
  }

  // Compare password
  async comparePassword(password: string, hashedPassword: string): Promise<boolean> {
    return bcrypt.compare(password, hashedPassword);
  }

  // Validate login credentials
  async validateLogin(email: string, password: string, userType: string = 'user'): Promise<any> {
    try {
      // Determine which model to use
      const Model = userType === 'admin' ? Admin : User;
      
      // Find user by email
      const user = await Model.findOne({ email }).select('+password');
      
      if (!user) {
        return { success: false, message: 'Invalid credentials' };
      }

      // Check if user is active
      if (user.status !== 'active') {
        return { success: false, message: 'Account is not active' };
      }

      // Verify password
      const isPasswordValid = await user.comparePassword(password);
      if (!isPasswordValid) {
        return { success: false, message: 'Invalid credentials' };
      }

      return { success: true, user };
    } catch (error) {
      console.error('Login validation error:', error);
      return { success: false, message: 'Login validation failed' };
    }
  }

  // Generate tokens for user
  async generateUserTokens(user: any, userType: string): Promise<{ token: string; refreshToken: string }> {
    const token = this.generateToken(user._id.toString(), userType, user.role);
    const refreshToken = this.generateRefreshToken(user._id.toString());

    // Update user's refresh token
    const Model = userType === 'admin' ? Admin : User;
    await Model.findByIdAndUpdate(user._id, { refreshToken });

    return { token, refreshToken };
  }

  // Invalidate refresh token
  async invalidateRefreshToken(userId: string, userType: string = 'user'): Promise<void> {
    try {
      const Model = userType === 'admin' ? Admin : User;
      await Model.findByIdAndUpdate(userId, { refreshToken: null });
    } catch (error) {
      console.error('Error invalidating refresh token:', error);
    }
  }

  // Check if refresh token is valid
  async isRefreshTokenValid(userId: string, refreshToken: string, userType: string = 'user'): Promise<boolean> {
    try {
      const Model = userType === 'admin' ? Admin : User;
      const user = await Model.findById(userId);
      
      if (!user || user.refreshToken !== refreshToken) {
        return false;
      }

      return true;
    } catch (error) {
      console.error('Error checking refresh token validity:', error);
      return false;
    }
  }

  // Generate password reset token
  generatePasswordResetToken(userId: string): string {
    const payload = {
      userId,
      type: 'password_reset',
      timestamp: Date.now()
    };

    return jwt.sign(payload, this.JWT_SECRET, {
      expiresIn: '1h' // Password reset tokens expire in 1 hour
    });
  }

  // Verify password reset token
  verifyPasswordResetToken(token: string): { userId: string; type: string; timestamp: number } | null {
    try {
      const payload = jwt.verify(token, this.JWT_SECRET) as any;
      
      if (payload.type !== 'password_reset') {
        return null;
      }

      return payload;
    } catch (error) {
      return null;
    }
  }

  // Generate email verification token
  generateEmailVerificationToken(userId: string, email: string): string {
    const payload = {
      userId,
      email,
      type: 'email_verification',
      timestamp: Date.now()
    };

    return jwt.sign(payload, this.JWT_SECRET, {
      expiresIn: '24h' // Email verification tokens expire in 24 hours
    });
  }

  // Verify email verification token
  verifyEmailVerificationToken(token: string): { userId: string; email: string; type: string; timestamp: number } | null {
    try {
      const payload = jwt.verify(token, this.JWT_SECRET) as any;
      
      if (payload.type !== 'email_verification') {
        return null;
      }

      return payload;
    } catch (error) {
      return null;
    }
  }

  // Get token expiration time
  getTokenExpirationTime(): number {
    const expiresIn = this.JWT_EXPIRES_IN;
    
    if (expiresIn.includes('m')) {
      return parseInt(expiresIn) * 60 * 1000; // Convert minutes to milliseconds
    } else if (expiresIn.includes('h')) {
      return parseInt(expiresIn) * 60 * 60 * 1000; // Convert hours to milliseconds
    } else if (expiresIn.includes('d')) {
      return parseInt(expiresIn) * 24 * 60 * 60 * 1000; // Convert days to milliseconds
    }
    
    return 15 * 60 * 1000; // Default 15 minutes
  }
}

export default new AuthService();

