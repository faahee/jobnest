# JobNest XAMPP Setup Guide

## Steps to Setup JobNest on XAMPP

### 1. Copy Project to XAMPP
Move or copy the `jobnest` folder to:
```
C:\xampp\htdocs\jobnest
```

### 2. Start XAMPP Services
1. Open **XAMPP Control Panel**
2. Start **Apache** (click Start)
3. Start **MySQL** (click Start)

### 3. Create Database & Import Schema
1. Open phpMyAdmin: http://localhost/phpmyadmin
2. Click **"New"** in the left sidebar
3. Enter database name: `jobnest`
4. Click **Create**
5. Select the `jobnest` database
6. Click **Import** tab at the top
7. Click **Choose File** → select `database.sql` from your project folder
8. Click **Go** to import

### 4. Verify Database Connection
The `config.php` is already configured for XAMPP defaults:
```php
$host = 'localhost';
$dbname = 'jobnest';
$username = 'root';
$password = '';  // XAMPP default has no password
```

If you set a MySQL password, update the `$password` value in config.php.

### 5. Access the Application
Open your browser and go to:
```
http://localhost/jobnest/index.html
```

### 6. Verify API Connection
Test the API by visiting:
- http://localhost/jobnest/api/get-jobs.php
- http://localhost/jobnest/api/get-recruiters.php

You should see JSON data with jobs and recruiters.
