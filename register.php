<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING) ?? '';

    if (empty($email) || empty($password) || empty($role) || empty($name)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format']);
        exit;
    }

    if (strlen($password) < 6) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters']);
        exit;
    }

    try {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Email already registered']);
            exit;
        }

        // Hash password and insert user
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (email, password, role, name) VALUES (?, ?, ?, ?)");
        $stmt->execute([$email, $hashedPassword, $role, $name]);

        echo json_encode(['success' => true, 'message' => 'Registration successful']);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
