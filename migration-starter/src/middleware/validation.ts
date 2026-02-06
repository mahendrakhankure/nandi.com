import { Request, Response, NextFunction } from 'express';

// Validation result interface
export interface ValidationResult {
  isValid: boolean;
  errors: string[];
}

// Email validation regex
const EMAIL_REGEX = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

// Password validation regex (minimum 8 characters, at least one uppercase, one lowercase, one number)
const PASSWORD_REGEX = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d@$!%*?&]{8,}$/;

// Username validation regex (3-20 characters, alphanumeric and underscore only)
const USERNAME_REGEX = /^[a-zA-Z0-9_]{3,20}$/;

// Validation functions
export const validateLoginInput = (data: any): ValidationResult => {
  const errors: string[] = [];

  if (!data.email || typeof data.email !== 'string') {
    errors.push('Email is required and must be a string');
  } else if (!EMAIL_REGEX.test(data.email)) {
    errors.push('Email format is invalid');
  }

  if (!data.password || typeof data.password !== 'string') {
    errors.push('Password is required and must be a string');
  } else if (data.password.length < 6) {
    errors.push('Password must be at least 6 characters long');
  }

  if (data.userType && !['user', 'admin'].includes(data.userType)) {
    errors.push('User type must be either "user" or "admin"');
  }

  return {
    isValid: errors.length === 0,
    errors
  };
};

export const validateRegisterInput = (data: any): ValidationResult => {
  const errors: string[] = [];

  if (!data.username || typeof data.username !== 'string') {
    errors.push('Username is required and must be a string');
  } else if (!USERNAME_REGEX.test(data.username)) {
    errors.push('Username must be 3-20 characters long and contain only letters, numbers, and underscores');
  }

  if (!data.email || typeof data.email !== 'string') {
    errors.push('Email is required and must be a string');
  } else if (!EMAIL_REGEX.test(data.email)) {
    errors.push('Email format is invalid');
  }

  if (!data.password || typeof data.password !== 'string') {
    errors.push('Password is required and must be a string');
  } else if (data.password.length < 6) {
    errors.push('Password must be at least 6 characters long');
  } else if (!PASSWORD_REGEX.test(data.password)) {
    errors.push('Password must contain at least one uppercase letter, one lowercase letter, and one number');
  }

  if (data.userType && !['user', 'admin'].includes(data.userType)) {
    errors.push('User type must be either "user" or "admin"');
  }

  return {
    isValid: errors.length === 0,
    errors
  };
};

export const validateGameInput = (data: any): ValidationResult => {
  const errors: string[] = [];

  if (!data.name || typeof data.name !== 'string') {
    errors.push('Game name is required and must be a string');
  } else if (data.name.length < 2 || data.name.length > 100) {
    errors.push('Game name must be between 2 and 100 characters long');
  }

  if (!data.type || typeof data.type !== 'string') {
    errors.push('Game type is required and must be a string');
  } else if (!['card', 'board', 'digital', 'puzzle', 'action', 'strategy', 'other'].includes(data.type)) {
    errors.push('Game type must be one of: card, board, digital, puzzle, action, strategy, other');
  }

  if (data.description && typeof data.description !== 'string') {
    errors.push('Description must be a string');
  } else if (data.description && data.description.length > 500) {
    errors.push('Description cannot exceed 500 characters');
  }

  if (data.rules && typeof data.rules !== 'string') {
    errors.push('Rules must be a string');
  } else if (data.rules && data.rules.length > 2000) {
    errors.push('Rules cannot exceed 2000 characters');
  }

  if (data.status && !['active', 'inactive', 'maintenance'].includes(data.status)) {
    errors.push('Status must be one of: active, inactive, maintenance');
  }

  return {
    isValid: errors.length === 0,
    errors
  };
};

export const validateUserUpdateInput = (data: any): ValidationResult => {
  const errors: string[] = [];

  if (data.username && typeof data.username !== 'string') {
    errors.push('Username must be a string');
  } else if (data.username && !USERNAME_REGEX.test(data.username)) {
    errors.push('Username must be 3-20 characters long and contain only letters, numbers, and underscores');
  }

  if (data.status && !['active', 'inactive', 'suspended'].includes(data.status)) {
    errors.push('Status must be one of: active, inactive, suspended');
  }

  return {
    isValid: errors.length === 0,
    errors
  };
};

// Pagination validation
export const validatePaginationParams = (data: any): ValidationResult => {
  const errors: string[] = [];

  if (data.page && (isNaN(Number(data.page)) || Number(data.page) < 1)) {
    errors.push('Page must be a positive number');
  }

  if (data.limit && (isNaN(Number(data.limit)) || Number(data.limit) < 1 || Number(data.limit) > 100)) {
    errors.push('Limit must be a number between 1 and 100');
  }

  if (data.sortOrder && !['asc', 'desc'].includes(data.sortOrder)) {
    errors.push('Sort order must be either "asc" or "desc"');
  }

  return {
    isValid: errors.length === 0,
    errors
  };
};

// Search validation
export const validateSearchParams = (data: any): ValidationResult => {
  const errors: string[] = [];

  if (!data.q || typeof data.q !== 'string') {
    errors.push('Search query is required and must be a string');
  } else if (data.q.length < 2) {
    errors.push('Search query must be at least 2 characters long');
  }

  if (data.limit && (isNaN(Number(data.limit)) || Number(data.limit) < 1 || Number(data.limit) > 50)) {
    errors.push('Limit must be a number between 1 and 50');
  }

  return {
    isValid: errors.length === 0,
    errors
  };
};

// Middleware functions
export const validateLogin = (req: Request, res: Response, next: NextFunction): void => {
  const validation = validateLoginInput(req.body);
  
  if (!validation.isValid) {
    res.status(400).json({
      success: false,
      message: 'Validation failed',
      errors: validation.errors
    });
    return;
  }

  next();
};

export const validateRegister = (req: Request, res: Response, next: NextFunction): void => {
  const validation = validateRegisterInput(req.body);
  
  if (!validation.isValid) {
    res.status(400).json({
      success: false,
      message: 'Validation failed',
      errors: validation.errors
    });
    return;
  }

  next();
};

export const validateGame = (req: Request, res: Response, next: NextFunction): void => {
  const validation = validateGameInput(req.body);
  
  if (!validation.isValid) {
    res.status(400).json({
      success: false,
      message: 'Validation failed',
      errors: validation.errors
    });
    return;
  }

  next();
};

export const validateUserUpdate = (req: Request, res: Response, next: NextFunction): void => {
  const validation = validateUserUpdateInput(req.body);
  
  if (!validation.isValid) {
    res.status(400).json({
      success: false,
      message: 'Validation failed',
      errors: validation.errors
    });
    return;
  }

  next();
};

export const validatePagination = (req: Request, res: Response, next: NextFunction): void => {
  const validation = validatePaginationParams(req.query);
  
  if (!validation.isValid) {
    res.status(400).json({
      success: false,
      message: 'Validation failed',
      errors: validation.errors
    });
    return;
  }

  next();
};

export const validateSearch = (req: Request, res: Response, next: NextFunction): void => {
  const validation = validateSearchParams(req.query);
  
  if (!validation.isValid) {
    res.status(400).json({
      success: false,
      message: 'Validation failed',
      errors: validation.errors
    });
    return;
  }

  next();
};

// Sanitization functions
export const sanitizeInput = (input: string): string => {
  return input
    .trim()
    .replace(/[<>]/g, '') // Remove potential HTML tags
    .replace(/[&]/g, '&amp;') // Escape ampersands
    .replace(/["]/g, '&quot;') // Escape quotes
    .replace(/[']/g, '&#x27;'); // Escape apostrophes
};

export const sanitizeObject = (obj: any): any => {
  const sanitized: any = {};
  
  for (const [key, value] of Object.entries(obj)) {
    if (typeof value === 'string') {
      sanitized[key] = sanitizeInput(value);
    } else {
      sanitized[key] = value;
    }
  }
  
  return sanitized;
};

// Sanitization middleware
export const sanitizeBody = (req: Request, res: Response, next: NextFunction): void => {
  if (req.body) {
    req.body = sanitizeObject(req.body);
  }
  next();
};

export const sanitizeQuery = (req: Request, res: Response, next: NextFunction): void => {
  if (req.query) {
    req.query = sanitizeObject(req.query);
  }
  next();
};

