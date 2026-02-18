<?php
/**
 * JobNest API - Get Applications
 * Returns applications for a student or all applications (admin)
 * GET Parameters: ?student_id=1&job_id=1&status=Pending&limit=20&offset=0
 */

require_once '../config.php';

try {
    // Get filter parameters
    $student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : null;
    $job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : null;
    $status = isset($_GET['status']) ? sanitizeInput($_GET['status']) : null;
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 50;
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
    
    // Validate limits
    $limit = min($limit, 100);
    $offset = max($offset, 0);
    
    // Build query
    $query = "SELECT 
        a.id,
        a.student_id,
        a.job_id,
        a.resume_filename,
        a.cover_letter,
        a.portfolio_url,
        a.applied_at,
        a.status,
        a.notes,
        s.name as student_name,
        s.email as student_email,
        s.roll_number,
        s.department,
        s.cgpa,
        j.company,
        j.position,
        j.location,
        j.salary
    FROM applications a
    INNER JOIN students s ON a.student_id = s.id
    INNER JOIN jobs j ON a.job_id = j.id
    WHERE 1=1";
    
    $params = [];
    
    // Add filters
    if ($student_id) {
        $query .= " AND a.student_id = :student_id";
        $params[':student_id'] = $student_id;
    }
    
    if ($job_id) {
        $query .= " AND a.job_id = :job_id";
        $params[':job_id'] = $job_id;
    }
    
    if ($status) {
        $query .= " AND a.status = :status";
        $params[':status'] = $status;
    }
    
    $query .= " ORDER BY a.applied_at DESC LIMIT :limit OFFSET :offset";
    
    $stmt = $pdo->prepare($query);
    
    // Bind parameters
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    
    $stmt->execute();
    $applications = $stmt->fetchAll();
    
    // Get total count
    $countQuery = "SELECT COUNT(*) as total FROM applications a WHERE 1=1";
    if ($student_id) {
        $countQuery .= " AND a.student_id = :student_id";
    }
    if ($job_id) {
        $countQuery .= " AND a.job_id = :job_id";
    }
    if ($status) {
        $countQuery .= " AND a.status = :status";
    }
    
    $countStmt = $pdo->prepare($countQuery);
    foreach ($params as $key => $value) {
        $countStmt->bindValue($key, $value);
    }
    $countStmt->execute();
    $count = $countStmt->fetch();
    
    logActivity('GET_APPLICATIONS', [
        'student_id' => $student_id,
        'job_id' => $job_id,
        'status' => $status,
        'count' => count($applications)
    ]);
    
    sendSuccess([
        'applications' => $applications,
        'count' => count($applications),
        'total' => $count['total'],
        'limit' => $limit,
        'offset' => $offset
    ], 'Applications retrieved successfully');
    
} catch(Exception $e) {
    logActivity('GET_APPLICATIONS_ERROR', ['error' => $e->getMessage()]);
    sendError('Failed to retrieve applications: ' . $e->getMessage(), 500);
}
?>
