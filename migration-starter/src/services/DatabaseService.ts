import mongoose from 'mongoose';

class DatabaseService {
  private static instance: DatabaseService;
  private isConnected: boolean = false;

  private constructor() {}

  public static getInstance(): DatabaseService {
    if (!DatabaseService.instance) {
      DatabaseService.instance = new DatabaseService();
    }
    return DatabaseService.instance;
  }

  public async connect(): Promise<void> {
    try {
      if (this.isConnected) {
        console.log('Database already connected');
        return;
      }

      const mongoUri = process.env.MONGODB_URI || 'mongodb://localhost:27017/nandi_live';
      
      await mongoose.connect(mongoUri, {
        maxPoolSize: parseInt(process.env.MONGODB_MAX_POOL_SIZE || '10'),
        serverSelectionTimeoutMS: parseInt(process.env.MONGODB_SERVER_SELECTION_TIMEOUT || '5000'),
        socketTimeoutMS: parseInt(process.env.MONGODB_SOCKET_TIMEOUT || '45000'),
        bufferCommands: false,
        bufferMaxEntries: 0,
      });

      this.isConnected = true;
      console.log('✅ MongoDB connected successfully');

      // Handle connection events
      mongoose.connection.on('error', (error) => {
        console.error('MongoDB connection error:', error);
        this.isConnected = false;
      });

      mongoose.connection.on('disconnected', () => {
        console.log('MongoDB disconnected');
        this.isConnected = false;
      });

      mongoose.connection.on('reconnected', () => {
        console.log('MongoDB reconnected');
        this.isConnected = true;
      });

    } catch (error) {
      console.error('❌ MongoDB connection failed:', error);
      this.isConnected = false;
      throw error;
    }
  }

  public async disconnect(): Promise<void> {
    try {
      if (this.isConnected) {
        await mongoose.connection.close();
        this.isConnected = false;
        console.log('🔌 MongoDB connection closed');
      }
    } catch (error) {
      console.error('Error closing MongoDB connection:', error);
      throw error;
    }
  }

  public async healthCheck(): Promise<boolean> {
    try {
      if (!this.isConnected) {
        return false;
      }

      // Ping the database
      await mongoose.connection.db.admin().ping();
      return true;
    } catch (error) {
      console.error('Database health check failed:', error);
      return false;
    }
  }

  public getConnectionStatus(): boolean {
    return this.isConnected;
  }

  public getConnectionInfo(): any {
    if (!this.isConnected) {
      return { status: 'disconnected' };
    }

    return {
      status: 'connected',
      host: mongoose.connection.host,
      port: mongoose.connection.port,
      name: mongoose.connection.name,
      readyState: mongoose.connection.readyState
    };
  }
}

// Export singleton instance
export default DatabaseService.getInstance();

