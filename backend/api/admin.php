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

requireRole('admin');

$data = json_decode(file_get_contents('php://input'), true);

if ($data['action'] === 'dashboard') {
    $user = User::findById($pdo, $_SESSION['user_id']);
    $stats = LogEntry::getStatsForAdmin($pdo);
    $students = User::getAllStudents($pdo);
    $supervisors = User::getAllSupervisors($pdo);
    
    echo json_encode([
        'success' => true,
        'name' => $user['name'],
        'stats' => $stats,
        'students' => $students,
        'supervisors' => $supervisors
    ]);
    exit;
}

if ($data['action'] === 'get_all_logs') {
    $logs = LogEntry::getAll($pdo);
    echo json_encode(['success' => true, 'logs' => $logs]);
    exit;
}

if ($data['action'] === 'get_all_students') {
    $students = User::getAllStudents($pdo);
    echo json_encode(['success' => true, 'students' => $students]);
    exit;
}

if ($data['action'] === 'get_all_supervisors') {
    $supervisors = User::getAllSupervisors($pdo);
    echo json_encode(['success' => true, 'supervisors' => $supervisors]);
    exit;
}

if ($data['action'] === 'add_user') {
    $ok = User::create($pdo, [
        'name' => $data['name'],
        'email' => $data['email'],
        'matric_number' => $data['matric_number'] ?? null,
        'department' => $data['department'],
        'institution' => $data['institution'],
        'password' => $data['password'],
        'role' => $data['role']
    ]);
    
    if ($ok) {
        echo json_encode(['success' => true, 'message' => 'User added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add user']);
    }
    exit;
}

if ($data['action'] === 'delete_user') {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $ok = $stmt->execute([$data['user_id']]);
    
    if ($ok) {
        echo json_encode(['success' => true, 'message' => 'User deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete user']);
    }
    exit;
}

if ($data['action'] === 'get_logs_by_department') {
    $stmt = $pdo->prepare("
        SELECT le.*, u.name as student_name, u.matric_number, u.department
        FROM log_entries le 
        JOIN users u ON le.student_id = u.id 
        WHERE u.department = ?
        ORDER BY le.date DESC
    ");
    $stmt->execute([$data['department']]);
    $logs = $stmt->fetchAll();
    echo json_encode(['success' => true, 'logs' => $logs]);
    exit;
}

if ($data['action'] === 'get_logs_by_date_range') {
    $stmt = $pdo->prepare("
        SELECT le.*, u.name as student_name, u.matric_number, u.department
        FROM log_entries le 
        JOIN users u ON le.student_id = u.id 
        WHERE le.date BETWEEN ? AND ?
        ORDER BY le.date DESC
    ");
    $stmt->execute([$data['start_date'], $data['end_date']]);
    $logs = $stmt->fetchAll();
    echo json_encode(['success' => true, 'logs' => $logs]);
    exit;
}

if ($data['action'] === 'admin_override_log') {
    $ok = LogEntry::updateStatus($pdo, $data['log_id'], $data['status'], $_SESSION['user_id'], $data['comment']);
    
    if ($ok) {
        echo json_encode(['success' => true, 'message' => 'Log status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update log status']);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid action']);
?> 