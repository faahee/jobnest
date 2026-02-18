<?php
// JobNest Database Configuration & Helper Functions
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration
$host = 'localhost';
$dbname = 'jobnest';
$username = 'root';
$password = '';

// Create PDO connection
try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4", 
        $username, 
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch(PDOException $e) {
    http_response_code(500);
    die(json_encode([
        'success' => false,
        'message' => 'Database connection failed',
        'error' => $e->getMessage()
    ]));
}

session_start();

// ===== HELPER FUNCTIONS =====

/**
 * Send JSON success response
 */
function sendSuccess($data = [], $message = 'Operation successful') {
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

/**
 * Send JSON error response
 */
function sendError($message = 'Operation failed', $statusCode = 400, $data = []) {
    http_response_code($statusCode);
    echo json_encode([
        'success' => false,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

/**
 * Sanitize string input
 */
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate email
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate phone number (10 digits)
 */
function validatePhone($phone) {
    return preg_match('/^[0-9]{10}$/', preg_replace('/[^0-9]/', '', $phone));
}

/**
 * Validate CGPA (0-10)
 */
function validateCGPA($cgpa) {
    $cgpa = floatval($cgpa);
    return $cgpa >= 0 && $cgpa <= 10;
}

/**
 * Get file extension
 */
function getFileExtension($filename) {
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

/**
 * Validate resume file
 */
function validateResumeFile($filename) {
    $allowed = ['pdf', 'doc', 'docx'];
    $ext = getFileExtension($filename);
    return in_array($ext, $allowed);
}

/**
 * Generate unique filename for uploads
 */
function generateUniqueFilename($originalName) {
    $extension = getFileExtension($originalName);
    return uniqid('resume_', true) . '.' . $extension;
}

/**
 * Log API activity
 */
function logActivity($action, $details = []) {
    $log_file = __DIR__ . '/logs/api.log';
    if (!file_exists(__DIR__ . '/logs')) {
        mkdir(__DIR__ . '/logs', 0755, true);
    }
    $log_entry = date('Y-m-d H:i:s') . ' | ' . $action . ' | ' . json_encode($details) . PHP_EOL;
    file_put_contents($log_file, $log_entry, FILE_APPEND);
}
?>
