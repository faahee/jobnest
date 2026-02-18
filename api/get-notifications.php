<?php
/**
 * JobNest API - Get Notifications
 * Returns notifications for a student
 * GET Parameters: ?student_id=1&unread_only=false&limit=50&offset=0
 */

require_once '../config.php';

try {
    // Get filter parameters
    $student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : null;
    $unread_only = isset($_GET['unread_only']) ? $_GET['unread_only'] === 'true' : false;
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 50;
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
    
    // Validate limits
    $limit = min($limit, 100);
    $offset = max($offset, 0);
    
    if (!$student_id) {
        sendError('Student ID is required', 400);
    }
    
    // Build query
    $query = "SELECT 
        id,
        student_id,
        title,
        message,
        type,
        is_read,
        created_at
    FROM notifications
    WHERE student_id = :student_id";
    
    $params = [':student_id' => $student_id];
    
    // Add unread filter if requested
    if ($unread_only) {
        $query .= " AND is_read = 0";
    }
    
    $query .= " ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
    
    $stmt = $pdo->prepare($query);
    
    // Bind parameters
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    
    $stmt->execute();
    $notifications = $stmt->fetchAll();
    
    // Get unread count
    $countStmt = $pdo->prepare("
        SELECT COUNT(*) as unread_count 
        FROM notifications 
        WHERE student_id = :student_id AND is_read = 0
    ");
    $countStmt->bindValue(':student_id', $student_id);
    $countStmt->execute();
    $unreadResult = $countStmt->fetch();
    $unread_count = $unreadResult['unread_count'] ?? 0;
    
    // Get total notifications count
    $totalStmt = $pdo->prepare("
        SELECT COUNT(*) as total 
        FROM notifications 
        WHERE student_id = :student_id
    ");
    $totalStmt->bindValue(':student_id', $student_id);
    $totalStmt->execute();
    $totalResult = $totalStmt->fetch();
    $total = $totalResult['total'] ?? 0;
    
    logActivity('GET_NOTIFICATIONS', [
        'student_id' => $student_id,
        'unread_only' => $unread_only,
        'count' => count($notifications),
        'unread_count' => $unread_count
    ]);
    
    sendSuccess([
        'notifications' => $notifications,
        'count' => count($notifications),
        'unread_count' => $unread_count,
        'total' => $total,
        'limit' => $limit,
        'offset' => $offset
    ], 'Notifications retrieved successfully');
    
} catch(Exception $e) {
    logActivity('GET_NOTIFICATIONS_ERROR', ['error' => $e->getMessage()]);
    sendError('Failed to retrieve notifications: ' . $e->getMessage(), 500);
}
?>
