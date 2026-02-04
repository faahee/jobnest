<?php
require_once 'config.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT * FROM jobs ORDER BY created_at DESC");
    $jobs = $stmt->fetchAll();
    
    echo json_encode(['success' => true, 'jobs' => $jobs]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>
