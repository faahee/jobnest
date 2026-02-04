<?php
require_once 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

try {
    $stmt = $pdo->prepare("
        SELECT a.id, a.status, a.applied_at, j.company, j.position, j.location, j.salary
        FROM applications a
        JOIN jobs j ON a.job_id = j.id
        WHERE a.user_id = ?
        ORDER BY a.applied_at DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $applications = $stmt->fetchAll();
    
    echo json_encode(['success' => true, 'applications' => $applications]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>
