<?php
require_once 'config.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT id, name, email, company FROM users WHERE role = 'recruiter' ORDER BY name ASC");
    $recruiters = $stmt->fetchAll();
    
    echo json_encode(['success' => true, 'recruiters' => $recruiters]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>
