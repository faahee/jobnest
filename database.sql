-- JobNest Database Schema
-- Created: February 18, 2026
-- Complete schema for JobNest Department Level Placement Portal

-- Create database
CREATE DATABASE IF NOT EXISTS jobnest;
USE jobnest;

-- ===== RECRUITERS TABLE =====
CREATE TABLE IF NOT EXISTS recruiters (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    company VARCHAR(100) NOT NULL,
    website VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    designation VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive') DEFAULT 'active'
);

-- ===== JOBS TABLE =====
CREATE TABLE IF NOT EXISTS jobs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    company VARCHAR(100) NOT NULL,
    position VARCHAR(150) NOT NULL,
    location VARCHAR(150) NOT NULL,
    salary VARCHAR(100) NOT NULL,
    recruiter_name VARCHAR(100) NOT NULL,
    recruiter_id INT NOT NULL,
    website VARCHAR(255) NOT NULL,
    openings INT DEFAULT 1,
    description LONGTEXT,
    requirements LONGTEXT,
    posted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status ENUM('active', 'closed', 'archived') DEFAULT 'active',
    FOREIGN KEY (recruiter_id) REFERENCES recruiters(id)
);

-- ===== STUDENTS TABLE =====
CREATE TABLE IF NOT EXISTS students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    roll_number VARCHAR(50) NOT NULL UNIQUE,
    department VARCHAR(50) NOT NULL,
    cgpa DECIMAL(3, 2) NOT NULL,
    resume_name VARCHAR(255) NOT NULL,
    cover_letter LONGTEXT,
    portfolio_url VARCHAR(255),
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ===== APPLICATIONS TABLE =====
CREATE TABLE IF NOT EXISTS applications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    job_id INT NOT NULL,
    resume_filename VARCHAR(255) NOT NULL,
    cover_letter LONGTEXT,
    portfolio_url VARCHAR(255),
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Pending', 'Under Review', 'Rejected', 'Accepted') DEFAULT 'Pending',
    notes LONGTEXT,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
    UNIQUE KEY unique_application (student_id, job_id)
);

-- ===== NOTIFICATIONS TABLE =====
CREATE TABLE IF NOT EXISTS notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    title VARCHAR(255) NOT NULL,
    message LONGTEXT NOT NULL,
    type ENUM('info', 'success', 'warning', 'error') DEFAULT 'info',
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

-- ===== ANALYTICS TABLE =====
CREATE TABLE IF NOT EXISTS analytics (
    id INT PRIMARY KEY AUTO_INCREMENT,
    job_id INT,
    total_applications INT DEFAULT 0,
    views INT DEFAULT 0,
    avg_cgpa DECIMAL(3, 2),
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE
);

-- ===== INSERT RECRUITERS DATA =====
INSERT INTO recruiters (name, email, company, website, designation) VALUES
('Sarah Chen', 'sarah.chen@google.com', 'Google', 'https://www.google.com', 'HR Recruiter'),
('Marcus Johnson', 'marcus.j@amazon.com', 'Amazon', 'https://www.amazon.com', 'Senior Recruiter'),
('Priya Patel', 'priya.patel@meta.com', 'Meta', 'https://www.meta.com', 'Talent Acquisition Manager'),
('David Kumar', 'david.kumar@microsoft.com', 'Microsoft', 'https://www.microsoft.com', 'Campus Recruiter'),
('Emma Williams', 'emma.williams@apple.com', 'Apple', 'https://www.apple.com', 'HR Specialist'),
('Robert Smith', 'robert.smith@ibm.com', 'IBM', 'https://www.ibm.com', 'Recruitment Coordinator'),
('Raj Sharma', 'raj.sharma@tcs.co.in', 'TCS', 'https://www.tcs.com', 'Hiring Manager'),
('Anjali Desai', 'anjali.desai@infosys.com', 'Infosys', 'https://www.infosys.com', 'Recruiter'),
('Vikram Gupta', 'vikram.gupta@capgemini.com', 'Capgemini', 'https://www.capgemini.com', 'Talent Acquisition'),
('Neha Reddy', 'neha.reddy@accenture.com', 'Accenture', 'https://www.accenture.com', 'Campus Coordinator'),
('Ramesh Iyer', 'ramesh.iyer@wipro.com', 'Wipro', 'https://www.wipro.com', 'HR Manager'),
('Shreya Mishra', 'shreya.mishra@hcltech.com', 'HCL Technologies', 'https://www.hcltech.com', 'Recruiter'),
('Arun Kumar', 'arun.kumar@cognizant.com', 'Cognizant', 'https://www.cognizant.com', 'Hiring Manager'),
('Divya Patel', 'divya.patel@techmahindra.com', 'Tech Mahindra', 'https://www.techmahindra.com', 'Talent Acquisition'),
('Jennifer Anderson', 'jennifer.anderson@deloitte.com', 'Deloitte', 'https://www.deloitte.com', 'Recruiter'),
('Michael Chen', 'michael.chen@goldmansachs.com', 'Goldman Sachs', 'https://www.goldmansachs.com', 'Campus Recruiter'),
('Lisa Thompson', 'lisa.thompson@jpmorganchase.com', 'JPMorgan Chase', 'https://www.jpmorganchase.com', 'HR Specialist');

-- ===== INSERT JOBS DATA =====
INSERT INTO jobs (company, position, location, salary, recruiter_name, recruiter_id, website, openings, description, requirements) VALUES
('Google', 'Software Engineer', 'Mountain View, California', '$120,000 - $180,000', 'Sarah Chen', 1, 'https://www.google.com', 8, 'We are looking for talented software engineers to join our team.', 'B.Tech in CS, DSA knowledge, Problem-solving skills'),
('Amazon', 'Full Stack Developer', 'Seattle, Washington', '$110,000 - $170,000', 'Marcus Johnson', 2, 'https://www.amazon.com', 12, 'Build scalable systems at Amazon.', 'AWS, Node.js, React experience'),
('Meta', 'Backend Engineer', 'Menlo Park, California', '$130,000 - $190,000', 'Priya Patel', 3, 'https://www.meta.com', 6, 'Build systems at scale for Meta.', 'Strong backend development skills'),
('Microsoft', 'Cloud Solutions Architect', 'Redmond, Washington', '$115,000 - $175,000', 'David Kumar', 4, 'https://www.microsoft.com', 9, 'Help organizations transform with Azure.', 'Azure certification, Cloud knowledge'),
('Apple', 'iOS Developer', 'Cupertino, California', '$125,000 - $185,000', 'Emma Williams', 5, 'https://www.apple.com', 5, 'Create innovative iOS applications.', 'Swift, iOS framework knowledge'),
('IBM', 'Enterprise Solutions Engineer', 'Armonk, New York', '$100,000 - $155,000', 'Robert Smith', 6, 'https://www.ibm.com', 7, 'Build enterprise solutions globally.', 'Enterprise software experience'),
('TCS', 'Software Developer', 'Mumbai, India', '₹6,00,000 - ₹12,00,000', 'Raj Sharma', 7, 'https://www.tcs.com', 50, 'Join India''s IT leader.', 'B.Tech CS, Java/C++ knowledge'),
('Infosys', 'Systems Engineer', 'Bangalore, India', '₹5,50,000 - ₹11,00,000', 'Anjali Desai', 8, 'https://www.infosys.com', 45, 'Build IT solutions globally.', 'B.Tech/BE in IT, Programming basics'),
('Capgemini', 'Java Developer', 'Pune, India', '₹6,50,000 - ₹13,00,000', 'Vikram Gupta', 9, 'https://www.capgemini.com', 38, 'Transform businesses digitally.', 'Java proficiency, OOP concepts'),
('Accenture', 'Cloud Engineer', 'Bangalore, India', '₹7,00,000 - ₹14,00,000', 'Neha Reddy', 10, 'https://www.accenture.com', 42, 'Innovate cloud solutions.', 'Cloud platform, AWS/Azure'),
('Wipro', 'Software Analyst', 'Hyderabad, India', '₹5,75,000 - ₹10,50,000', 'Ramesh Iyer', 11, 'https://www.wipro.com', 48, 'Deliver IT excellence globally.', 'Analytical skills, Programming'),
('HCL Technologies', 'DevOps Engineer', 'Noida, India', '₹7,50,000 - ₹14,50,000', 'Shreya Mishra', 12, 'https://www.hcltech.com', 35, 'Build robust CI/CD pipelines.', 'Docker, Kubernetes, DevOps tools'),
('Cognizant', 'QA Engineer', 'Chennai, India', '₹5,25,000 - ₹9,75,000', 'Arun Kumar', 13, 'https://www.cognizant.com', 40, 'Ensure quality excellence.', 'Testing frameworks, Automation'),
('Tech Mahindra', 'Network Engineer', 'Pune, India', '₹6,00,000 - ₹11,00,000', 'Divya Patel', 14, 'https://www.techmahindra.com', 36, 'Design network infrastructure.', 'Networking, Cisco knowledge'),
('Deloitte', 'Management Consultant', 'New York, USA', '$95,000 - $150,000', 'Jennifer Anderson', 15, 'https://www.deloitte.com', 10, 'Lead business transformation.', 'Consulting, MBA preferred'),
('Goldman Sachs', 'Quantitative Analyst', 'New York, USA', '$150,000 - $250,000', 'Michael Chen', 16, 'https://www.goldmansachs.com', 4, 'Develop financial models.', 'Mathematics, C++, Python'),
('JPMorgan Chase', 'Software Engineer', 'Manhattan, USA', '$120,000 - $200,000', 'Lisa Thompson', 17, 'https://www.jpmorganchase.com', 8, 'Build fintech solutions.', 'Java/Python, Financial systems');

-- ===== CREATE INDEXES =====
CREATE INDEX idx_jobs_company ON jobs(company);
CREATE INDEX idx_jobs_status ON jobs(status);
CREATE INDEX idx_applications_student ON applications(student_id);
CREATE INDEX idx_applications_job ON applications(job_id);
CREATE INDEX idx_applications_status ON applications(status);
CREATE INDEX idx_notifications_student ON notifications(student_id);
CREATE INDEX idx_notifications_read ON notifications(is_read);

-- ===== DISPLAY SCHEMA INFORMATION =====
-- Tables created: recruiters, jobs, students, applications, notifications, analytics
-- Total recruiters: 17
-- Total jobs: 17
-- Ready for production use

