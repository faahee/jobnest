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
('Raj Sharma', 'raj.sharma@tcs.co.in', 'TCS', 'https://www.tcs.com', 'Hiring Manager');

-- ===== INSERT JOBS DATA =====
INSERT INTO jobs (company, position, location, salary, recruiter_name, recruiter_id, website, openings, description, requirements) VALUES
('Google', 'Software Engineer', 'Mountain View, California', '$120,000 - $180,000', 'Sarah Chen', 1, 'https://www.google.com', 8, 'We are looking for talented software engineers to join our team.', 'B.Tech in CS, DSA knowledge, Problem-solving skills'),
('Amazon', 'Full Stack Developer', 'Seattle, Washington', '$110,000 - $170,000', 'Marcus Johnson', 2, 'https://www.amazon.com', 12, 'Build scalable systems at Amazon.', 'AWS, Node.js, React experience'),
('TCS', 'Software Developer', 'Mumbai, India', '₹6,00,000 - ₹12,00,000', 'Raj Sharma', 3, 'https://www.tcs.com', 50, 'Join India''s IT leader.', 'B.Tech CS, Java/C++ knowledge');

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
-- Total recruiters: 3
-- Total jobs: 3
-- Ready for production use

