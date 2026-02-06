import { Request, Response } from 'express';
import { AuthService } from '../services/AuthService';
import { User } from '../models/User';
import { Admin } from '../models/Admin';
import { validateLoginInput, validateRegisterInput } from '../middleware/validation';

class AuthController {
  private authService: AuthService;

  constructor() {
    this.authService = new AuthService();
  }

  // User Login
  async login(req: Request, res: Response): Promise<void> {
    try {
      const { email, password, userType = 'user' } = req.body;

      // Validate input
      const validation = validateLoginInput(req.body);
      if (!validation.isValid) {
        res.status(400).json({
          success: false,
          message: 'Validation failed',
          errors: validation.errors
        });
        return;
      }

      // Determine which model to use
      const Model = userType === 'admin' ? Admin : User;
      
      // Find user by email
      const user = await Model.findOne({ email }).select('+password');
      
      if (!user) {
        res.status(401).json({
          success: false,
          message: 'Invalid credentials'
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

      // Verify password
      const isPasswordValid = await user.comparePassword(password);
      if (!isPasswordValid) {
        res.status(401).json({
          success: false,
          message: 'Invalid credentials'
        });
        return;
      }

      // Generate tokens
      const token = this.authService.generateToken(user._id.toString(), userType);
      const refreshToken = this.authService.generateRefreshToken(user._id.toString());

      // Update user's refresh token
      await Model.findByIdAndUpdate(user._id, { 
        refreshToken,
        lastLogin: new Date()
      });

      // Remove password from response
      const userResponse = user.toObject();
      delete userResponse.password;
      delete userResponse.refreshToken;

      res.status(200).json({
        success: true,
        message: 'Login successful',
        data: {
          user: userResponse,
          token,
          refreshToken
        }
      });

    } catch (error) {
      console.error('Login error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // User Registration
  async register(req: Request, res: Response): Promise<void> {
    try {
      const { username, email, password, userType = 'user' } = req.body;

      // Validate input
      const validation = validateRegisterInput(req.body);
      if (!validation.isValid) {
        res.status(400).json({
          success: false,
          message: 'Validation failed',
          errors: validation.errors
        });
        return;
      }

      // Determine which model to use
      const Model = userType === 'admin' ? Admin : User;

      // Check if user already exists
      const existingUser = await Model.findOne({ 
        $or: [{ email }, { username }] 
      });

      if (existingUser) {
        res.status(400).json({
          success: false,
          message: 'User already exists with this email or username'
        });
        return;
      }

      // Create new user
      const newUser = new Model({
        username,
        email,
        password,
        status: 'active'
      });

      await newUser.save();

      // Generate tokens
      const token = this.authService.generateToken(newUser._id.toString(), userType);
      const refreshToken = this.authService.generateRefreshToken(newUser._id.toString());

      // Update user's refresh token
      await Model.findByIdAndUpdate(newUser._id, { refreshToken });

      // Remove password from response
      const userResponse = newUser.toObject();
      delete userResponse.password;
      delete userResponse.refreshToken;

      res.status(201).json({
        success: true,
        message: 'Registration successful',
        data: {
          user: userResponse,
          token,
          refreshToken
        }
      });

    } catch (error) {
      console.error('Registration error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Refresh Token
  async refreshToken(req: Request, res: Response): Promise<void> {
    try {
      const { refreshToken } = req.body;

      if (!refreshToken) {
        res.status(400).json({
          success: false,
          message: 'Refresh token is required'
        });
        return;
      }

      // Verify refresh token
      const decoded = this.authService.verifyRefreshToken(refreshToken);
      if (!decoded) {
        res.status(401).json({
          success: false,
          message: 'Invalid refresh token'
        });
        return;
      }

      // Find user by ID
      const user = await User.findById(decoded.userId);
      if (!user || user.refreshToken !== refreshToken) {
        res.status(401).json({
          success: false,
          message: 'Invalid refresh token'
        });
        return;
      }

      // Generate new tokens
      const newToken = this.authService.generateToken(user._id.toString(), 'user');
      const newRefreshToken = this.authService.generateRefreshToken(user._id.toString());

      // Update user's refresh token
      await User.findByIdAndUpdate(user._id, { refreshToken: newRefreshToken });

      res.status(200).json({
        success: true,
        message: 'Token refreshed successfully',
        data: {
          token: newToken,
          refreshToken: newRefreshToken
        }
      });

    } catch (error) {
      console.error('Refresh token error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Logout
  async logout(req: Request, res: Response): Promise<void> {
    try {
      const userId = req.user?.id;

      if (userId) {
        // Clear refresh token
        await User.findByIdAndUpdate(userId, { refreshToken: null });
      }

      res.status(200).json({
        success: true,
        message: 'Logout successful'
      });

    } catch (error) {
      console.error('Logout error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Get Current User
  async getCurrentUser(req: Request, res: Response): Promise<void> {
    try {
      const userId = req.user?.id;

      if (!userId) {
        res.status(401).json({
          success: false,
          message: 'Not authenticated'
        });
        return;
      }

      const user = await User.findById(userId);
      if (!user) {
        res.status(404).json({
          success: false,
          message: 'User not found'
        });
        return;
      }

      // Remove sensitive fields
      const userResponse = user.toObject();
      delete userResponse.password;
      delete userResponse.refreshToken;

      res.status(200).json({
        success: true,
        message: 'User retrieved successfully',
        data: userResponse
      });

    } catch (error) {
      console.error('Get current user error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }
}

export default new AuthController();

