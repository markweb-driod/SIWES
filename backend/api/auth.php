<?php
require_once '../config/db.php';
require_once '../config/session.php';
require_once '../models/User.php';

// Handle both JSON and form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [];
    
    // Check if it's JSON request
    $content_type = $_SERVER['CONTENT_TYPE'] ?? '';
    if (strpos($content_type, 'application/json') !== false) {
        $data = json_decode(file_get_contents('php://input'), true);
    } else {
        // Handle form data
        $data = $_POST;
    }
    
    $action = $data['action'] ?? '';
    
    if ($action === 'login') {
        $email = $data['email'];
        $password = $data['password'];
        $role = $data['role'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND role = ?");
        $stmt->execute([$email, $role]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];
            
            // Redirect based on role
            switch ($role) {
                case 'student':
                    header('Location: ../../student/dashboard.php');
                    break;
                case 'supervisor':
                    header('Location: ../../supervisor/dashboard.php');
                    break;
                case 'admin':
                    header('Location: ../../admin/dashboard.php');
                    break;
                default:
                    header('Location: ../../index.php');
            }
            exit();
        } else {
            // Redirect back with error
            $error = urlencode('Invalid credentials');
            switch ($role) {
                case 'student':
                    header('Location: ../../student/login.php?error=' . $error);
                    break;
                case 'supervisor':
                    header('Location: ../../supervisor/login.php?error=' . $error);
                    break;
                case 'admin':
                    header('Location: ../../admin/login.php?error=' . $error);
                    break;
                default:
                    header('Location: ../../index.php?error=' . $error);
            }
            exit();
        }
    }
    
    if ($action === 'logout') {
        session_destroy();
        header('Location: ../../index.php');
        exit();
    }
}

// Handle JSON API requests
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$data = json_decode(file_get_contents('php://input'), true);

if ($data['action'] === 'register') {
    // Registration logic (students only)
    $user = User::findByEmail($pdo, $data['email']);
    if ($user) {
        echo json_encode(['success' => false, 'message' => 'Email already exists']);
        exit;
    }
    
    $ok = User::create($pdo, [
        'name' => $data['name'],
        'email' => $data['email'],
        'matric_number' => $data['matric_number'],
        'department' => $data['department'],
        'institution' => $data['institution'],
        'password' => $data['password'],
        'role' => 'student'
    ]);
    
    if ($ok) {
        echo json_encode(['success' => true, 'message' => 'Registration successful']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Registration failed']);
    }
    exit;
}

if ($data['action'] === 'login') {
    $email = $data['email'];
    $password = $data['password'];
    $role = $data['role'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND role = ?");
    $stmt->execute([$email, $role]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['name'];
        
        echo json_encode([
            'success' => true, 
            'role' => $user['role'],
            'name' => $user['name'],
            'message' => 'Login successful'
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
    }
    exit;
}

if ($data['action'] === 'logout') {
    session_destroy();
    echo json_encode(['success' => true, 'message' => 'Logged out successfully']);
    exit;
}

if ($data['action'] === 'check_auth') {
    if (isLoggedIn()) {
        echo json_encode([
            'success' => true,
            'user_id' => $_SESSION['user_id'],
            'role' => $_SESSION['role'],
            'name' => $_SESSION['name']
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid action']);
?> 