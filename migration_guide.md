# 🚀 **PHP TO NODE.JS TYPESCRIPT MIGRATION GUIDE**
## Complete Migration Strategy for CodeIgniter Project with MongoDB

---

## **📋 MIGRATION OVERVIEW**

### **Current State Analysis**
- **Framework**: CodeIgniter 3.x (PHP)
- **Database**: MySQL with mysqli
- **Architecture**: MVC Pattern
- **Security**: Enhanced with parameterized queries, CSRF, XSS protection
- **Performance**: Optimized (100% test success rate)

### **Target State**
- **Framework**: Node.js with Express.js
- **Language**: TypeScript
- **Database**: MongoDB 7.0+ with Mongoose ODM
- **Architecture**: MVC Pattern with TypeScript interfaces
- **Security**: JWT, bcrypt, helmet, express-rate-limit
- **Performance**: Async/await, connection pooling, MongoDB aggregation

---

## **🎯 MIGRATION STRATEGY**

### **Phase 1: Project Setup & Infrastructure**
1. **Node.js Environment Setup**
2. **TypeScript Configuration**
3. **MongoDB Migration Strategy**
4. **Security Framework Setup**

### **Phase 2: Core Components Migration**
1. **MongoDB Models & Mongoose ODM**
2. **Authentication System**
3. **API Controllers**
4. **Middleware & Security**

### **Phase 3: Business Logic Migration**
1. **Helper Functions**
2. **Custom Libraries**
3. **Validation & Sanitization**
4. **File Operations**

### **Phase 4: Testing & Deployment**
1. **Unit Tests**
2. **Integration Tests**
3. **Performance Testing**
4. **Production Deployment**

---

## **🛠️ IMPLEMENTATION GUIDE**

### **1. PROJECT STRUCTURE SETUP**

```typescript
// Project Structure
src/
├── config/
│   ├── database.ts
│   ├── auth.ts
│   └── app.ts
├── models/
│   ├── User.ts
│   ├── Admin.ts
│   └── Game.ts
├── controllers/
│   ├── auth/
│   │   ├── AuthController.ts
│   │   └── AdminAuthController.ts
│   └── api/
│       ├── UserController.ts
│       └── GameController.ts
├── middleware/
│   ├── auth.ts
│   ├── validation.ts
│   └── security.ts
├── services/
│   ├── DatabaseService.ts
│   ├── AuthService.ts
│   └── GameService.ts
├── utils/
│   ├── helpers.ts
│   ├── validators.ts
│   └── logger.ts
├── types/
│   ├── user.types.ts
│   ├── game.types.ts
│   └── api.types.ts
├── routes/
│   ├── auth.ts
│   ├── user.ts
│   └── admin.ts
└── app.ts
```

### **2. PACKAGE.JSON SETUP**

```json
{
  "name": "nandi-live-nodejs",
  "version": "1.0.0",
  "description": "Migrated CodeIgniter project to Node.js TypeScript with MongoDB",
  "main": "dist/app.js",
  "scripts": {
    "build": "tsc",
    "start": "node dist/app.js",
    "dev": "nodemon src/app.ts",
    "test": "jest",
    "lint": "eslint src/**/*.ts",
    "migrate": "ts-node src/scripts/migrate.ts"
  },
  "dependencies": {
    "express": "^4.18.2",
    "mongoose": "^8.0.0",
    "mongodb": "^6.3.0",
    "bcryptjs": "^2.4.3",
    "jsonwebtoken": "^9.0.2",
    "helmet": "^7.0.0",
    "express-rate-limit": "^6.10.0",
    "express-validator": "^7.0.1",
    "cors": "^2.8.5",
    "dotenv": "^16.3.1",
    "winston": "^3.10.0",
    "multer": "^1.4.5-lts.1",
    "joi": "^17.9.2",
    "axios": "^1.5.0",
    "compression": "^1.7.4",
    "express-slow-down": "^1.6.0",
    "express-brute": "^1.0.1",
    "express-brute-redis": "^0.0.1",
    "ioredis": "^5.3.2"
  },
  "devDependencies": {
    "@types/express": "^4.17.17",
    "@types/node": "^20.5.0",
    "@types/bcryptjs": "^2.4.2",
    "@types/jsonwebtoken": "^9.0.2",
    "@types/cors": "^2.8.13",
    "@types/multer": "^1.4.7",
    "typescript": "^5.1.6",
    "ts-node": "^10.9.1",
    "nodemon": "^3.0.1",
    "jest": "^29.6.2",
    "@types/jest": "^29.5.4",
    "eslint": "^8.45.0",
    "@typescript-eslint/eslint-plugin": "^6.3.0",
    "@typescript-eslint/parser": "^6.3.0"
  }
}
```

### **3. TYPESCRIPT CONFIGURATION**

```json
// tsconfig.json
{
  "compilerOptions": {
    "target": "ES2020",
    "module": "commonjs",
    "lib": ["ES2020"],
    "outDir": "./dist",
    "rootDir": "./src",
    "strict": true,
    "esModuleInterop": true,
    "skipLibCheck": true,
    "forceConsistentCasingInFileNames": true,
    "resolveJsonModule": true,
    "declaration": true,
    "declarationMap": true,
    "sourceMap": true,
    "removeComments": true,
    "noImplicitAny": true,
    "strictNullChecks": true,
    "strictFunctionTypes": true,
    "noImplicitReturns": true,
    "noFallthroughCasesInSwitch": true,
    "noUncheckedIndexedAccess": true,
    "noImplicitOverride": true,
    "exactOptionalPropertyTypes": true
  },
  "include": ["src/**/*"],
  "exclude": ["node_modules", "dist", "**/*.test.ts"]
}
```

### **4. MONGODB MIGRATION STRATEGY**

#### **A. Mongoose Schema Setup**

```typescript
// src/models/User.ts
import mongoose, { Document, Schema } from 'mongoose';
import bcrypt from 'bcryptjs';

export interface IUser extends Document {
  username: string;
  email: string;
  password: string;
  status: string;
  createdAt: Date;
  updatedAt: Date;
  comparePassword(candidatePassword: string): Promise<boolean>;
}

const UserSchema = new Schema<IUser>({
  username: {
    type: String,
    required: [true, 'Username is required'],
    unique: true,
    trim: true,
    minlength: [3, 'Username must be at least 3 characters'],
    maxlength: [50, 'Username cannot exceed 50 characters']
  },
  email: {
    type: String,
    required: [true, 'Email is required'],
    unique: true,
    lowercase: true,
    trim: true,
    match: [/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/, 'Please enter a valid email']
  },
  password: {
    type: String,
    required: [true, 'Password is required'],
    minlength: [6, 'Password must be at least 6 characters'],
    select: false // Don't include password in queries by default
  },
  status: {
    type: String,
    enum: ['active', 'inactive', 'suspended'],
    default: 'active'
  }
}, {
  timestamps: true,
  toJSON: { virtuals: true },
  toObject: { virtuals: true }
});

// Indexes for better performance
UserSchema.index({ email: 1 });
UserSchema.index({ username: 1 });
UserSchema.index({ status: 1 });
UserSchema.index({ createdAt: -1 });

// Pre-save middleware to hash password
UserSchema.pre('save', async function(next) {
  if (!this.isModified('password')) return next();
  
  try {
    const salt = await bcrypt.genSalt(12);
    this.password = await bcrypt.hash(this.password, salt);
    next();
  } catch (error) {
    next(error as Error);
  }
});

// Instance method to compare password
UserSchema.methods.comparePassword = async function(candidatePassword: string): Promise<boolean> {
  return bcrypt.compare(candidatePassword, this.password);
};

// Static method to find user by email
UserSchema.statics.findByEmail = function(email: string) {
  return this.findOne({ email, status: 'active' });
};

export const User = mongoose.model<IUser>('User', UserSchema);
```

#### **B. MongoDB Service**

```typescript
// src/services/DatabaseService.ts
import mongoose from 'mongoose';
import { Logger } from '../utils/logger';

export class DatabaseService {
  private static instance: DatabaseService;
  private logger: Logger;

  private constructor() {
    this.logger = new Logger();
  }

  public static getInstance(): DatabaseService {
    if (!DatabaseService.instance) {
      DatabaseService.instance = new DatabaseService();
    }
    return DatabaseService.instance;
  }

  public async initialize(): Promise<void> {
    try {
      const mongoUri = process.env.MONGODB_URI || 'mongodb://localhost:27017/nandi_live';
      
      await mongoose.connect(mongoUri, {
        maxPoolSize: 10,
        serverSelectionTimeoutMS: 5000,
        socketTimeoutMS: 45000,
        bufferCommands: false,
        bufferMaxEntries: 0,
        retryWrites: true,
        w: 'majority'
      });

      // Connection event handlers
      mongoose.connection.on('connected', () => {
        this.logger.info('MongoDB connected successfully');
      });

      mongoose.connection.on('error', (err) => {
        this.logger.error('MongoDB connection error:', err);
      });

      mongoose.connection.on('disconnected', () => {
        this.logger.warn('MongoDB disconnected');
      });

      // Graceful shutdown
      process.on('SIGINT', async () => {
        await this.close();
        process.exit(0);
      });

      this.logger.info('Database connected successfully');
    } catch (error) {
      this.logger.error('Database connection failed:', error);
      throw error;
    }
  }

  public getConnection(): mongoose.Connection {
    return mongoose.connection;
  }

  public async close(): Promise<void> {
    await mongoose.connection.close();
    this.logger.info('Database connection closed');
  }

  // Health check method
  public async healthCheck(): Promise<boolean> {
    try {
      await mongoose.connection.db.admin().ping();
      return true;
    } catch (error) {
      this.logger.error('Database health check failed:', error);
      return false;
    }
  }
}
```

### **5. AUTHENTICATION SYSTEM MIGRATION**

#### **A. JWT Authentication Service**

```typescript
// src/services/AuthService.ts
import jwt from 'jsonwebtoken';
import { User, IUser } from '../models/User';
import { DatabaseService } from './DatabaseService';

export class AuthService {
  private dbService: DatabaseService;

  constructor() {
    this.dbService = DatabaseService.getInstance();
  }

  public async validateLogin(email: string, password: string): Promise<IUser | null> {
    try {
      const user = await User.findByEmail(email).select('+password');
      
      if (!user) {
        return null;
      }

      const isValidPassword = await user.comparePassword(password);
      
      if (!isValidPassword) {
        return null;
      }

      return user;
    } catch (error) {
      console.error('Login validation error:', error);
      throw error;
    }
  }

  public generateToken(user: IUser): string {
    const payload = {
      id: user._id,
      email: user.email,
      username: user.username
    };

    return jwt.sign(payload, process.env.JWT_SECRET || 'your-secret-key', {
      expiresIn: '24h'
    });
  }

  public generateRefreshToken(user: IUser): string {
    const payload = {
      id: user._id,
      type: 'refresh'
    };

    return jwt.sign(payload, process.env.JWT_REFRESH_SECRET || 'your-refresh-secret', {
      expiresIn: '7d'
    });
  }

  public async hashPassword(password: string): Promise<string> {
    const saltRounds = 12;
    return bcrypt.hash(password, saltRounds);
  }

  public verifyToken(token: string): any {
    try {
      return jwt.verify(token, process.env.JWT_SECRET || 'your-secret-key');
    } catch (error) {
      throw new Error('Invalid token');
    }
  }

  public verifyRefreshToken(token: string): any {
    try {
      return jwt.verify(token, process.env.JWT_REFRESH_SECRET || 'your-refresh-secret');
    } catch (error) {
      throw new Error('Invalid refresh token');
    }
  }
}
```

#### **B. Authentication Middleware**

```typescript
// src/middleware/auth.ts
import { Request, Response, NextFunction } from 'express';
import { AuthService } from '../services/AuthService';
import { User } from '../models/User';

export interface AuthenticatedRequest extends Request {
  user?: any;
}

export const authenticateToken = async (
  req: AuthenticatedRequest,
  res: Response,
  next: NextFunction
): Promise<void> => {
  try {
    const authHeader = req.headers.authorization;
    const token = authHeader && authHeader.split(' ')[1];

    if (!token) {
      res.status(401).json({ error: 'Access token required' });
      return;
    }

    const authService = new AuthService();
    const decoded = authService.verifyToken(token);
    
    // Find user in database
    const user = await User.findById(decoded.id).select('-password');
    if (!user) {
      res.status(401).json({ error: 'User not found' });
      return;
    }

    req.user = user;
    next();
  } catch (error) {
    res.status(403).json({ error: 'Invalid token' });
  }
};

export const requireAdmin = async (
  req: AuthenticatedRequest,
  res: Response,
  next: NextFunction
): Promise<void> => {
  try {
    if (!req.user) {
      res.status(401).json({ error: 'Authentication required' });
      return;
    }

    // Check if user is admin (implement based on your admin logic)
    const isAdmin = await checkAdminStatus(req.user._id);
    
    if (!isAdmin) {
      res.status(403).json({ error: 'Admin access required' });
      return;
    }

    next();
  } catch (error) {
    res.status(500).json({ error: 'Authorization error' });
  }
};

async function checkAdminStatus(userId: string): Promise<boolean> {
  // Implement admin check logic
  return true; // Placeholder
}
```

### **6. CONTROLLER MIGRATION**

#### **A. Auth Controller**

```typescript
// src/controllers/auth/AuthController.ts
import { Request, Response } from 'express';
import { AuthService } from '../../services/AuthService';
import { User, IUser } from '../../models/User';
import { validateLoginInput } from '../../utils/validators';

export class AuthController {
  private authService: AuthService;

  constructor() {
    this.authService = new AuthService();
  }

  public async login(req: Request, res: Response): Promise<void> {
    try {
      // Validate input
      const { error } = validateLoginInput(req.body);
      if (error) {
        res.status(400).json({ error: error.details[0].message });
        return;
      }

      const { email, password } = req.body;

      // Validate login
      const user = await this.authService.validateLogin(email, password);
      
      if (!user) {
        res.status(401).json({ error: 'Invalid credentials' });
        return;
      }

      // Generate tokens
      const accessToken = this.authService.generateToken(user);
      const refreshToken = this.authService.generateRefreshToken(user);

      // Update user's refresh token
      await User.findByIdAndUpdate(user._id, { 
        refreshToken: refreshToken 
      });

      res.json({
        success: true,
        message: 'Login successful',
        data: {
          user: {
            id: user._id,
            username: user.username,
            email: user.email,
            status: user.status
          },
          accessToken,
          refreshToken
        }
      });
    } catch (error) {
      console.error('Login error:', error);
      res.status(500).json({ error: 'Internal server error' });
    }
  }

  public async register(req: Request, res: Response): Promise<void> {
    try {
      const { username, email, password } = req.body;

      // Check if user already exists
      const existingUser = await User.findOne({
        $or: [{ email }, { username }]
      });

      if (existingUser) {
        res.status(400).json({ error: 'User already exists' });
        return;
      }

      // Create user
      const newUser = new User({
        username,
        email,
        password
      });

      await newUser.save();

      // Generate tokens
      const accessToken = this.authService.generateToken(newUser);
      const refreshToken = this.authService.generateRefreshToken(newUser);

      res.status(201).json({
        success: true,
        message: 'User registered successfully',
        data: {
          user: {
            id: newUser._id,
            username: newUser.username,
            email: newUser.email,
            status: newUser.status
          },
          accessToken,
          refreshToken
        }
      });
    } catch (error) {
      console.error('Registration error:', error);
      res.status(500).json({ error: 'Internal server error' });
    }
  }

  public async refreshToken(req: Request, res: Response): Promise<void> {
    try {
      const { refreshToken } = req.body;

      if (!refreshToken) {
        res.status(400).json({ error: 'Refresh token required' });
        return;
      }

      const decoded = this.authService.verifyRefreshToken(refreshToken);
      const user = await User.findById(decoded.id);

      if (!user || user.refreshToken !== refreshToken) {
        res.status(401).json({ error: 'Invalid refresh token' });
        return;
      }

      const newAccessToken = this.authService.generateToken(user);
      const newRefreshToken = this.authService.generateRefreshToken(user);

      // Update refresh token
      await User.findByIdAndUpdate(user._id, { 
        refreshToken: newRefreshToken 
      });

      res.json({
        success: true,
        data: {
          accessToken: newAccessToken,
          refreshToken: newRefreshToken
        }
      });
    } catch (error) {
      res.status(401).json({ error: 'Invalid refresh token' });
    }
  }
}
```

### **7. HELPER FUNCTIONS MIGRATION**

#### **A. MongoDB Helper Functions**

```typescript
// src/utils/helpers.ts
import { Model, Document } from 'mongoose';

export class DatabaseHelpers {
  public static async getRecordById<T extends Document>(
    model: Model<T>,
    id: string
  ): Promise<T | null> {
    try {
      const result = await model.findById(id);
      return result;
    } catch (error) {
      console.error('getRecordById error:', error);
      throw error;
    }
  }

  public static async deleteRecord<T extends Document>(
    model: Model<T>,
    id: string
  ): Promise<boolean> {
    try {
      const result = await model.findByIdAndDelete(id);
      return !!result;
    } catch (error) {
      console.error('deleteRecord error:', error);
      throw error;
    }
  }

  public static async updateRecord<T extends Document>(
    model: Model<T>,
    id: string,
    data: Partial<T>
  ): Promise<T | null> {
    try {
      const result = await model.findByIdAndUpdate(
        id,
        data,
        { new: true, runValidators: true }
      );
      return result;
    } catch (error) {
      console.error('updateRecord error:', error);
      throw error;
    }
  }

  public static async insertRecord<T extends Document>(
    model: Model<T>,
    data: Partial<T>
  ): Promise<T> {
    try {
      const entity = new model(data);
      return await entity.save();
    } catch (error) {
      console.error('insertRecord error:', error);
      throw error;
    }
  }

  public static async findWithPagination<T extends Document>(
    model: Model<T>,
    filter: any = {},
    page: number = 1,
    limit: number = 10,
    sort: any = { createdAt: -1 }
  ): Promise<{
    data: T[];
    total: number;
    page: number;
    totalPages: number;
    hasNext: boolean;
    hasPrev: boolean;
  }> {
    try {
      const skip = (page - 1) * limit;
      
      const [data, total] = await Promise.all([
        model.find(filter)
          .sort(sort)
          .skip(skip)
          .limit(limit)
          .lean(),
        model.countDocuments(filter)
      ]);

      const totalPages = Math.ceil(total / limit);
      const hasNext = page < totalPages;
      const hasPrev = page > 1;

      return {
        data,
        total,
        page,
        totalPages,
        hasNext,
        hasPrev
      };
    } catch (error) {
      console.error('findWithPagination error:', error);
      throw error;
    }
  }

  public static async aggregateWithPagination<T extends Document>(
    model: Model<T>,
    pipeline: any[],
    page: number = 1,
    limit: number = 10
  ): Promise<{
    data: any[];
    total: number;
    page: number;
    totalPages: number;
    hasNext: boolean;
    hasPrev: boolean;
  }> {
    try {
      const skip = (page - 1) * limit;
      
      const countPipeline = [
        ...pipeline,
        { $count: 'total' }
      ];

      const dataPipeline = [
        ...pipeline,
        { $skip: skip },
        { $limit: limit }
      ];

      const [countResult, data] = await Promise.all([
        model.aggregate(countPipeline),
        model.aggregate(dataPipeline)
      ]);

      const total = countResult[0]?.total || 0;
      const totalPages = Math.ceil(total / limit);
      const hasNext = page < totalPages;
      const hasPrev = page > 1;

      return {
        data,
        total,
        page,
        totalPages,
        hasNext,
        hasPrev
      };
    } catch (error) {
      console.error('aggregateWithPagination error:', error);
      throw error;
    }
  }
}
```

#### **B. HTTP Client Migration**

```typescript
// src/services/HttpClient.ts
import axios, { AxiosInstance, AxiosRequestConfig, AxiosResponse } from 'axios';

export class HttpClient {
  private client: AxiosInstance;
  private retryCount: number = 0;
  private maxRetries: number = 3;

  constructor(baseURL: string, timeout: number = 30000) {
    this.client = axios.create({
      baseURL,
      timeout,
      headers: {
        'Content-Type': 'application/json',
      },
    });

    this.setupInterceptors();
  }

  private setupInterceptors(): void {
    // Request interceptor
    this.client.interceptors.request.use(
      (config) => {
        // Add authentication token if available
        const token = process.env.API_TOKEN;
        if (token) {
          config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
      },
      (error) => {
        return Promise.reject(error);
      }
    );

    // Response interceptor
    this.client.interceptors.response.use(
      (response) => response,
      async (error) => {
        if (this.retryCount < this.maxRetries && this.shouldRetry(error)) {
          this.retryCount++;
          const delay = Math.pow(2, this.retryCount) * 1000; // Exponential backoff
          await this.sleep(delay);
          return this.client.request(error.config);
        }
        return Promise.reject(error);
      }
    );
  }

  private shouldRetry(error: any): boolean {
    return error.response?.status >= 500 || error.code === 'ECONNRESET';
  }

  private sleep(ms: number): Promise<void> {
    return new Promise(resolve => setTimeout(resolve, ms));
  }

  public async get<T = any>(url: string, config?: AxiosRequestConfig): Promise<T> {
    const response: AxiosResponse<T> = await this.client.get(url, config);
    return response.data;
  }

  public async post<T = any>(url: string, data?: any, config?: AxiosRequestConfig): Promise<T> {
    const response: AxiosResponse<T> = await this.client.post(url, data, config);
    return response.data;
  }

  public async put<T = any>(url: string, data?: any, config?: AxiosRequestConfig): Promise<T> {
    const response: AxiosResponse<T> = await this.client.put(url, data, config);
    return response.data;
  }

  public async delete<T = any>(url: string, config?: AxiosRequestConfig): Promise<T> {
    const response: AxiosResponse<T> = await this.client.delete(url, config);
    return response.data;
  }
}
```

### **8. VALIDATION & SANITIZATION**

```typescript
// src/utils/validators.ts
import Joi from 'joi';

export const validateLoginInput = (data: any) => {
  const schema = Joi.object({
    email: Joi.string().email().required(),
    password: Joi.string().min(6).required(),
  });
  return schema.validate(data);
};

export const validateUserInput = (data: any) => {
  const schema = Joi.object({
    username: Joi.string().min(3).max(50).required(),
    email: Joi.string().email().required(),
    password: Joi.string().min(6).required(),
  });
  return schema.validate(data);
};

export const validateGameInput = (data: any) => {
  const schema = Joi.object({
    name: Joi.string().required(),
    type: Joi.string().required(),
    status: Joi.string().valid('active', 'inactive').default('active'),
  });
  return schema.validate(data);
};

export const sanitizeInput = (input: string): string => {
  return input
    .replace(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi, '')
    .replace(/javascript:/gi, '')
    .replace(/on\w+\s*=/gi, '')
    .trim();
};
```

### **9. MAIN APPLICATION SETUP**

```typescript
// src/app.ts
import express from 'express';
import cors from 'cors';
import helmet from 'helmet';
import rateLimit from 'express-rate-limit';
import { DatabaseService } from './services/DatabaseService';
import { authRoutes } from './routes/auth';
import { userRoutes } from './routes/user';
import { adminRoutes } from './routes/admin';
import { errorHandler } from './middleware/errorHandler';

class App {
  public app: express.Application;
  private dbService: DatabaseService;

  constructor() {
    this.app = express();
    this.dbService = DatabaseService.getInstance();
    this.initializeMiddlewares();
    this.initializeRoutes();
    this.initializeErrorHandling();
  }

  private initializeMiddlewares(): void {
    // Security middleware
    this.app.use(helmet());
    
    // CORS
    this.app.use(cors({
      origin: process.env.ALLOWED_ORIGINS?.split(',') || ['http://localhost:3000'],
      credentials: true
    }));

    // Rate limiting
    const limiter = rateLimit({
      windowMs: 15 * 60 * 1000, // 15 minutes
      max: 100, // limit each IP to 100 requests per windowMs
      message: 'Too many requests from this IP'
    });
    this.app.use('/api/', limiter);

    // Body parsing
    this.app.use(express.json({ limit: '10mb' }));
    this.app.use(express.urlencoded({ extended: true }));

    // Request logging
    this.app.use((req, res, next) => {
      console.log(`${new Date().toISOString()} - ${req.method} ${req.path}`);
      next();
    });
  }

  private initializeRoutes(): void {
    this.app.use('/api/auth', authRoutes);
    this.app.use('/api/user', userRoutes);
    this.app.use('/api/admin', adminRoutes);

    // Health check
    this.app.get('/health', async (req, res) => {
      const dbHealth = await this.dbService.healthCheck();
      res.json({ 
        status: 'OK', 
        timestamp: new Date().toISOString(),
        database: dbHealth ? 'connected' : 'disconnected'
      });
    });
  }

  private initializeErrorHandling(): void {
    this.app.use(errorHandler);
  }

  public async start(): Promise<void> {
    try {
      // Initialize database
      await this.dbService.initialize();

      const port = process.env.PORT || 3000;
      this.app.listen(port, () => {
        console.log(`Server running on port ${port}`);
        console.log(`Environment: ${process.env.NODE_ENV || 'development'}`);
      });
    } catch (error) {
      console.error('Failed to start application:', error);
      process.exit(1);
    }
  }
}

// Start the application
const app = new App();
app.start();
```

### **10. ENVIRONMENT CONFIGURATION**

```env
# .env
NODE_ENV=development
PORT=3000

# MongoDB Configuration
MONGODB_URI=mongodb://localhost:27017/nandi_live
MONGODB_USER=admin
MONGODB_PASSWORD=password
MONGODB_AUTH_SOURCE=admin

# JWT
JWT_SECRET=your-super-secret-jwt-key-here
JWT_REFRESH_SECRET=your-super-secret-refresh-key-here
JWT_EXPIRES_IN=24h
JWT_REFRESH_EXPIRES_IN=7d

# API Configuration
API_TIMEOUT=30000
API_RETRY_ATTEMPTS=3

# Security
ALLOWED_ORIGINS=http://localhost:3000,http://localhost:3001
RATE_LIMIT_WINDOW_MS=900000
RATE_LIMIT_MAX_REQUESTS=100

# Logging
LOG_LEVEL=info
LOG_FILE=logs/app.log
```

---

## **🧪 TESTING STRATEGY**

### **1. Unit Tests**

```typescript
// src/tests/auth.test.ts
import { AuthService } from '../services/AuthService';
import { DatabaseService } from '../services/DatabaseService';
import mongoose from 'mongoose';

describe('AuthService', () => {
  let authService: AuthService;

  beforeAll(async () => {
    await mongoose.connect(process.env.MONGODB_URI_TEST || 'mongodb://localhost:27017/test');
  });

  afterAll(async () => {
    await mongoose.connection.close();
  });

  beforeEach(() => {
    authService = new AuthService();
  });

  describe('validateLogin', () => {
    it('should validate correct credentials', async () => {
      const result = await authService.validateLogin('test@example.com', 'password123');
      expect(result).toBeDefined();
    });

    it('should reject incorrect credentials', async () => {
      const result = await authService.validateLogin('test@example.com', 'wrongpassword');
      expect(result).toBeNull();
    });
  });

  describe('generateToken', () => {
    it('should generate valid JWT token', () => {
      const user = { _id: '123', email: 'test@example.com', username: 'testuser' };
      const token = authService.generateToken(user);
      expect(token).toBeDefined();
      expect(typeof token).toBe('string');
    });
  });
});
```

### **2. Integration Tests**

```typescript
// src/tests/integration/auth.integration.test.ts
import request from 'supertest';
import { app } from '../../app';
import mongoose from 'mongoose';

describe('Auth Integration Tests', () => {
  beforeAll(async () => {
    await mongoose.connect(process.env.MONGODB_URI_TEST || 'mongodb://localhost:27017/test');
  });

  afterAll(async () => {
    await mongoose.connection.close();
  });

  describe('POST /api/auth/login', () => {
    it('should login with valid credentials', async () => {
      const response = await request(app)
        .post('/api/auth/login')
        .send({
          email: 'test@example.com',
          password: 'password123'
        });

      expect(response.status).toBe(200);
      expect(response.body.success).toBe(true);
      expect(response.body.data.accessToken).toBeDefined();
    });

    it('should reject invalid credentials', async () => {
      const response = await request(app)
        .post('/api/auth/login')
        .send({
          email: 'test@example.com',
          password: 'wrongpassword'
        });

      expect(response.status).toBe(401);
      expect(response.body.error).toBeDefined();
    });
  });
});
```

---

## **📊 PERFORMANCE OPTIMIZATION**

### **1. MongoDB Optimization**

```typescript
// Connection pooling and query optimization
const mongoConfig = {
  maxPoolSize: 20,
  serverSelectionTimeoutMS: 5000,
  socketTimeoutMS: 45000,
  bufferCommands: false,
  bufferMaxEntries: 0,
  retryWrites: true,
  w: 'majority'
};
```

### **2. Caching Strategy**

```typescript
// Redis caching implementation
import Redis from 'ioredis';

export class CacheService {
  private redis: Redis;

  constructor() {
    this.redis = new Redis({
      host: process.env.REDIS_HOST || 'localhost',
      port: parseInt(process.env.REDIS_PORT || '6379'),
      password: process.env.REDIS_PASSWORD,
    });
  }

  public async get<T>(key: string): Promise<T | null> {
    const value = await this.redis.get(key);
    return value ? JSON.parse(value) : null;
  }

  public async set(key: string, value: any, ttl: number = 3600): Promise<void> {
    await this.redis.setex(key, ttl, JSON.stringify(value));
  }

  public async del(key: string): Promise<void> {
    await this.redis.del(key);
  }
}
```

---

## **🚀 DEPLOYMENT STRATEGY**

### **1. Docker Configuration**

```dockerfile
# Dockerfile
FROM node:18-alpine

WORKDIR /app

COPY package*.json ./
RUN npm ci --only=production

COPY . .
RUN npm run build

EXPOSE 3000

CMD ["npm", "start"]
```

### **2. Docker Compose**

```yaml
# docker-compose.yml
version: '3.8'

services:
  app:
    build: .
    ports:
      - "3000:3000"
    environment:
      - NODE_ENV=production
      - MONGODB_URI=mongodb://mongo:27017/nandi_live
    depends_on:
      - mongo
      - redis

  mongo:
    image: mongo:7.0
    environment:
      MONGO_INITDB_ROOT_USERNAME: admin
      MONGO_INITDB_ROOT_PASSWORD: password
      MONGO_INITDB_DATABASE: nandi_live
    ports:
      - "27017:27017"
    volumes:
      - mongo_data:/data/db

  redis:
    image: redis:7-alpine
    ports:
      - "6379:6379"

volumes:
  mongo_data:
```

---

## **📋 MIGRATION CHECKLIST**

### **Phase 1: Setup ✅**
- [ ] Initialize Node.js project
- [ ] Configure TypeScript
- [ ] Set up development environment
- [ ] Install dependencies
- [ ] Configure ESLint and Prettier

### **Phase 2: Database ✅**
- [ ] Set up MongoDB and Mongoose
- [ ] Create schema models
- [ ] Configure database connection
- [ ] Test database connectivity
- [ ] Create migration scripts

### **Phase 3: Authentication ✅**
- [ ] Implement JWT authentication
- [ ] Create login/register endpoints
- [ ] Set up middleware
- [ ] Test authentication flow
- [ ] Implement password hashing

### **Phase 4: API Migration ✅**
- [ ] Migrate controllers
- [ ] Implement validation
- [ ] Set up error handling
- [ ] Create API routes
- [ ] Test API endpoints

### **Phase 5: Business Logic ✅**
- [ ] Migrate helper functions
- [ ] Implement services
- [ ] Set up HTTP client
- [ ] Create utilities
- [ ] Test business logic

### **Phase 6: Security ✅**
- [ ] Implement security middleware
- [ ] Set up rate limiting
- [ ] Configure CORS
- [ ] Add input validation
- [ ] Test security measures

### **Phase 7: Testing ✅**
- [ ] Write unit tests
- [ ] Create integration tests
- [ ] Set up test database
- [ ] Run performance tests
- [ ] Validate functionality

### **Phase 8: Deployment ✅**
- [ ] Configure production environment
- [ ] Set up Docker
- [ ] Create deployment scripts
- [ ] Configure monitoring
- [ ] Deploy to production

---

## **🎯 NEXT STEPS**

1. **Start with Phase 1**: Set up the basic Node.js TypeScript environment
2. **Database Migration**: Create Mongoose schemas for your existing data
3. **Authentication System**: Implement JWT-based authentication
4. **API Controllers**: Migrate your PHP controllers to TypeScript
5. **Testing**: Write comprehensive tests for all functionality
6. **Performance Testing**: Ensure the new system meets performance requirements
7. **Deployment**: Deploy to production with proper monitoring

Would you like me to help you start with any specific phase of this migration? I can provide detailed implementation for any particular component you'd like to tackle first.
