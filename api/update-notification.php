<?php
/**
 * JobNest API - Update Notification
 * Mark notification as read
 * PUT/POST Parameters: notification_id (required), is_read (optional, default true)
 */

require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'PUT') {
    sendError('Invalid request method. POST or PUT required.', 405);
}

try {
    // Get data
    $data = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : json_decode(file_get_contents('php://input'), true);
    
    $notification_id = isset($data['notification_id']) ? intval($data['notification_id']) : 0;
    $is_read = isset($data['is_read']) ? (bool)$data['is_read'] : true;
    
    if ($notification_id <= 0) {
        sendError('Notification ID is required', 400);
    }
    
    // Update notification
    $stmt = $pdo->prepare("
        UPDATE notifications 
        SET is_read = :is_read 
        WHERE id = :id
    ");
    $stmt->bindValue(':is_read', $is_read ? 1 : 0);
    $stmt->bindValue(':id', $notification_id);
    $stmt->execute();
    
    if ($stmt->rowCount() === 0) {
        sendError('Notification not found', 404);
    }
    
    logActivity('UPDATE_NOTIFICATION', [
        'notification_id' => $notification_id,
        'is_read' => $is_read
    ]);
    
    sendSuccess([
        'id' => $notification_id,
        'is_read' => $is_read
    ], 'Notification updated successfully');
    
} catch(Exception $e) {
    logActivity('UPDATE_NOTIFICATION_ERROR', ['error' => $e->getMessage()]);
    sendError('Failed to update notification: ' . $e->getMessage(), 500);
}
?>
