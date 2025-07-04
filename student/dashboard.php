<?php
session_start();
require_once '../backend/config/db.php';
require_once '../backend/config/session.php';

// Check authentication
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['name'];

// Get student statistics
$stmt = $pdo->prepare("SELECT COUNT(*) as total_logs FROM log_entries WHERE student_id = ?");
$stmt->execute([$user_id]);
$total_logs = $stmt->fetch()['total_logs'];

$stmt = $pdo->prepare("SELECT COUNT(*) as pending_logs FROM log_entries WHERE student_id = ? AND status = 'pending'");
$stmt->execute([$user_id]);
$pending_logs = $stmt->fetch()['pending_logs'];

$stmt = $pdo->prepare("SELECT COUNT(*) as approved_logs FROM log_entries WHERE student_id = ? AND status = 'approved'");
$stmt->execute([$user_id]);
$approved_logs = $stmt->fetch()['approved_logs'];

$stmt = $pdo->prepare("SELECT COUNT(*) as rejected_logs FROM log_entries WHERE student_id = ? AND status = 'rejected'");
$stmt->execute([$user_id]);
$rejected_logs = $stmt->fetch()['rejected_logs'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - SIWES Logbook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar-brand {
            font-weight: bold;
        }
        .stats-card {
            transition: transform 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .quick-action {
            transition: all 0.3s ease;
        }
        .quick-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-graduation-cap me-2"></i>Student Portal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="log-entry.php">
                            <i class="fas fa-plus me-1"></i>Add Log Entry
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="history.php">
                            <i class="fas fa-history me-1"></i>History
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">
                            <i class="fas fa-user me-1"></i>Profile
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i><?php echo htmlspecialchars($user_name); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="profile.php">Profile Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../backend/api/auth.php?action=logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Welcome back, <?php echo htmlspecialchars($user_name); ?>!</h2>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card stats-card bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                        <h5 class="card-title">Total Logs</h5>
                        <h3 class="card-text"><?php echo $total_logs; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card stats-card bg-warning text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-clock fa-2x mb-2"></i>
                        <h5 class="card-title">Pending</h5>
                        <h3 class="card-text"><?php echo $pending_logs; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card stats-card bg-success text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-2x mb-2"></i>
                        <h5 class="card-title">Approved</h5>
                        <h3 class="card-text"><?php echo $approved_logs; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card stats-card bg-danger text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-times-circle fa-2x mb-2"></i>
                        <h5 class="card-title">Rejected</h5>
                        <h3 class="card-text"><?php echo $rejected_logs; ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Recent Log Entries</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        $stmt = $pdo->prepare("
                            SELECT * FROM log_entries 
                            WHERE student_id = ? 
                            ORDER BY created_at DESC 
                            LIMIT 5
                        ");
                        $stmt->execute([$user_id]);
                        $recent_logs = $stmt->fetchAll();
                        
                        if (empty($recent_logs)):
                        ?>
                            <div class="text-center py-4">
                                <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No log entries yet</p>
                                <a href="log-entry.php" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Add Your First Log Entry
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Activity</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recent_logs as $log): ?>
                                            <tr>
                                                <td><?php echo date('M d, Y', strtotime($log['date'])); ?></td>
                                                <td><?php echo htmlspecialchars(substr($log['activity'], 0, 50)) . (strlen($log['activity']) > 50 ? '...' : ''); ?></td>
                                                <td>
                                                    <?php
                                                    $status_class = $log['status'] === 'pending' ? 'warning' : 
                                                                  ($log['status'] === 'approved' ? 'success' : 'danger');
                                                    $status_icon = $log['status'] === 'pending' ? 'clock' : 
                                                                  ($log['status'] === 'approved' ? 'check-circle' : 'times-circle');
                                                    ?>
                                                    <span class="badge bg-<?php echo $status_class; ?>">
                                                        <i class="fas fa-<?php echo $status_icon; ?> me-1"></i>
                                                        <?php echo ucfirst($log['status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="view-log.php?id=<?php echo $log['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-3">
                            <a href="log-entry.php" class="btn btn-primary quick-action">
                                <i class="fas fa-plus me-2"></i>Add New Log Entry
                            </a>
                            <a href="history.php" class="btn btn-outline-primary quick-action">
                                <i class="fas fa-history me-2"></i>View All Logs
                            </a>
                            <a href="profile.php" class="btn btn-outline-secondary quick-action">
                                <i class="fas fa-user-edit me-2"></i>Update Profile
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0">Progress Overview</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        $total = $total_logs;
                        $approved_percentage = $total > 0 ? round(($approved_logs / $total) * 100) : 0;
                        ?>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Approval Rate</span>
                                <span><?php echo $approved_percentage; ?>%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-success" style="width: <?php echo $approved_percentage; ?>%"></div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Completion</span>
                                <span><?php echo $total; ?> / 100 logs</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-primary" style="width: <?php echo min($total, 100); ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 