<?php
/**
 * JobNest API - Get Recruiters
 * Returns list of all active recruiters
 * GET Parameters: ?status=active&limit=50&offset=0
 */

require_once '../config.php';

try {
    // Get filter parameters
    $status = isset($_GET['status']) ? sanitizeInput($_GET['status']) : 'active';
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 50;
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
    
    // Validate limits
    $limit = min($limit, 100);
    $offset = max($offset, 0);
    
    // Build query
    $query = "SELECT 
        r.id,
        r.name,
        r.email,
        r.company,
        r.website,
        r.phone,
        r.designation,
        COUNT(j.id) as total_jobs,
        (SELECT COUNT(*) FROM applications a 
         INNER JOIN jobs j2 ON a.job_id = j2.id 
         WHERE j2.recruiter_id = r.id) as total_applications
    FROM recruiters r
    LEFT JOIN jobs j ON r.id = j.recruiter_id
    WHERE r.status = :status
    GROUP BY r.id
    ORDER BY r.name ASC
    LIMIT :limit OFFSET :offset";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':status', $status);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    $recruiters = $stmt->fetchAll();
    
    // Get total count
    $countQuery = "SELECT COUNT(*) as total FROM recruiters WHERE status = :status";
    $countStmt = $pdo->prepare($countQuery);
    $countStmt->bindValue(':status', $status);
    $countStmt->execute();
    $count = $countStmt->fetch();
    
    logActivity('GET_RECRUITERS', ['count' => count($recruiters)]);
    
    sendSuccess([
        'recruiters' => $recruiters,
        'count' => count($recruiters),
        'total' => $count['total'],
        'limit' => $limit,
        'offset' => $offset
    ], 'Recruiters retrieved successfully');
    
} catch(Exception $e) {
    logActivity('GET_RECRUITERS_ERROR', ['error' => $e->getMessage()]);
    sendError('Failed to retrieve recruiters: ' . $e->getMessage(), 500);
}
?>
