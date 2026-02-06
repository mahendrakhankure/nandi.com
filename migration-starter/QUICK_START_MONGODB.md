# 🚀 **QUICK START GUIDE - MONGODB MIGRATION**

## **📋 OVERVIEW**

This guide will help you quickly set up and migrate your PHP CodeIgniter project to Node.js TypeScript with MongoDB.

---

## **⚡ QUICK SETUP (5 Minutes)**

### **1. Prerequisites**
```bash
# Install Node.js 18+ and npm
# Download from: https://nodejs.org/

# Install MongoDB 7.0+
# Download from: https://www.mongodb.com/try/download/community

# Or use Docker (recommended)
docker --version
docker-compose --version
```

### **2. Project Setup**
```bash
# Create new directory
mkdir nandi-live-nodejs
cd nandi-live-nodejs

# Copy migration files
cp -r migration-starter/* .

# Install dependencies
npm install

# Copy environment file
cp env.example .env
```

### **3. MongoDB Setup (Choose One)**

#### **Option A: Docker (Recommended)**
```bash
# Start MongoDB with Docker Compose
docker-compose up -d mongo

# MongoDB will be available at:
# - Local: mongodb://localhost:27017/nandi_live
# - Admin: mongodb://admin:password@localhost:27017/
```

#### **Option B: Local Installation**
```bash
# Start MongoDB service
sudo systemctl start mongod
sudo systemctl enable mongod

# MongoDB will be available at:
# mongodb://localhost:27017/nandi_live
```

### **4. Environment Configuration**
```bash
# Edit .env file
nano .env

# Update these values:
MONGODB_URI=mongodb://localhost:27017/nandi_live
JWT_SECRET=your-super-secret-jwt-key-here
JWT_REFRESH_SECRET=your-super-secret-refresh-key-here
```

### **5. Start Development**
```bash
# Start development server
npm run dev

# Server will be running at: http://localhost:3000
# Health check: http://localhost:3000/health
# API docs: http://localhost:3000/api-docs
```

---

## **🔄 DATA MIGRATION**

### **Migrate from MySQL to MongoDB**

If you have existing MySQL data, use the migration script:

```bash
# Add MySQL connection details to .env
MYSQL_HOST=localhost
MYSQL_PORT=3306
MYSQL_USER=root
MYSQL_PASSWORD=your_password
MYSQL_DATABASE=nandi_live

# Run migration
npm run migrate

# Or run directly
npx ts-node src/scripts/migrate-to-mongodb.ts
```

### **Migration Features**
- ✅ **Users migration** with password hashing
- ✅ **Admins migration** with role management
- ✅ **Games migration** with metadata
- ✅ **Custom tables** automatic migration
- ✅ **Database indexes** for performance
- ✅ **Migration report** generation

---

## **🧪 TESTING**

### **Run Tests**
```bash
# Unit tests
npm test

# Integration tests
npm test -- --testPathPattern=integration

# Test coverage
npm test -- --coverage
```

### **API Testing**
```bash
# Test health endpoint
curl http://localhost:3000/health

# Test authentication
curl -X POST http://localhost:3000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{"username":"testuser","email":"test@example.com","password":"password123"}'
```

---

## **🚀 PRODUCTION DEPLOYMENT**

### **Docker Deployment**
```bash
# Build and start all services
docker-compose up -d

# Services available:
# - App: http://localhost:3000
# - MongoDB: localhost:27017
# - Redis: localhost:6379
# - Mongo Express: http://localhost:8081
```

### **Manual Deployment**
```bash
# Build application
npm run build

# Set production environment
export NODE_ENV=production

# Start production server
npm start
```

---

## **📊 MONITORING**

### **Health Checks**
```bash
# Application health
curl http://localhost:3000/health

# MongoDB health
curl http://localhost:3000/health | jq '.database'
```

### **Logs**
```bash
# Application logs
tail -f logs/app.log

# Docker logs
docker-compose logs -f app
docker-compose logs -f mongo
```

---

## **🔧 TROUBLESHOOTING**

### **Common Issues**

#### **1. MongoDB Connection Failed**
```bash
# Check MongoDB status
sudo systemctl status mongod

# Check MongoDB logs
sudo journalctl -u mongod

# Test connection
mongo mongodb://localhost:27017/nandi_live
```

#### **2. Port Already in Use**
```bash
# Find process using port
lsof -i :3000
lsof -i :27017

# Kill process
kill -9 <PID>
```

#### **3. Permission Issues**
```bash
# Fix MongoDB permissions
sudo chown -R mongodb:mongodb /var/lib/mongodb
sudo chown -R mongodb:mongodb /var/log/mongodb
```

#### **4. Docker Issues**
```bash
# Reset Docker containers
docker-compose down
docker-compose up -d

# Clear Docker volumes
docker-compose down -v
docker-compose up -d
```

---

## **📈 PERFORMANCE TIPS**

### **MongoDB Optimization**
```javascript
// Create indexes for better performance
db.users.createIndex({ "email": 1 }, { unique: true })
db.users.createIndex({ "status": 1 })
db.users.createIndex({ "createdAt": -1 })

// Use aggregation pipelines for complex queries
db.users.aggregate([
  { $match: { status: "active" } },
  { $group: { _id: "$role", count: { $sum: 1 } } }
])
```

### **Application Optimization**
```typescript
// Use connection pooling
const mongoConfig = {
  maxPoolSize: 20,
  serverSelectionTimeoutMS: 5000,
  socketTimeoutMS: 45000,
  bufferCommands: false,
  bufferMaxEntries: 0
};

// Enable query logging in development
mongoose.set('debug', process.env.NODE_ENV === 'development');
```

---

## **🔐 SECURITY CHECKLIST**

### **Production Security**
- [ ] Change default MongoDB passwords
- [ ] Enable MongoDB authentication
- [ ] Set up firewall rules
- [ ] Use HTTPS in production
- [ ] Configure rate limiting
- [ ] Enable CORS properly
- [ ] Use environment variables for secrets
- [ ] Set up monitoring and alerting

### **MongoDB Security**
```bash
# Create admin user
mongo admin
db.createUser({
  user: "admin",
  pwd: "secure_password",
  roles: ["userAdminAnyDatabase", "dbAdminAnyDatabase", "readWriteAnyDatabase"]
})

# Enable authentication
sudo nano /etc/mongod.conf
security:
  authorization: enabled
```

---

## **📞 SUPPORT**

### **Getting Help**
1. **Check logs**: `tail -f logs/app.log`
2. **Test connections**: Use health endpoints
3. **Verify configuration**: Check `.env` file
4. **Review documentation**: See `README.md`
5. **Run tests**: `npm test`

### **Useful Commands**
```bash
# Development
npm run dev          # Start development server
npm run build        # Build for production
npm test             # Run tests
npm run lint         # Check code quality

# Database
npm run migrate      # Run data migration
npm run seed         # Seed test data

# Docker
docker-compose up -d # Start all services
docker-compose logs  # View logs
docker-compose down  # Stop services
```

---

## **🎉 NEXT STEPS**

1. **✅ Complete setup** - Your Node.js TypeScript app is running
2. **✅ Test functionality** - Verify all endpoints work
3. **✅ Migrate data** - Transfer your existing data
4. **✅ Deploy to production** - Use Docker or manual deployment
5. **✅ Monitor performance** - Set up logging and monitoring
6. **✅ Scale as needed** - Add more instances or optimize

---

**🚀 Your PHP to Node.js TypeScript MongoDB migration is ready!**

