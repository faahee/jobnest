<?php
/**
 * JobNest API - Get Jobs
 * Returns list of all active jobs or filtered jobs
 * GET Parameters: ?status=active&company=Google&limit=10&offset=0
 */

require_once '../config.php';

try {
    // Get filter parameters
    $status = isset($_GET['status']) ? sanitizeInput($_GET['status']) : 'active';
    $company = isset($_GET['company']) ? sanitizeInput($_GET['company']) : null;
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 50;
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
    
    // Validate limits
    $limit = min($limit, 100);
    $offset = max($offset, 0);
    
    // Build query
    $query = "SELECT 
        j.id, 
        j.company, 
        j.position, 
        j.location, 
        j.salary, 
        j.recruiter_name, 
        j.website, 
        j.openings, 
        j.description, 
        j.requirements, 
        j.posted_at, 
        COUNT(a.id) as total_applications,
        (SELECT COUNT(*) FROM applications WHERE job_id = j.id AND status = 'Accepted') as accepted_count
    FROM jobs j
    LEFT JOIN applications a ON j.id = a.job_id
    WHERE j.status = :status";
    
    $params = [':status' => $status];
    
    // Add company filter if provided
    if ($company) {
        $query .= " AND j.company LIKE :company";
        $params[':company'] = "%$company%";
    }
    
    $query .= " GROUP BY j.id ORDER BY j.posted_at DESC LIMIT :limit OFFSET :offset";
    
    $stmt = $pdo->prepare($query);
    
    // Bind parameters
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    
    $stmt->execute();
    $jobs = $stmt->fetchAll();
    
    // Get total count
    $countQuery = "SELECT COUNT(*) as total FROM jobs WHERE status = :status";
    if ($company) {
        $countQuery .= " AND company LIKE :company";
    }
    
    $countStmt = $pdo->prepare($countQuery);
    $countStmt->bindValue(':status', $status);
    if ($company) {
        $countStmt->bindValue(':company', "%$company%");
    }
    $countStmt->execute();
    $count = $countStmt->fetch();
    
    logActivity('GET_JOBS', ['status' => $status, 'company' => $company, 'count' => count($jobs)]);
    
    sendSuccess([
        'jobs' => $jobs,
        'count' => count($jobs),
        'total' => $count['total'],
        'limit' => $limit,
        'offset' => $offset
    ], 'Jobs retrieved successfully');
    
} catch(Exception $e) {
    logActivity('GET_JOBS_ERROR', ['error' => $e->getMessage()]);
    sendError('Failed to retrieve jobs: ' . $e->getMessage(), 500);
}
?>
