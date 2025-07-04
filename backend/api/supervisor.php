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

requireRole('supervisor');

$data = json_decode(file_get_contents('php://input'), true);

if ($data['action'] === 'dashboard') {
    $user = User::findById($pdo, $_SESSION['user_id']);
    $pendingLogs = LogEntry::getPendingForSupervisor($pdo, $_SESSION['user_id']);
    
    echo json_encode([
        'success' => true,
        'name' => $user['name'],
        'pending_logs' => $pendingLogs
    ]);
    exit;
}

if ($data['action'] === 'get_pending_logs') {
    $logs = LogEntry::getPendingForSupervisor($pdo, $_SESSION['user_id']);
    echo json_encode(['success' => true, 'logs' => $logs]);
    exit;
}

if ($data['action'] === 'get_log_details') {
    $log = LogEntry::getById($pdo, $data['log_id']);
    if ($log) {
        echo json_encode(['success' => true, 'log' => $log]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Log not found']);
    }
    exit;
}

if ($data['action'] === 'approve_log') {
    $ok = LogEntry::updateStatus($pdo, $data['log_id'], 'approved', $_SESSION['user_id'], $data['comment']);
    
    if ($ok) {
        echo json_encode(['success' => true, 'message' => 'Log approved successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to approve log']);
    }
    exit;
}

if ($data['action'] === 'reject_log') {
    $ok = LogEntry::updateStatus($pdo, $data['log_id'], 'rejected', $_SESSION['user_id'], $data['comment']);
    
    if ($ok) {
        echo json_encode(['success' => true, 'message' => 'Log rejected successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to reject log']);
    }
    exit;
}

if ($data['action'] === 'get_profile') {
    $user = User::findById($pdo, $_SESSION['user_id']);
    unset($user['password_hash']);
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

echo json_encode(['success' => false, 'message' => 'Invalid action']);
?> 