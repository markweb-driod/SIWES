<?php
require_once '../config/db.php';
require_once '../config/session.php';
require_once '../models/User.php';
require_once '../models/LogEntry.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

requireRole('student');

$data = json_decode(file_get_contents('php://input'), true);

if ($data['action'] === 'dashboard') {
    $user = User::findById($pdo, $_SESSION['user_id']);
    $stats = LogEntry::getStatsByStudent($pdo, $_SESSION['user_id']);
    
    echo json_encode([
        'success' => true,
        'name' => $user['name'],
        'stats' => $stats
    ]);
    exit;
}

if ($data['action'] === 'add_log') {
    $ok = LogEntry::create($pdo, [
        'student_id' => $_SESSION['user_id'],
        'activity' => $data['activity'],
        'date' => $data['date'],
        'latitude' => $data['latitude'],
        'longitude' => $data['longitude']
    ]);
    
    if ($ok) {
        echo json_encode(['success' => true, 'message' => 'Log entry added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add log entry']);
    }
    exit;
}

if ($data['action'] === 'get_logs') {
    $logs = LogEntry::getByStudentId($pdo, $_SESSION['user_id']);
    echo json_encode(['success' => true, 'logs' => $logs]);
    exit;
}

if ($data['action'] === 'get_profile') {
    $user = User::findById($pdo, $_SESSION['user_id']);
    unset($user['password_hash']); // Don't send password hash
    echo json_encode(['success' => true, 'profile' => $user]);
    exit;
}

if ($data['action'] === 'update_profile') {
    $ok = User::updateProfile($pdo, $_SESSION['user_id'], [
        'name' => $data['name'],
        'email' => $data['email'],
        'department' => $data['department'],
        'institution' => $data['institution']
    ]);
    
    if ($ok) {
        $_SESSION['name'] = $data['name'];
        echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update profile']);
    }
    exit;
}

if ($data['action'] === 'change_password') {
    $user = User::findById($pdo, $_SESSION['user_id']);
    
    if (!password_verify($data['current_password'], $user['password_hash'])) {
        echo json_encode(['success' => false, 'message' => 'Current password is incorrect']);
        exit;
    }
    
    $ok = User::changePassword($pdo, $_SESSION['user_id'], $data['new_password']);
    
    if ($ok) {
        echo json_encode(['success' => true, 'message' => 'Password changed successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to change password']);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid action']);
?> 