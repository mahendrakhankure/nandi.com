#!/usr/bin/env node

/**
 * MySQL to MongoDB Migration Script
 * Standalone version that works without MongoDB service
 */

const mysql = require('mysql2/promise');
const fs = require('fs');
const path = require('path');

// Configuration
const config = {
  mysql: {
    host: 'localhost',
    port: 3306,
    user: 'root',
    password: '',
    database: 'nandi_test'
  },
  output: {
    directory: './migrated-data',
    format: 'json'
  }
};

class MySQLToMongoDBMigration {
  constructor() {
    this.mysqlConnection = null;
    this.migrationData = {};
  }

  async initialize() {
    try {
      console.log('🔌 Connecting to MySQL...');
      this.mysqlConnection = await mysql.createConnection(config.mysql);
      console.log('✅ MySQL connected successfully');

      // Create output directory
      if (!fs.existsSync(config.output.directory)) {
        fs.mkdirSync(config.output.directory, { recursive: true });
      }

    } catch (error) {
      console.error('❌ Connection failed:', error);
      throw error;
    }
  }

  async migrateTable(tableName) {
    try {
      console.log(`📦 Migrating table: ${tableName}`);
      
      const [rows] = await this.mysqlConnection.execute(`SELECT * FROM ${tableName}`);
      const data = rows;

      // Convert MySQL data to MongoDB format
      const mongoData = data.map(row => this.convertMySQLRowToMongoDB(row, tableName));

      // Save to file
      const outputFile = path.join(config.output.directory, `${tableName}.json`);
      fs.writeFileSync(outputFile, JSON.stringify(mongoData, null, 2));

      console.log(`✅ Table ${tableName} migrated. Records: ${data.length}`);
      console.log(`📄 Saved to: ${outputFile}`);

      return {
        table: tableName,
        records: data.length,
        file: outputFile
      };

    } catch (error) {
      console.error(`❌ Failed to migrate table ${tableName}:`, error.message);
      return {
        table: tableName,
        records: 0,
        error: error.message
      };
    }
  }

  convertMySQLRowToMongoDB(row, tableName) {
    const document = {
      _id: null,
      tableName: tableName,
      migratedAt: new Date().toISOString()
    };
    
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

    // Set MongoDB _id
    if (document.id) {
      document._id = document.id;
      delete document.id;
    } else {
      document._id = `${tableName}_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`;
    }

    return document;
  }

  async getAllTables() {
    try {
      const [tables] = await this.mysqlConnection.execute(`
        SELECT TABLE_NAME 
        FROM INFORMATION_SCHEMA.TABLES 
        WHERE TABLE_SCHEMA = '${config.mysql.database}'
      `);
      return tables.map(table => table.TABLE_NAME);
    } catch (error) {
      console.error('❌ Failed to get tables:', error);
      return [];
    }
  }

  async generateMigrationScript() {
    const scriptContent = `
// MongoDB Import Script
// Generated on ${new Date().toISOString()}

const { MongoClient } = require('mongodb');

async function importData() {
  const client = new MongoClient('mongodb://localhost:27017');
  
  try {
    await client.connect();
    console.log('Connected to MongoDB');
    
    const db = client.db('nandi_live');
    
    // Import each table
    ${Object.keys(this.migrationData).map(tableName => `
    // Import ${tableName}
    const ${tableName}Data = require('./migrated-data/${tableName}.json');
    const ${tableName}Collection = db.collection('${tableName}');
    await ${tableName}Collection.insertMany(${tableName}Data);
    console.log('Imported ${tableName}:', ${tableName}Data.length, 'records');
    `).join('\n')}
    
    console.log('✅ All data imported successfully!');
  } catch (error) {
    console.error('❌ Import failed:', error);
  } finally {
    await client.close();
  }
}

importData();
`;

    const scriptFile = path.join(config.output.directory, 'import-to-mongodb.js');
    fs.writeFileSync(scriptFile, scriptContent);
    console.log(`📄 MongoDB import script created: ${scriptFile}`);
  }

  async generateMigrationReport() {
    const report = {
      timestamp: new Date().toISOString(),
      source: {
        database: config.mysql.database,
        host: config.mysql.host,
        port: config.mysql.port
      },
      migration: this.migrationData,
      summary: {
        totalTables: Object.keys(this.migrationData).length,
        totalRecords: Object.values(this.migrationData).reduce((sum, data) => sum + (data.records || 0), 0),
        successfulTables: Object.values(this.migrationData).filter(data => !data.error).length,
        failedTables: Object.values(this.migrationData).filter(data => data.error).length
      }
    };

    const reportFile = path.join(config.output.directory, 'migration-report.json');
    fs.writeFileSync(reportFile, JSON.stringify(report, null, 2));
    console.log(`📄 Migration report saved: ${reportFile}`);

    console.log('\n📋 Migration Summary:');
    console.log('='.repeat(50));
    console.log(`Total Tables: ${report.summary.totalTables}`);
    console.log(`Total Records: ${report.summary.totalRecords}`);
    console.log(`Successful: ${report.summary.successfulTables}`);
    console.log(`Failed: ${report.summary.failedTables}`);
    console.log('='.repeat(50));
  }

  async cleanup() {
    if (this.mysqlConnection) {
      await this.mysqlConnection.end();
      console.log('🔌 MySQL connection closed');
    }
  }

  async run() {
    try {
      console.log('🚀 Starting MySQL to MongoDB migration...');
      console.log('='.repeat(50));

      await this.initialize();
      
      // Get all tables
      const tables = await this.getAllTables();
      console.log(`📋 Found ${tables.length} tables to migrate`);

      // Migrate each table
      for (const tableName of tables) {
        const result = await this.migrateTable(tableName);
        this.migrationData[tableName] = result;
      }

      // Generate MongoDB import script
      await this.generateMigrationScript();

      // Generate migration report
      await this.generateMigrationReport();

      console.log('='.repeat(50));
      console.log('✅ Migration completed successfully!');
      console.log(`📁 All data saved to: ${config.output.directory}`);
      console.log('\n📝 Next steps:');
      console.log('1. Install MongoDB locally or use MongoDB Atlas');
      console.log('2. Run: node migrated-data/import-to-mongodb.js');
      console.log('3. Your data will be imported into MongoDB!');
      
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

module.exports = MySQLToMongoDBMigration;

