<?php
class LogEntry {
    public static function create($pdo, $data) {
        $stmt = $pdo->prepare("INSERT INTO log_entries (student_id, activity, date, latitude, longitude, status) VALUES (?, ?, ?, ?, ?, 'pending')");
        return $stmt->execute([
            $data['student_id'],
            $data['activity'],
            $data['date'],
            $data['latitude'],
            $data['longitude']
        ]);
    }
    
    public static function getByStudentId($pdo, $studentId) {
        $stmt = $pdo->prepare("
            SELECT le.*, u.name as student_name 
            FROM log_entries le 
            JOIN users u ON le.student_id = u.id 
            WHERE le.student_id = ? 
            ORDER BY le.date DESC
        ");
        $stmt->execute([$studentId]);
        return $stmt->fetchAll();
    }
    
    public static function getPendingForSupervisor($pdo, $supervisorId) {
        $stmt = $pdo->prepare("
            SELECT le.*, u.name as student_name, u.matric_number, u.department
            FROM log_entries le 
            JOIN users u ON le.student_id = u.id 
            WHERE le.status = 'pending'
            ORDER BY le.date DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public static function getAll($pdo) {
        $stmt = $pdo->prepare("
            SELECT le.*, u.name as student_name, u.matric_number, u.department
            FROM log_entries le 
            JOIN users u ON le.student_id = u.id 
            ORDER BY le.date DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public static function updateStatus($pdo, $logId, $status, $supervisorId, $comment = null) {
        $stmt = $pdo->prepare("UPDATE log_entries SET status = ?, supervisor_id = ?, supervisor_comment = ? WHERE id = ?");
        return $stmt->execute([$status, $supervisorId, $comment, $logId]);
    }
    
    public static function getById($pdo, $logId) {
        $stmt = $pdo->prepare("
            SELECT le.*, u.name as student_name, u.matric_number, u.department
            FROM log_entries le 
            JOIN users u ON le.student_id = u.id 
            WHERE le.id = ?
        ");
        $stmt->execute([$logId]);
        return $stmt->fetch();
    }
    
    public static function getStatsByStudent($pdo, $studentId) {
        $stmt = $pdo->prepare("
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
                SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending
            FROM log_entries 
            WHERE student_id = ?
        ");
        $stmt->execute([$studentId]);
        return $stmt->fetch();
    }
    
    public static function getStatsForAdmin($pdo) {
        $stmt = $pdo->prepare("
            SELECT 
                COUNT(*) as total_logs,
                COUNT(DISTINCT student_id) as total_students,
                SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
                SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending
            FROM log_entries
        ");
        $stmt->execute();
        return $stmt->fetch();
    }
}
?> 