# JobNest API Documentation

## Overview
JobNest API provides RESTful endpoints for the placement portal backend. All responses are in JSON format.

## Base URL
```
http://localhost/jobnest/api/
```

## Response Format

### Success Response
```json
{
  "success": true,
  "message": "Operation successful",
  "data": {...}
}
```

### Error Response
```json
{
  "success": false,
  "message": "Error description",
  "data": {...}
}
```

---

## API Endpoints

### 1. Get Jobs
**Endpoint:** `GET /get-jobs.php`

**Description:** Retrieve list of all active jobs with filters and pagination

**Query Parameters:**
- `status` (optional): Filter by job status (default: 'active')
- `company` (optional): Search by company name
- `limit` (optional): Number of results to return (default: 50, max: 100)
- `offset` (optional): Number of results to skip (default: 0)

**Example Request:**
```
GET /get-jobs.php?status=active&company=Google&limit=10&offset=0
```

**Example Response:**
```json
{
  "success": true,
  "message": "Jobs retrieved successfully",
  "data": {
    "jobs": [
      {
        "id": 1,
        "company": "Google",
        "position": "Software Engineer",
        "location": "Mountain View, California",
        "salary": "$120,000 - $180,000",
        "recruiter_name": "Sarah Chen",
        "website": "https://www.google.com",
        "openings": 8,
        "total_applications": 45,
        "accepted_count": 3,
        "posted_at": "2024-02-18T10:30:00"
      }
    ],
    "count": 1,
    "total": 17,
    "limit": 10,
    "offset": 0
  }
}
```

---

### 2. Get Recruiters
**Endpoint:** `GET /get-recruiters.php`

**Description:** Retrieve list of all active recruiters with their job postings count

**Query Parameters:**
- `status` (optional): Filter by recruiter status (default: 'active')
- `limit` (optional): Number of results to return (default: 50, max: 100)
- `offset` (optional): Number of results to skip (default: 0)

**Example Request:**
```
GET /get-recruiters.php?status=active&limit=20
```

**Example Response:**
```json
{
  "success": true,
  "message": "Recruiters retrieved successfully",
  "data": {
    "recruiters": [
      {
        "id": 1,
        "name": "Sarah Chen",
        "email": "sarah.chen@google.com",
        "company": "Google",
        "website": "https://www.google.com",
        "phone": "1-650-253-0000",
        "designation": "HR Recruiter",
        "total_jobs": 1,
        "total_applications": 45
      }
    ],
    "count": 1,
    "total": 17,
    "limit": 20,
    "offset": 0
  }
}
```

---

### 3. Submit Application
**Endpoint:** `POST /submit-application.php`

**Description:** Submit a new job application with student and resume details

**Required Fields:**
- `name` (string): Student full name
- `email` (string): Student email address
- `phone` (string): 10-digit phone number
- `roll_number` (string): Student roll number
- `department` (string): Department (CSE, ECE, ME, CE, EEE)
- `cgpa` (number): CGPA (0-10)
- `job_id` (integer): Job ID to apply for
- `resume` (file): Resume PDF/DOC/DOCX (max 5MB)

**Optional Fields:**
- `cover_letter` (string): Cover letter text
- `portfolio_url` (string): Portfolio website URL

**Example Request:**
```bash
curl -X POST http://localhost/jobnest/api/submit-application.php \
  -F "name=John Doe" \
  -F "email=john@example.com" \
  -F "phone=9876543210" \
  -F "roll_number=CSE001" \
  -F "department=CSE" \
  -F "cgpa=8.5" \
  -F "job_id=1" \
  -F "resume=@resume.pdf" \
  -F "cover_letter=I am interested..." \
  -F "portfolio_url=https://john.dev"
```

**Example Response:**
```json
{
  "success": true,
  "message": "Application submitted successfully",
  "data": {
    "student_id": 42,
    "application_id": 156,
    "resume_filename": "resume_65c8d9a5e4a2c.pdf"
  }
}
```

**Validation Rules:**
- Name: minimum 2 characters
- Email: valid email format
- Phone: exactly 10 digits
- CGPA: must be between 0 and 10
- Resume: PDF, DOC, or DOCX format, max 5MB

---

### 4. Get Applications
**Endpoint:** `GET /get-applications.php`

**Description:** Retrieve applications with optional filters

**Query Parameters:**
- `student_id` (optional): Filter by student ID
- `job_id` (optional): Filter by job ID
- `status` (optional): Filter by status (Pending, Under Review, Rejected, Accepted)
- `limit` (optional): Number of results (default: 50, max: 100)
- `offset` (optional): Results to skip (default: 0)

**Example Request:**
```
GET /get-applications.php?student_id=42&limit=10
```

**Example Response:**
```json
{
  "success": true,
  "message": "Applications retrieved successfully",
  "data": {
    "applications": [
      {
        "id": 156,
        "student_id": 42,
        "job_id": 1,
        "student_name": "John Doe",
        "student_email": "john@example.com",
        "roll_number": "CSE001",
        "department": "CSE",
        "cgpa": "8.50",
        "company": "Google",
        "position": "Software Engineer",
        "location": "Mountain View, California",
        "salary": "$120,000 - $180,000",
        "applied_at": "2024-02-18T15:45:30",
        "status": "Pending",
        "resume_filename": "resume_65c8d9a5e4a2c.pdf",
        "cover_letter": "I am interested...",
        "portfolio_url": "https://john.dev",
        "notes": null
      }
    ],
    "count": 1,
    "total": 5,
    "limit": 10,
    "offset": 0
  }
}
```

---

### 5. Get Notifications
**Endpoint:** `GET /get-notifications.php`

**Description:** Retrieve notifications for a student

**Query Parameters:**
- `student_id` (required): Student ID
- `unread_only` (optional): Only unread notifications (true/false, default: false)
- `limit` (optional): Number of results (default: 50, max: 100)
- `offset` (optional): Results to skip (default: 0)

**Example Request:**
```
GET /get-notifications.php?student_id=42&unread_only=true
```

**Example Response:**
```json
{
  "success": true,
  "message": "Notifications retrieved successfully",
  "data": {
    "notifications": [
      {
        "id": 203,
        "student_id": 42,
        "title": "Application Submitted",
        "message": "Your application has been successfully submitted.",
        "type": "success",
        "is_read": false,
        "created_at": "2024-02-18T15:45:30"
      }
    ],
    "count": 1,
    "unread_count": 1,
    "total": 15,
    "limit": 50,
    "offset": 0
  }
}
```

---

### 6. Update Notification
**Endpoint:** `POST /update-notification.php` or `PUT /update-notification.php`

**Description:** Mark notification as read/unread

**Required Fields:**
- `notification_id` (integer): Notification ID

**Optional Fields:**
- `is_read` (boolean): Mark as read (true/false, default: true)

**Example Request:**
```bash
curl -X POST http://localhost/jobnest/api/update-notification.php \
  -d "notification_id=203&is_read=true"
```

**Example Response:**
```json
{
  "success": true,
  "message": "Notification updated successfully",
  "data": {
    "id": 203,
    "is_read": true
  }
}
```

---

## Error Handling

### Common Error Codes
- `400`: Bad Request - Missing or invalid parameters
- `404`: Not Found - Resource doesn't exist
- `405`: Method Not Allowed - Wrong HTTP method
- `409`: Conflict - Duplicate application
- `422`: Validation Failed - Input validation errors
- `500`: Server Error - Database or file operation error

### Example Error Response
```json
{
  "success": false,
  "message": "Validation failed",
  "data": {
    "errors": [
      "Email is required",
      "Phone number must be 10 digits"
    ]
  }
}
```

---

## File Uploads

### Resume Upload
- **Location:** `uploads/resume_*.pdf|doc|docx`
- **Max Size:** 5MB
- **Allowed Formats:** PDF, DOC, DOCX
- **Naming:** Unique filename with timestamp: `resume_65c8d9a5e4a2c.pdf`

---

## Logging

All API activity is logged to `logs/api.log` for debugging and auditing:
- GET requests (successful)
- POST requests (successful)
- Errors with timestamps

---

## Security Considerations

1. **Input Validation:** All inputs are sanitized and validated
2. **File Upload Security:** Only specific file types allowed, size limited
3. **CORS:** Set to allow requests from any origin (configure as needed)
4. **Database:** Uses prepared statements to prevent SQL injection
5. **Transactions:** Multi-step operations use database transactions

---

## Development Tips

### Testing with cURL
```bash
# Get jobs
curl "http://localhost/jobnest/api/get-jobs.php?company=Google"

# Submit application
curl -F "name=John" -F "email=john@test.com" ... POST http://localhost/jobnest/api/submit-application.php

# Get notifications
curl "http://localhost/jobnest/api/get-notifications.php?student_id=1"
```

### Testing with Postman
1. Import the API endpoints
2. Set request type (GET/POST)
3. Add parameters in Params or Body tab
4. Send and view response

---

## Future Endpoints

Planned additions:
- `GET /get-analytics.php` - Dashboard analytics
- `POST /login.php` - Student login
- `POST /register.php` - Student registration
- `PUT /update-profile.php` - Update student profile
- `UPDATE /update-application-status.php` - Recruiter status updates
- `DELETE /delete-application.php` - Application withdrawal

---

**Last Updated:** February 18, 2024
**API Version:** 1.0
**Status:** Production Ready
