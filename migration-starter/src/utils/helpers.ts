import { Model, Document } from 'mongoose';

// Generic database helper functions
export const getRecordById = async <T extends Document>(
  model: Model<T>,
  id: string,
  select?: string
): Promise<T | null> => {
  try {
    const query = model.findById(id);
    if (select) {
      query.select(select);
    }
    return await query.exec();
  } catch (error) {
    console.error('Error getting record by ID:', error);
    return null;
  }
};

export const deleteRecord = async <T extends Document>(
  model: Model<T>,
  id: string
): Promise<T | null> => {
  try {
    return await model.findByIdAndDelete(id);
  } catch (error) {
    console.error('Error deleting record:', error);
    return null;
  }
};

export const updateRecord = async <T extends Document>(
  model: Model<T>,
  id: string,
  updateData: any,
  select?: string
): Promise<T | null> => {
  try {
    const query = model.findByIdAndUpdate(id, updateData, { new: true });
    if (select) {
      query.select(select);
    }
    return await query.exec();
  } catch (error) {
    console.error('Error updating record:', error);
    return null;
  }
};

export const insertRecord = async <T extends Document>(
  model: Model<T>,
  data: any
): Promise<T> => {
  const record = new model(data);
  return await record.save();
};

// Pagination helper
export interface PaginationOptions {
  filter?: any;
  page?: number;
  limit?: number;
  sort?: any;
  select?: string;
}

export interface PaginationResult<T> {
  data: T[];
  pagination: {
    page: number;
    limit: number;
    total: number;
    totalPages: number;
    hasNext: boolean;
    hasPrev: boolean;
  };
}

export const findWithPagination = async <T extends Document>(
  model: Model<T>,
  options: PaginationOptions = {}
): Promise<PaginationResult<T>> => {
  const {
    filter = {},
    page = 1,
    limit = 10,
    sort = { createdAt: -1 },
    select
  } = options;

  try {
    // Calculate skip value
    const skip = (page - 1) * limit;

    // Build query
    let query = model.find(filter);
    
    if (select) {
      query = query.select(select);
    }

    // Execute queries
    const [data, total] = await Promise.all([
      query.sort(sort).skip(skip).limit(limit).exec(),
      model.countDocuments(filter)
    ]);

    // Calculate pagination info
    const totalPages = Math.ceil(total / limit);
    const hasNext = page < totalPages;
    const hasPrev = page > 1;

    return {
      data,
      pagination: {
        page,
        limit,
        total,
        totalPages,
        hasNext,
        hasPrev
      }
    };
  } catch (error) {
    console.error('Error in pagination:', error);
    throw error;
  }
};

// MongoDB aggregation with pagination
export interface AggregationOptions {
  pipeline: any[];
  page?: number;
  limit?: number;
}

export const aggregateWithPagination = async <T>(
  model: Model<any>,
  options: AggregationOptions
): Promise<PaginationResult<T>> => {
  const { pipeline, page = 1, limit = 10 } = options;

  try {
    // Add pagination to pipeline
    const skip = (page - 1) * limit;
    const paginatedPipeline = [
      ...pipeline,
      { $skip: skip },
      { $limit: limit }
    ];

    // Get total count
    const countPipeline = [
      ...pipeline,
      { $count: 'total' }
    ];

    // Execute queries
    const [data, countResult] = await Promise.all([
      model.aggregate(paginatedPipeline),
      model.aggregate(countPipeline)
    ]);

    const total = countResult.length > 0 ? countResult[0].total : 0;
    const totalPages = Math.ceil(total / limit);
    const hasNext = page < totalPages;
    const hasPrev = page > 1;

    return {
      data,
      pagination: {
        page,
        limit,
        total,
        totalPages,
        hasNext,
        hasPrev
      }
    };
  } catch (error) {
    console.error('Error in aggregation pagination:', error);
    throw error;
  }
};

// Search helper
export const searchRecords = async <T extends Document>(
  model: Model<T>,
  searchTerm: string,
  searchFields: string[],
  options: {
    limit?: number;
    sort?: any;
    select?: string;
    additionalFilter?: any;
  } = {}
): Promise<T[]> => {
  const { limit = 10, sort = { createdAt: -1 }, select, additionalFilter = {} } = options;

  try {
    // Build search query
    const searchQuery = {
      $or: searchFields.map(field => ({
        [field]: { $regex: searchTerm, $options: 'i' }
      })),
      ...additionalFilter
    };

    let query = model.find(searchQuery);
    
    if (select) {
      query = query.select(select);
    }

    return await query.sort(sort).limit(limit).exec();
  } catch (error) {
    console.error('Error in search:', error);
    throw error;
  }
};

// Bulk operations helper
export const bulkInsert = async <T extends Document>(
  model: Model<T>,
  documents: any[]
): Promise<T[]> => {
  try {
    return await model.insertMany(documents);
  } catch (error) {
    console.error('Error in bulk insert:', error);
    throw error;
  }
};

export const bulkUpdate = async <T extends Document>(
  model: Model<T>,
  filter: any,
  update: any
): Promise<any> => {
  try {
    return await model.updateMany(filter, update);
  } catch (error) {
    console.error('Error in bulk update:', error);
    throw error;
  }
};

export const bulkDelete = async <T extends Document>(
  model: Model<T>,
  filter: any
): Promise<any> => {
  try {
    return await model.deleteMany(filter);
  } catch (error) {
    console.error('Error in bulk delete:', error);
    throw error;
  }
};

// Utility functions
export const generateRandomString = (length: number = 8): string => {
  const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  let result = '';
  for (let i = 0; i < length; i++) {
    result += chars.charAt(Math.floor(Math.random() * chars.length));
  }
  return result;
};

export const generateSlug = (text: string): string => {
  return text
    .toLowerCase()
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/(^-|-$)/g, '');
};

export const formatDate = (date: Date): string => {
  return date.toISOString();
};

export const isValidObjectId = (id: string): boolean => {
  return /^[0-9a-fA-F]{24}$/.test(id);
};

// Error handling helper
export const handleDatabaseError = (error: any): { success: false; message: string } => {
  console.error('Database error:', error);
  
  if (error.code === 11000) {
    // Duplicate key error
    const field = Object.keys(error.keyPattern)[0];
    return {
      success: false,
      message: `${field} already exists`
    };
  }
  
  if (error.name === 'ValidationError') {
    // Validation error
    const errors = Object.values(error.errors).map((err: any) => err.message);
    return {
      success: false,
      message: errors.join(', ')
    };
  }
  
  return {
    success: false,
    message: 'Database operation failed'
  };
};

// Cache helper (simple in-memory cache)
class SimpleCache {
  private cache = new Map<string, { data: any; expiry: number }>();

  set(key: string, data: any, ttl: number = 300000): void { // Default 5 minutes
    const expiry = Date.now() + ttl;
    this.cache.set(key, { data, expiry });
  }

  get(key: string): any | null {
    const item = this.cache.get(key);
    if (!item) return null;
    
    if (Date.now() > item.expiry) {
      this.cache.delete(key);
      return null;
    }
    
    return item.data;
  }

  delete(key: string): void {
    this.cache.delete(key);
  }

  clear(): void {
    this.cache.clear();
  }
}

export const cache = new SimpleCache();

