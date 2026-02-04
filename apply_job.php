<?php
require_once 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jobId = filter_input(INPUT_POST, 'job_id', FILTER_SANITIZE_NUMBER_INT);

    if (empty($jobId)) {
        echo json_encode(['success' => false, 'message' => 'Job ID is required']);
        exit;
    }

    try {
        // Check if already applied
        $stmt = $pdo->prepare("SELECT id FROM applications WHERE user_id = ? AND job_id = ?");
        $stmt->execute([$_SESSION['user_id'], $jobId]);
        
        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Already applied to this job']);
            exit;
        }

        // Apply for job
        $stmt = $pdo->prepare("INSERT INTO applications (user_id, job_id) VALUES (?, ?)");
        $stmt->execute([$_SESSION['user_id'], $jobId]);

        echo json_encode(['success' => true, 'message' => 'Application submitted successfully']);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
