-- Create database
CREATE DATABASE IF NOT EXISTS jobnest;
USE jobnest;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'recruiter', 'faculty') NOT NULL,
    name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Jobs table
CREATE TABLE IF NOT EXISTS jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company VARCHAR(100) NOT NULL,
    position VARCHAR(100) NOT NULL,
    location VARCHAR(100) NOT NULL,
    salary VARCHAR(50) NOT NULL,
    description TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Applications table
CREATE TABLE IF NOT EXISTS applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    job_id INT NOT NULL,
    status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending',
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (job_id) REFERENCES jobs(id)
);

-- Insert sample users (password is 'password123' hashed with bcrypt)
INSERT INTO users (email, password, role, name) VALUES
('student@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'John Student'),
('recruiter@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'recruiter', 'Jane Recruiter'),
('faculty@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'faculty', 'Dr. Faculty');

-- Insert sample jobs
INSERT INTO jobs (company, position, location, salary, description, created_by) VALUES
('Tech Corp', 'Software Developer', 'Bangalore', '5-7 LPA', 'Looking for skilled software developers', 2),
('Data Solutions', 'Data Analyst', 'Mumbai', '6-8 LPA', 'Data analyst position available', 2),
('Web Systems', 'Web Developer', 'Hyderabad', '7-9 LPA', 'Web developer needed for exciting projects', 2);

-- Insert sample applications
INSERT INTO applications (user_id, job_id, status) VALUES
(1, 1, 'accepted'),
(1, 2, 'pending');
