<?php
/**
 * JobNest API - Submit Application
 * POST endpoint to submit job application
 * Required POST fields: name, email, phone, roll_number, department, cgpa, job_id, resume, cover_letter, portfolio_url
 */

require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendError('Invalid request method. POST required.', 405);
}

try {
    // Get POST data
    $name = isset($_POST['name']) ? sanitizeInput($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitizeInput($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? sanitizeInput($_POST['phone']) : '';
    $roll_number = isset($_POST['roll_number']) ? sanitizeInput($_POST['roll_number']) : '';
    $department = isset($_POST['department']) ? sanitizeInput($_POST['department']) : '';
    $cgpa = isset($_POST['cgpa']) ? floatval($_POST['cgpa']) : 0;
    $job_id = isset($_POST['job_id']) ? intval($_POST['job_id']) : 0;
    $cover_letter = isset($_POST['cover_letter']) ? sanitizeInput($_POST['cover_letter']) : '';
    $portfolio_url = isset($_POST['portfolio_url']) ? sanitizeInput($_POST['portfolio_url']) : '';
    $resume_file = $_FILES['resume'] ?? null;
    
    // Validation
    $errors = [];
    
    if (empty($name) || strlen($name) < 2) {
        $errors[] = 'Name is required (minimum 2 characters)';
    }
    if (!validateEmail($email)) {
        $errors[] = 'Valid email is required';
    }
    if (!validatePhone($phone)) {
        $errors[] = 'Valid 10-digit phone number is required';
    }
    if (empty($roll_number)) {
        $errors[] = 'Roll number is required';
    }
    if (empty($department)) {
        $errors[] = 'Department is required';
    }
    if (!validateCGPA($cgpa)) {
        $errors[] = 'CGPA must be between 0 and 10';
    }
    if ($job_id <= 0) {
        $errors[] = 'Valid job ID is required';
    }
    
    // Validate resume file
    if (!$resume_file || $resume_file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Resume file is required';
    } else if (!validateResumeFile($resume_file['name'])) {
        $errors[] = 'Resume must be PDF or DOC/DOCX format';
    } else if ($resume_file['size'] > 5242880) { // 5MB
        $errors[] = 'Resume file size must be less than 5MB';
    }
    
    // Return validation errors if any
    if (!empty($errors)) {
        sendError('Validation failed', 422, ['errors' => $errors]);
    }
    
    // Verify job exists
    $jobStmt = $pdo->prepare("SELECT id FROM jobs WHERE id = :job_id");
    $jobStmt->bindValue(':job_id', $job_id);
    $jobStmt->execute();
    if (!$jobStmt->fetch()) {
        sendError('Invalid job ID', 404);
    }
    
    // Start transaction
    $pdo->beginTransaction();
    
    // Create uploads directory if it doesn't exist
    $upload_dir = __DIR__ . '/../uploads/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    // Move uploaded file
    $resume_filename = generateUniqueFilename($resume_file['name']);
    $resume_path = $upload_dir . $resume_filename;
    
    if (!move_uploaded_file($resume_file['tmp_name'], $resume_path)) {
        $pdo->rollBack();
        sendError('Failed to upload resume file', 500);
    }
    
    // Check if student exists by email and roll number
    $studentStmt = $pdo->prepare("SELECT id FROM students WHERE email = :email OR roll_number = :roll_number");
    $studentStmt->bindValue(':email', $email);
    $studentStmt->bindValue(':roll_number', $roll_number);
    $studentStmt->execute();
    $student = $studentStmt->fetch();
    
    if ($student) {
        // Update existing student
        $student_id = $student['id'];
        $updateStmt = $pdo->prepare("
            UPDATE students 
            SET name = :name, phone = :phone, department = :department, cgpa = :cgpa, updated_at = NOW()
            WHERE id = :id
        ");
        $updateStmt->bindValue(':name', $name);
        $updateStmt->bindValue(':phone', $phone);
        $updateStmt->bindValue(':department', $department);
        $updateStmt->bindValue(':cgpa', $cgpa);
        $updateStmt->bindValue(':id', $student_id);
        $updateStmt->execute();
    } else {
        // Create new student
        $insertStmt = $pdo->prepare("
            INSERT INTO students (name, email, phone, roll_number, department, cgpa, resume_name)
            VALUES (:name, :email, :phone, :roll_number, :department, :cgpa, :resume_name)
        ");
        $insertStmt->bindValue(':name', $name);
        $insertStmt->bindValue(':email', $email);
        $insertStmt->bindValue(':phone', $phone);
        $insertStmt->bindValue(':roll_number', $roll_number);
        $insertStmt->bindValue(':department', $department);
        $insertStmt->bindValue(':cgpa', $cgpa);
        $insertStmt->bindValue(':resume_name', $resume_filename);
        $insertStmt->execute();
        
        $student_id = $pdo->lastInsertId();
    }
    
    // Check if already applied
    $checkAppliedStmt = $pdo->prepare("
        SELECT id FROM applications 
        WHERE student_id = :student_id AND job_id = :job_id
    ");
    $checkAppliedStmt->bindValue(':student_id', $student_id);
    $checkAppliedStmt->bindValue(':job_id', $job_id);
    $checkAppliedStmt->execute();
    
    if ($checkAppliedStmt->fetch()) {
        // Delete the uploaded file since student already applied
        unlink($resume_path);
        $pdo->rollBack();
        sendError('You have already applied for this job', 409);
    }
    
    // Create application
    $appStmt = $pdo->prepare("
        INSERT INTO applications (student_id, job_id, resume_filename, cover_letter, portfolio_url, status)
        VALUES (:student_id, :job_id, :resume_filename, :cover_letter, :portfolio_url, 'Pending')
    ");
    $appStmt->bindValue(':student_id', $student_id);
    $appStmt->bindValue(':job_id', $job_id);
    $appStmt->bindValue(':resume_filename', $resume_filename);
    $appStmt->bindValue(':cover_letter', $cover_letter);
    $appStmt->bindValue(':portfolio_url', $portfolio_url);
    $appStmt->execute();
    
    $application_id = $pdo->lastInsertId();
    
    // Create notification
    $notifStmt = $pdo->prepare("
        INSERT INTO notifications (student_id, title, message, type)
        VALUES (:student_id, :title, :message, :type)
    ");
    $notifStmt->bindValue(':student_id', $student_id);
    $notifStmt->bindValue(':title', 'Application Submitted');
    $notifStmt->bindValue(':message', 'Your application has been successfully submitted. You will be notified once the recruiter reviews it.');
    $notifStmt->bindValue(':type', 'success');
    $notifStmt->execute();
    
    // Commit transaction
    $pdo->commit();
    
    logActivity('APPLICATION_SUBMITTED', [
        'student_id' => $student_id,
        'job_id' => $job_id,
        'application_id' => $application_id,
        'email' => $email,
        'roll_number' => $roll_number
    ]);
    
    sendSuccess([
        'student_id' => $student_id,
        'application_id' => $application_id,
        'resume_filename' => $resume_filename
    ], 'Application submitted successfully');
    
} catch(Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    logActivity('APPLICATION_SUBMIT_ERROR', ['error' => $e->getMessage()]);
    sendError('Failed to submit application: ' . $e->getMessage(), 500);
}
?>
