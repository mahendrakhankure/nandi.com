#!/usr/bin/env ts-node

/**
 * MySQL to MongoDB Migration Script
 * This script helps migrate your existing MySQL data to MongoDB
 */

import mysql from 'mysql2/promise';
import mongoose from 'mongoose';
import dotenv from 'dotenv';
import { User } from '../models/User';
import { Admin } from '../models/Admin';
import { Game } from '../models/Game';

// Load environment variables
dotenv.config();

interface MigrationConfig {
  mysql: {
    host: string;
    port: number;
    user: string;
    password: string;
    database: string;
  };
  mongodb: {
    uri: string;
  };
}

class MySQLToMongoDBMigration {
  private mysqlConnection: mysql.Connection | null = null;
  private migrationConfig: MigrationConfig;

  constructor() {
    this.migrationConfig = {
      mysql: {
        host: process.env.MYSQL_HOST || 'localhost',
        port: parseInt(process.env.MYSQL_PORT || '3306'),
        user: process.env.MYSQL_USER || 'root',
        password: process.env.MYSQL_PASSWORD || '',
        database: process.env.MYSQL_DATABASE || 'nandi_live'
      },
      mongodb: {
        uri: process.env.MONGODB_URI || 'mongodb://localhost:27017/nandi_live'
      }
    };
  }

  async initialize(): Promise<void> {
    try {
      console.log('🔌 Connecting to MySQL...');
      this.mysqlConnection = await mysql.createConnection(this.migrationConfig.mysql);
      console.log('✅ MySQL connected successfully');

      console.log('🔌 Connecting to MongoDB...');
      await mongoose.connect(this.migrationConfig.mongodb.uri);
      console.log('✅ MongoDB connected successfully');

    } catch (error) {
      console.error('❌ Connection failed:', error);
      throw error;
    }
  }

  async migrateUsers(): Promise<void> {
    try {
      console.log('📦 Migrating users...');
      
      const [rows] = await this.mysqlConnection!.execute('SELECT * FROM users');
      const users = rows as any[];

      for (const user of users) {
        // Check if user already exists in MongoDB
        const existingUser = await User.findOne({ email: user.email });
        
        if (!existingUser) {
          const newUser = new User({
            username: user.username,
            email: user.email,
            password: user.password, // Will be hashed by Mongoose middleware
            status: user.status || 'active',
            createdAt: user.created_at,
            updatedAt: user.updated_at
          });

          await newUser.save();
          console.log(`✅ Migrated user: ${user.email}`);
        } else {
          console.log(`⏭️  User already exists: ${user.email}`);
        }
      }

      console.log(`✅ Users migration completed. Total: ${users.length}`);
    } catch (error) {
      console.error('❌ Users migration failed:', error);
      throw error;
    }
  }

  async migrateAdmins(): Promise<void> {
    try {
      console.log('📦 Migrating admins...');
      
      const [rows] = await this.mysqlConnection!.execute('SELECT * FROM admin');
      const admins = rows as any[];

      for (const admin of admins) {
        // Check if admin already exists in MongoDB
        const existingAdmin = await Admin.findOne({ email: admin.email });
        
        if (!existingAdmin) {
          const newAdmin = new Admin({
            username: admin.username || admin.email,
            email: admin.email,
            password: admin.password, // Will be hashed by Mongoose middleware
            role: admin.role || 'admin',
            status: admin.status || 'active',
            createdAt: admin.created_at,
            updatedAt: admin.updated_at
          });

          await newAdmin.save();
          console.log(`✅ Migrated admin: ${admin.email}`);
        } else {
          console.log(`⏭️  Admin already exists: ${admin.email}`);
        }
      }

      console.log(`✅ Admins migration completed. Total: ${admins.length}`);
    } catch (error) {
      console.error('❌ Admins migration failed:', error);
      throw error;
    }
  }

  async migrateGames(): Promise<void> {
    try {
      console.log('📦 Migrating games...');
      
      // Adjust table name based on your actual table structure
      const [rows] = await this.mysqlConnection!.execute('SELECT * FROM games');
      const games = rows as any[];

      for (const game of games) {
        // Check if game already exists in MongoDB
        const existingGame = await Game.findOne({ name: game.name });
        
        if (!existingGame) {
          const newGame = new Game({
            name: game.name,
            type: game.type,
            status: game.status || 'active',
            description: game.description,
            rules: game.rules,
            createdAt: game.created_at,
            updatedAt: game.updated_at
          });

          await newGame.save();
          console.log(`✅ Migrated game: ${game.name}`);
        } else {
          console.log(`⏭️  Game already exists: ${game.name}`);
        }
      }

      console.log(`✅ Games migration completed. Total: ${games.length}`);
    } catch (error) {
      console.error('❌ Games migration failed:', error);
      throw error;
    }
  }

  async migrateCustomTables(): Promise<void> {
    try {
      console.log('📦 Migrating custom tables...');
      
      // Get all tables from MySQL
      const [tables] = await this.mysqlConnection!.execute(`
        SELECT TABLE_NAME 
        FROM INFORMATION_SCHEMA.TABLES 
        WHERE TABLE_SCHEMA = '${this.migrationConfig.mysql.database}'
        AND TABLE_NAME NOT IN ('users', 'admin', 'games', 'migrations')
      `);

      for (const table of tables as any[]) {
        const tableName = table.TABLE_NAME;
        console.log(`📋 Migrating table: ${tableName}`);
        
        try {
          const [rows] = await this.mysqlConnection!.execute(`SELECT * FROM ${tableName}`);
          const data = rows as any[];

          // Create a generic collection for custom tables
          const collection = mongoose.connection.collection(tableName);
          
          for (const row of data) {
            // Convert MySQL row to MongoDB document
            const document = this.convertMySQLRowToMongoDB(row);
            
            // Check if document already exists
            const existingDoc = await collection.findOne({ 
              _id: document._id || document.id 
            });
            
            if (!existingDoc) {
              await collection.insertOne(document);
              console.log(`✅ Migrated ${tableName} record: ${document._id || document.id}`);
            } else {
              console.log(`⏭️  ${tableName} record already exists: ${document._id || document.id}`);
            }
          }

          console.log(`✅ Table ${tableName} migration completed. Total: ${data.length}`);
        } catch (error) {
          console.error(`❌ Failed to migrate table ${tableName}:`, error);
        }
      }
    } catch (error) {
      console.error('❌ Custom tables migration failed:', error);
      throw error;
    }
  }

  private convertMySQLRowToMongoDB(row: any): any {
    const document: any = {};
    
    for (const [key, value] of Object.entries(row)) {
      // Convert MySQL field names to MongoDB format
      const mongoKey = key.replace(/_([a-z])/g, (_, letter) => letter.toUpperCase());
      
      // Handle different data types
      if (value instanceof Date) {
        document[mongoKey] = value;
      } else if (typeof value === 'string' && value.match(/^\d{4}-\d{2}-\d{2}/)) {
        // Convert date strings to Date objects
        document[mongoKey] = new Date(value);
      } else if (typeof value === 'string' && value.match(/^\d+$/)) {
        // Convert numeric strings to numbers
        document[mongoKey] = parseInt(value);
      } else if (typeof value === 'string' && value.match(/^\d+\.\d+$/)) {
        // Convert float strings to numbers
        document[mongoKey] = parseFloat(value);
      } else {
        document[mongoKey] = value;
      }
    }

    // Add MongoDB _id if not present
    if (!document._id && document.id) {
      document._id = document.id;
      delete document.id;
    }

    return document;
  }

  async createIndexes(): Promise<void> {
    try {
      console.log('🔍 Creating database indexes...');
      
      // Create indexes for better performance
      await User.collection.createIndex({ email: 1 }, { unique: true });
      await User.collection.createIndex({ username: 1 }, { unique: true });
      await User.collection.createIndex({ status: 1 });
      await User.collection.createIndex({ createdAt: -1 });

      await Admin.collection.createIndex({ email: 1 }, { unique: true });
      await Admin.collection.createIndex({ role: 1 });
      await Admin.collection.createIndex({ status: 1 });

      await Game.collection.createIndex({ name: 1 }, { unique: true });
      await Game.collection.createIndex({ type: 1 });
      await Game.collection.createIndex({ status: 1 });

      console.log('✅ Database indexes created successfully');
    } catch (error) {
      console.error('❌ Failed to create indexes:', error);
      throw error;
    }
  }

  async generateMigrationReport(): Promise<void> {
    try {
      console.log('📊 Generating migration report...');
      
      const userCount = await User.countDocuments();
      const adminCount = await Admin.countDocuments();
      const gameCount = await Game.countDocuments();

      const report = {
        timestamp: new Date().toISOString(),
        migration: {
          users: userCount,
          admins: adminCount,
          games: gameCount,
          total: userCount + adminCount + gameCount
        },
        database: {
          mysql: this.migrationConfig.mysql.database,
          mongodb: mongoose.connection.db.databaseName
        }
      };

      console.log('📋 Migration Report:');
      console.log(JSON.stringify(report, null, 2));

      // Save report to file
      const fs = require('fs');
      const path = require('path');
      const reportPath = path.join(__dirname, '../../migration-report.json');
      fs.writeFileSync(reportPath, JSON.stringify(report, null, 2));
      console.log(`📄 Migration report saved to: ${reportPath}`);
    } catch (error) {
      console.error('❌ Failed to generate migration report:', error);
    }
  }

  async cleanup(): Promise<void> {
    try {
      if (this.mysqlConnection) {
        await this.mysqlConnection.end();
        console.log('🔌 MySQL connection closed');
      }

      await mongoose.connection.close();
      console.log('🔌 MongoDB connection closed');
    } catch (error) {
      console.error('❌ Cleanup failed:', error);
    }
  }

  async run(): Promise<void> {
    try {
      console.log('🚀 Starting MySQL to MongoDB migration...');
      console.log('=' .repeat(50));

      await this.initialize();
      
      // Run migrations
      await this.migrateUsers();
      await this.migrateAdmins();
      await this.migrateGames();
      await this.migrateCustomTables();
      
      // Create indexes for performance
      await this.createIndexes();
      
      // Generate migration report
      await this.generateMigrationReport();

      console.log('=' .repeat(50));
      console.log('✅ Migration completed successfully!');
      
    } catch (error) {
      console.error('❌ Migration failed:', error);
      throw error;
    } finally {
      await this.cleanup();
    }
  }
}

// Run migration if this script is executed directly
if (require.main === module) {
  const migration = new MySQLToMongoDBMigration();
  
  migration.run()
    .then(() => {
      console.log('🎉 Migration completed successfully!');
      process.exit(0);
    })
    .catch((error) => {
      console.error('💥 Migration failed:', error);
      process.exit(1);
    });
}

export default MySQLToMongoDBMigration;

