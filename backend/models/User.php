<?php
class User {
    public static function findByEmail($pdo, $email) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    
    public static function findById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public static function create($pdo, $data) {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, matric_number, department, institution, password_hash, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['name'], 
            $data['email'], 
            $data['matric_number'], 
            $data['department'],
            $data['institution'], 
            password_hash($data['password'], PASSWORD_DEFAULT), 
            $data['role']
        ]);
    }
    
    public static function getAllStudents($pdo) {
        $stmt = $pdo->prepare("SELECT id, name, email, matric_number, department, institution FROM users WHERE role = 'student'");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public static function getAllSupervisors($pdo) {
        $stmt = $pdo->prepare("SELECT id, name, email, department, institution FROM users WHERE role = 'supervisor'");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public static function updateProfile($pdo, $userId, $data) {
        $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, department = ?, institution = ? WHERE id = ?");
        return $stmt->execute([
            $data['name'],
            $data['email'],
            $data['department'],
            $data['institution'],
            $userId
        ]);
    }
    
    public static function changePassword($pdo, $userId, $newPassword) {
        $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        return $stmt->execute([
            password_hash($newPassword, PASSWORD_DEFAULT),
            $userId
        ]);
    }
}
?> 