# JobNest Backend Setup Guide

## Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher (or MariaDB 10.3+)
- Apache web server with mod_rewrite enabled
- Composer (optional, for future dependencies)

## Installation Steps

### 1. Database Setup

**Step 1.1:** Import the database schema
```bash
# Using MySQL command line
mysql -u root -p < database.sql

# Or using MySQL GUI (phpMyAdmin)
# - Create new database: jobnest
# - Import database.sql file
# - Verify tables are created
```

**Step 1.2:** Verify database was created
```bash
mysql -u root -p
USE jobnest;
SHOW TABLES;
SELECT COUNT(*) FROM recruiters;
SELECT COUNT(*) FROM jobs;
```

You should see:
- 6 tables created (recruiters, jobs, students, applications, notifications, analytics)
- 17 recruiters in the database
- 17 jobs in the database

### 2. File Structure Configuration

Create required directories:

```bash
# From jobnest root directory
mkdir -p api
mkdir -p uploads
mkdir -p logs

# Set permissions (Linux/Mac)
chmod 755 uploads/
chmod 755 logs/
chmod 755 api/
```

### 3. Configuration

**config.php** - Already configured for localhost:
```php
$host = 'localhost';
$dbname = 'jobnest';
$username = 'root';
$password = '';
```

Update if your database has different credentials:
```php
$host = 'your-host';           // Change if not localhost
$dbname = 'jobnest';           // Database name
$username = 'your-username';   // MySQL user
$password = 'your-password';   // MySQL password
```

### 4. API Files Verification

Verify all API files exist:
```
jobnest/
├── api/
│   ├── config.php                    (Shared) ✓
│   ├── get-jobs.php                  ✓
│   ├── get-recruiters.php            ✓
│   ├── submit-application.php        ✓
│   ├── get-applications.php          ✓
│   ├── get-notifications.php         ✓
│   ├── update-notification.php       ✓
│   ├── .htaccess                     ✓
│   └── README.md                     (API Docs) ✓
├── config.php                        ✓
├── database.sql                      ✓
├── uploads/                          (Created above)
├── logs/                             (Created above)
└── index.html                        ✓
```

### 5. Web Server Configuration

**For Apache:**

Ensure `.htaccess` files are enabled:
```apache
# In httpd.conf or apache2.conf
<Directory /path/to/jobnest>
    AllowOverride All
    Require all granted
</Directory>
```

Enable mod_rewrite:
```bash
# Ubuntu/Debian
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### 6. Testing the Setup

#### Test 1: Database Connection
```bash
# Create test.php in jobnest root
<?php
require_once 'config.php';
echo "Database connection successful!";
?>

# Access via browser
http://localhost/jobnest/test.php
```

#### Test 2: API Endpoints

**Get all jobs:**
```bash
curl "http://localhost/jobnest/api/get-jobs.php"
```

Expected response:
```json
{
  "success": true,
  "message": "Jobs retrieved successfully",
  "data": {
    "jobs": [...],
    "count": 17,
    "total": 17
  }
}
```

**Get all recruiters:**
```bash
curl "http://localhost/jobnest/api/get-recruiters.php"
```

**Submit test application:**
```bash
curl -X POST http://localhost/jobnest/api/submit-application.php \
  -F "name=Test Student" \
  -F "email=test@example.com" \
  -F "phone=9876543210" \
  -F "roll_number=TEST001" \
  -F "department=CSE" \
  -F "cgpa=8.5" \
  -F "job_id=1" \
  -F "resume=@path/to/resume.pdf"
```

### 7. Frontend Integration

Update frontend JavaScript to call API endpoints instead of hardcoded data:

**In index.html, replace:**
```javascript
// Old: Hardcoded jobs
const jobsData = [...]

// New: Fetch from API
fetch('api/get-jobs.php')
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      const jobsData = data.data.jobs;
      // Use jobsData as before
    }
  })
```

### 8. Troubleshooting

**Problem: "Database connection failed"**
- Check MySQL is running: `mysql -u root -p`
- Verify credentials in config.php
- Ensure 'jobnest' database exists: `SHOW DATABASES;`

**Problem: "Permission denied" on uploads/
- Check directory permissions: `chmod 755 uploads/`
- Verify web server user can write: `ls -la uploads/`

**Problem: API returns 404**
- Check .htaccess is in api/ folder
- Verify mod_rewrite is enabled
- Restart Apache: `sudo systemctl restart apache2`

**Problem: File upload fails**
- Check directory exists: `ls -la uploads/`
- Verify permissions: `chmod 755 uploads/`
- Check PHP upload settings: `php.ini` post_max_size and upload_max_filesize

**Problem: CORS errors in browser console**
- API already has CORS headers enabled in config.php
- Some browsers may need OPTIONS pre-flight handling (future enhancement)

### 9. Email Notifications (Optional Future Enhancement)

To enable email notifications, add to config.php:
```php
// Email configuration
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-email@gmail.com');
define('SMTP_PASS', 'your-app-password');
define('FROM_EMAIL', 'noreply@jobnest.edu');
```

Then modify `api/submit-application.php` to send confirmation email.

### 10. Production Deployment Checklist

- [ ] Database backup created
- [ ] Environment variables moved to .env file
- [ ] Error logging configured
- [ ] File upload directory has proper permissions (755)
- [ ] Logs directory writable by web server
- [ ] Database password changed from default
- [ ] SSL/HTTPS enabled
- [ ] Firewall configured to allow only necessary ports
- [ ] Regular backups automated
- [ ] Monitoring/logging setup
- [ ] Rate limiting implemented (for submission endpoints)

### 11. Database Backup

Regular database backups:
```bash
# Create backup
mysqldump -u root -p jobnest > jobnest_backup_$(date +%Y%m%d).sql

# Restore from backup
mysql -u root -p jobnest < jobnest_backup_20240218.sql
```

### 12. API Activity Logs

Monitor API logs:
```bash
# View API activity
tail -f logs/api.log

# Search for errors
grep ERROR logs/api.log

# Count requests by type
grep GET logs/api.log | wc -l
grep POST logs/api.log | wc -l
```

---

## Quick Start Command Reference

```bash
# Start local MySQL server
mysql -u root -p

# Import database
mysql -u root -p jobnest < database.sql

# Verify tables
mysql -u root -p -e "USE jobnest; SHOW TABLES;"

# View logs
tail -f logs/api.log

# Test API
curl "http://localhost/jobnest/api/get-jobs.php"
```

---

## Next Steps

1. ✅ Database setup complete
2. ✅ API files deployed
3. ⏳ Frontend integration (update index.html to call APIs)
4. ⏳ Authentication system (login/logout)
5. ⏳ Email notifications
6. ⏳ Admin dashboard
7. ⏳ Analytics dashboard

---

**Setup Version:** 1.0  
**Last Updated:** February 18, 2024  
**Status:** Ready for Testing
