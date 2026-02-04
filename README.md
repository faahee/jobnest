# JobNest - Department Level Placement System

A web-based placement management system built with HTML, CSS, PHP, and MySQL.

---

## Table of Contents

1. [Prerequisites](#prerequisites)
2. [Installation](#installation)
3. [Running the Application](#running-the-application)
4. [Database Structure](#database-structure)
5. [Accessing Data via phpMyAdmin](#accessing-data-via-phpmyadmin)
6. [Login Credentials](#login-credentials)
7. [Project Structure](#project-structure)

---

## Prerequisites

Before running this project, ensure you have the following installed:

- **XAMPP** (includes Apache, MySQL, PHP, and phpMyAdmin)
  - Download from: https://www.apachefriends.org/download.html
  - Recommended version: XAMPP 8.0 or higher

---

## Installation

### Step 1: Install XAMPP

1. Download XAMPP from the official website
2. Run the installer and follow the installation wizard
3. Install to the default location: `C:\xampp`

### Step 2: Copy Project Files

Copy the `jobnest` folder to the XAMPP htdocs directory:

```
C:\xampp\htdocs\jobnest
```

### Step 3: Start XAMPP Services

1. Open XAMPP Control Panel (`C:\xampp\xampp-control.exe`)
2. Click **Start** next to **Apache**
3. Click **Start** next to **MySQL**
4. Both should show green indicating they are running

### Step 4: Create the Database

**Option A: Using phpMyAdmin (Recommended)**

1. Open browser and go to: `http://localhost/phpmyadmin`
2. Click on **Import** tab at the top
3. Click **Choose File** and select `database.sql` from the jobnest folder
4. Click **Go** to import

**Option B: Using Command Line**

Open Command Prompt or PowerShell and run:

```bash
cd C:\xampp\mysql\bin
mysql -u root < "C:\xampp\htdocs\jobnest\database.sql"
```

---

## Running the Application

1. Ensure Apache and MySQL are running in XAMPP Control Panel
2. Open your web browser
3. Navigate to: **http://localhost/jobnest/index.html**
4. You should see the JobNest login page

---

## Database Structure

The application uses a MySQL database named `jobnest` with the following tables:

### Users Table

Stores all user account information.

| Column | Type | Description |
|--------|------|-------------|
| id | INT (Primary Key) | Unique user identifier |
| email | VARCHAR(255) | User's email address (unique) |
| password | VARCHAR(255) | Bcrypt hashed password |
| role | ENUM | User role: 'student', 'recruiter', or 'faculty' |
| name | VARCHAR(100) | User's full name |
| created_at | TIMESTAMP | Account creation date |

### Jobs Table

Stores job listings posted by recruiters.

| Column | Type | Description |
|--------|------|-------------|
| id | INT (Primary Key) | Unique job identifier |
| company | VARCHAR(100) | Company name |
| position | VARCHAR(100) | Job position/title |
| location | VARCHAR(100) | Job location |
| salary | VARCHAR(50) | Salary range |
| description | TEXT | Job description |
| created_by | INT (Foreign Key) | ID of recruiter who posted |
| created_at | TIMESTAMP | Job posting date |

### Applications Table

Stores job applications submitted by students.

| Column | Type | Description |
|--------|------|-------------|
| id | INT (Primary Key) | Unique application identifier |
| user_id | INT (Foreign Key) | ID of student who applied |
| job_id | INT (Foreign Key) | ID of job applied to |
| status | ENUM | Status: 'pending', 'accepted', or 'rejected' |
| applied_at | TIMESTAMP | Application submission date |

---

## Accessing Data via phpMyAdmin

phpMyAdmin is a web-based tool for managing MySQL databases.

### Opening phpMyAdmin

1. Ensure MySQL is running in XAMPP
2. Open browser and go to: **http://localhost/phpmyadmin**

### Viewing Users

1. In the left sidebar, click on **jobnest** database
2. Click on **users** table
3. You will see all registered users in a table format
4. Click **Browse** tab to view data

### Viewing Jobs

1. Select **jobnest** database
2. Click on **jobs** table
3. View all job listings

### Viewing Applications

1. Select **jobnest** database
2. Click on **applications** table
3. View all submitted applications

### Running Custom Queries

1. Click on **jobnest** database
2. Click on **SQL** tab at the top
3. Enter your query, for example:

```sql
-- View all users
SELECT * FROM users;

-- View all jobs with recruiter names
SELECT j.*, u.name as recruiter_name 
FROM jobs j 
JOIN users u ON j.created_by = u.id;

-- View applications with student and job details
SELECT a.id, u.name as student_name, u.email, j.company, j.position, a.status 
FROM applications a 
JOIN users u ON a.user_id = u.id 
JOIN jobs j ON a.job_id = j.id;
```

4. Click **Go** to execute

### Adding/Editing/Deleting Data

- **Add new record**: Click **Insert** tab
- **Edit record**: Click **Edit** (pencil icon) next to any row
- **Delete record**: Click **Delete** (X icon) next to any row

---

## Login Credentials

### Sample Users (Pre-configured)

| Role | Email | Password |
|------|-------|----------|
| Student | student@example.com | password123 |
| Recruiter | recruiter@example.com | password123 |
| Faculty | faculty@example.com | password123 |

### Registering New Users

1. Go to the login page
2. Click on any login button (Student/Recruiter/Faculty)
3. Click **Register** link in the modal
4. Fill in name, email, and password
5. Click **Register** to create account

---

## Project Structure

```
jobnest/
├── index.html          # Main HTML page with login and dashboard
├── style.css           # CSS styles for the application
├── config.php          # Database connection configuration
├── database.sql        # SQL script to create database and tables
├── login.php           # Handles user login authentication
├── register.php        # Handles new user registration
├── logout.php          # Handles user logout
├── get_jobs.php        # API to fetch available jobs
├── get_applications.php # API to fetch user's applications
├── apply_job.php       # API to apply for a job
└── README.md           # This documentation file
```

### File Descriptions

| File | Purpose |
|------|---------|
| `config.php` | Contains database connection settings (host, database name, username, password) |
| `login.php` | Validates user credentials against database, creates session on success |
| `register.php` | Creates new user accounts with hashed passwords |
| `logout.php` | Destroys user session and redirects to login page |
| `get_jobs.php` | Returns all jobs from database as JSON |
| `get_applications.php` | Returns current user's applications as JSON |
| `apply_job.php` | Creates new application record in database |

---

## Database Configuration

If you need to modify database settings, edit `config.php`:

```php
$host = 'localhost';      // Database host
$dbname = 'jobnest';      // Database name
$username = 'root';       // MySQL username
$password = '';           // MySQL password (empty by default in XAMPP)
```

---

## Troubleshooting

### Apache/MySQL not starting

- Check if another application is using port 80 (Apache) or 3306 (MySQL)
- Open XAMPP Control Panel → Config → Change ports

### Database connection error

- Ensure MySQL is running in XAMPP
- Verify database credentials in `config.php`
- Check if `jobnest` database exists

### Login not working

- Ensure you copied files to `C:\xampp\htdocs\jobnest`
- Access via `http://localhost/jobnest/` not file path
- Check browser console for JavaScript errors

### phpMyAdmin not accessible

- Ensure Apache and MySQL are both running
- Try: `http://127.0.0.1/phpmyadmin`

---

## Security Notes

- Passwords are hashed using PHP's `password_hash()` with bcrypt algorithm
- SQL injection is prevented using PDO prepared statements
- Input is sanitized using `filter_input()` functions
- Sessions are used to maintain logged-in state

---

## Contact

For any issues or questions regarding this project, please contact your system administrator.
