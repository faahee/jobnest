# 🎓 JobNest - Department Level Placement Portal

A modern, futuristic web-based placement management system for connecting students with top companies. Built with **HTML5, CSS3, JavaScript**, and powered by **Chart.js** for analytics.

![JobNest](https://img.shields.io/badge/JobNest-Placement%20Portal-blue)
![HTML5](https://img.shields.io/badge/HTML5-E34C26?logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?logo=javascript&logoColor=black)
![Chart.js](https://img.shields.io/badge/Chart.js-FF6384?logo=javascript&logoColor=white)

---

## 📋 Table of Contents

- [Features](#features)
- [Quick Start](#quick-start)
- [Project Structure](#project-structure)
- [Technology Stack](#technology-stack)
- [How to Use](#how-to-use)
- [Real Companies Integrated](#real-companies-integrated)
- [Data Storage](#data-storage)
- [Browser Support](#browser-support)
- [Contributing](#contributing)
- [License](#license)

---

## ✨ Features

### 🏢 Job Listings
- **17 Real Companies** - Google, Amazon, Meta, Microsoft, Apple, IBM, TCS, Infosys, Capgemini, and more
- **Clickable Company Links** - Direct hyperlinks to official company websites
- **Job Details** - Position, location, salary range, recruiter info, and openings count
- **Modern Card Design** - Glassmorphic UI with smooth hover animations
- **Responsive Layout** - Works seamlessly on desktop, tablet, and mobile devices

### 👥 Recruiter Directory
- **Recruiter Profiles** - Names, emails, and company information
- **Company Links** - Visit official company websites directly
- **Professional Layout** - Social-style recruiter cards with icons

### 📝 Student Applications
- **Comprehensive Form** - Capture full student details:
  - Name, Email, Phone Number
  - Roll Number, Department (5 options)
  - CGPA (0-10 scale)
  - Resume Upload
  - Cover Letter
  - Portfolio/LinkedIn URL
- **File Upload** - Resume attachment with filename tracking
- **Validation** - Client-side form validation
- **Data Persistence** - Applications saved to browser storage

### 📊 Analytics Dashboard
- **4 Interactive Charts**:
  - Applications by Company (Doughnut)
  - Department-wise Applications (Horizontal Bar)
  - CGPA Distribution (Vertical Bar)
  - Application Timeline (Line Chart)
- **Real-time Statistics**:
  - Total Jobs Available
  - Total Applications Submitted
  - Average CGPA of Applicants
  - Total Companies Hiring
- **Powered by Chart.js** - Beautiful, responsive visualizations

### 🔔 Notification System
- **Toast Notifications** - Success/error messages on user actions
- **Notification History** - Persistent notification log with timestamps
- **Unread Badge** - Red badge showing unread notifications count
- **Auto-dismiss** - Toast notifications disappear after 3 seconds
- **Local Storage** - Notifications persist across page refreshes

### 🎨 Modern Design
- **Glassmorphic UI** - Frosted glass effect with backdrop blur
- **Gradient Backgrounds** - Blue (#0f0f2e) → Cyan (#46c8ff) → Neon Green (#00ff88)
- **Smooth Animations** - 8+ CSS animations for UI elements
- **Hover Effects** - Interactive feedback on all buttons and cards
- **Professional Styling** - Font Awesome icons, modern typography

---

## 🚀 Quick Start

### Method 1: Local File Opening
1. Clone the repository: `git clone https://github.com/faahee/jobnest.git`
2. Navigate to the folder: `cd jobnest`
3. Open `index.html` in your web browser
4. Start exploring jobs and submitting applications!

### Method 2: Live Server (Recommended)
1. Install VS Code Extension: **Live Server** (by Ritwick Dey)
2. Right-click `index.html` → Select "Open with Live Server"
3. Application opens at `http://127.0.0.1:5500`

### Method 3: Using Python HTTP Server
```bash
# Python 3
python -m http.server 8000

# Python 2
python -m SimpleHTTPServer 8000
```
Then visit: `http://localhost:8000`

---

## 📁 Project Structure

```
jobnest/
├── index.html           # Main application file (HTML + JavaScript)
├── style.css            # Complete styling with animations
├── README.md            # Project documentation
├── database.sql         # (Legacy) Database schema reference
├── config.php           # (Legacy) PHP configuration
└── Other legacy files   # (Not used in current version)
```

---

## 🛠️ Technology Stack

| Technology | Version | Purpose |
|-----------|---------|---------|
| **HTML5** | Latest | Semantic markup & structure |
| **CSS3** | Latest | Modern styling, animations, gradients |
| **JavaScript (ES6)** | Latest | Core application logic |
| **Chart.js** | 3.x+ | Interactive analytics charts |
| **Font Awesome** | 6.4.0 | Icons (300+ icons) |
| **LocalStorage API** | HTML5 | Browser data persistence |

**No Backend Required** - This is a fully client-side application with no server dependencies!

---

## 🎯 How to Use

### 1️⃣ Browse Jobs
- Click **"Jobs"** in the navigation bar
- Browse all available positions from top companies
- Click on company names to visit their official websites
- See position details, salary, recruiter info, and openings

### 2️⃣ View Recruiters
- Click **"Recruiters"** in the navigation bar
- See all recruiting company representatives
- Click **"Visit Company"** button to explore opportunities
- Contact recruiters via displayed email addresses

### 3️⃣ Apply for Jobs
- Click **"Apply Now"** on any job card
- Fill in all required student details:
  - Personal info (name, email, phone, roll number)
  - Academic info (department, CGPA)
  - Application docs (resume, cover letter, portfolio)
- Click **"Submit Application"** button
- Receive success notification
- Application automatically saved to browser storage

### 4️⃣ Check Notifications
- Click the **Bell Icon** (🔔) with red badge
- View application history with timestamps
- See all submissions and system notifications
- Badge shows count of unread notifications
- Automatically marked as read when opened

### 5️⃣ View Analytics
- Click **"Reports"** in the navigation bar
- See real-time statistics from submitted applications
- View 4 interactive charts:
  - Which companies received most applications
  - Which departments are most active
  - CGPA distribution of applicants
  - Timeline of application submissions
- Statistics updated instantly as new applications are submitted

---

## 🏢 Real Companies Integrated

### US Tech Giants (6)
| Company | Position | Location | Salary |
|---------|----------|----------|--------|
| Google | Software Engineer | Mountain View, CA | $120K - $180K |
| Amazon | Full Stack Developer | Seattle, WA | $110K - $170K |
| Meta | Backend Engineer | Menlo Park, CA | $130K - $190K |
| Microsoft | Cloud Solutions Architect | Redmond, WA | $115K - $175K |
| Apple | iOS Developer | Cupertino, CA | $125K - $185K |
| IBM | Enterprise Solutions Engineer | Armonk, NY | $100K - $155K |

### Indian IT Leaders (8)
| Company | Position | Location | Salary | Openings |
|---------|----------|----------|--------|----------|
| TCS | Software Developer | Mumbai | ₹6,00,000 - ₹12,00,000 | 50 |
| Infosys | Systems Engineer | Bangalore | ₹5,50,000 - ₹11,00,000 | 45 |
| Capgemini | Java Developer | Pune | ₹6,50,000 - ₹13,00,000 | 38 |
| Accenture | Cloud Engineer | Bangalore | ₹7,00,000 - ₹14,00,000 | 42 |
| Wipro | Software Analyst | Hyderabad | ₹5,75,000 - ₹10,50,000 | 48 |
| HCL Technologies | DevOps Engineer | Noida | ₹7,50,000 - ₹14,50,000 | 35 |
| Cognizant | QA Engineer | Chennai | ₹5,25,000 - ₹9,75,000 | 40 |
| Tech Mahindra | Network Engineer | Pune | ₹6,00,000 - ₹11,00,000 | 36 |

### Finance & Consulting (3)
| Company | Position | Location | Salary | Openings |
|---------|----------|----------|--------|----------|
| Deloitte | Management Consultant | New York, USA | $95K - $150K | 10 |
| Goldman Sachs | Quantitative Analyst | New York, USA | $150K - $250K | 4 |
| JPMorgan Chase | Software Engineer | Manhattan, USA | $120K - $200K | 8 |

**Total: 17 Companies • 500+ Total Openings**

---

## 💾 Data Storage

All application data is stored securely in the **browser's LocalStorage**:

### Stored Information
- **📝 Student Applications** - Full details submitted by applicants
- **🔔 Notifications** - Application history with timestamps
- **📊 Analytics** - Calculated from live application data

### Data Persistence
- Data survives page refreshes and browser restarts
- Each browser profile maintains its own isolated data
- Cleared when browser cache is cleared
- No data sent to external servers

### Example Application Object
```javascript
{
  id: 1708270400000,
  jobId: 1,
  name: "John Doe",
  email: "john@example.com",
  phone: "9876543210",
  rollNumber: "2021CS001",
  department: "CSE",
  cgpa: "8.5",
  resume: "Resume.pdf",
  coverLetter: "Interested in this role...",
  portfolio: "https://github.com/johndoe",
  appliedAt: "2/18/2026, 10:30:45 AM",
  status: "Pending"
}
```

---

## 🌐 Browser Support

| Browser | Version | Status |
|---------|---------|--------|
| Chrome | 90+ | ✅ Fully Supported |
| Firefox | 88+ | ✅ Fully Supported |
| Safari | 14+ | ✅ Fully Supported |
| Edge | 90+ | ✅ Fully Supported |
| Opera | 76+ | ✅ Fully Supported |
| Internet Explorer | 11 | ❌ Not Supported |

---

## 🎨 Customization Guide

### Change Color Scheme
Edit `style.css` and modify these CSS variables:
```css
:root {
  --primary-color: #0f0f2e;    /* Dark blue */
  --secondary-color: #46c8ff;  /* Cyan */
  --accent-color: #00ff88;     /* Neon green */
}
```

### Add More Companies
Edit `index.html` and add to the `jobsData` array:
```javascript
{
  id: 18,
  company: 'Your Company',
  position: 'Position Title',
  location: 'City, Country',
  salary: '$XXX,XXX - $YYY,YYY',
  recruiter_name: 'Name',
  website: 'https://....',
  openings: 10
}
```

### Modify Form Fields
Edit the Student Application form in `index.html` `<form>` section to add/remove fields as needed.

---

## 📱 Responsive Design

- **Desktop** (1200px+) - Full multi-column layout
- **Tablet** (768px - 1199px) - 2-column grid
- **Mobile** (480px - 767px) - Single column, optimized touch targets
- **Small Mobile** (<480px) - Compact single column layout

---

## 🐛 Troubleshooting

| Issue | Solution |
|-------|----------|
| Notifications not showing | Check browser console (F12) for errors, ensure notifications container exists |
| Applications not saved | Clear browser cache, check LocalStorage is enabled |
| Charts not displaying | Ensure Chart.js CDN is loaded, check browser console for JS errors |
| Styling issues | Hard refresh (Ctrl+Shift+R) to clear CSS cache |
| Icons not showing | Verify Font Awesome CDN link is active and not blocked |

---

## 👨‍💻 Development Tips

### Debug Mode
Open browser console (F12) and run:
```javascript
// Test notifications
testNotification();

// View all applications
console.log(applications);

// View all notifications
console.log(notifications);

// Clear all data
localStorage.clear();
```

### Performance Optimization
- Lazy load images (if added)
- Minimize CSS/JavaScript files for production
- Use gzip compression
- Enable browser caching

---

## 🤝 Contributing

Contributions are welcome! To contribute:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

---

## 🙏 Acknowledgments

- **Chart.js** - For beautiful interactive charts
- **Font Awesome** - For comprehensive icon library
- **Modern CSS** - Glassmorphic design inspiration
- **Company Data** - Real company information for placement opportunities

---

## 📞 Support

For issues, questions, or suggestions:
- Open an Issue on GitHub
- Check existing documentation
- Review the code comments

---

## 🚀 Future Enhancements

- [ ] Backend integration (Node.js/Python)
- [ ] User authentication system
- [ ] Email notifications
- [ ] Application status tracking
- [ ] Interview scheduling
- [ ] Faculty dashboard
- [ ] PDF export of analytics
- [ ] Multi-language support
- [ ] Dark/Light theme toggle
- [ ] Mobile app version

---

**Made with ❤️ for Department Placements | Last Updated: February 2026**

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
