<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Dashboard - SIWES Logbook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .stats-card {
            transition: transform 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .navbar-brand {
            font-weight: bold;
        }
        .log-entry-card {
            border-left: 4px solid #ffc107;
        }
        .log-entry-card.approved {
            border-left-color: #28a745;
        }
        .log-entry-card.rejected {
            border-left-color: #dc3545;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-user-tie me-2"></i>Supervisor Portal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="supervisor-dashboard.html">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="supervisor-review.html">
                            <i class="fas fa-clipboard-check me-1"></i>Review Logs
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i><span id="supervisorName">Supervisor</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" id="logoutBtn">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Welcome, <span id="welcomeName">Supervisor</span>!</h2>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card stats-card bg-warning text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-clock fa-2x mb-2"></i>
                        <h5 class="card-title">Pending Reviews</h5>
                        <h3 class="card-text" id="pendingReviews">0</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card stats-card bg-success text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-2x mb-2"></i>
                        <h5 class="card-title">Approved Today</h5>
                        <h3 class="card-text" id="approvedToday">0</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card stats-card bg-info text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-2x mb-2"></i>
                        <h5 class="card-title">Total Students</h5>
                        <h3 class="card-text" id="totalStudents">0</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Pending Log Entries</h5>
                        <button class="btn btn-sm btn-outline-success" onclick="loadPendingLogs()">
                            <i class="fas fa-sync-alt me-1"></i>Refresh
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="pendingLogsContainer">
                            <p class="text-muted text-center">Loading pending logs...</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="supervisor-review.html" class="btn btn-success">
                                <i class="fas fa-clipboard-check me-2"></i>Review All Logs
                            </a>
                            <button class="btn btn-outline-info" onclick="loadPendingLogs()">
                                <i class="fas fa-sync-alt me-2"></i>Refresh Data
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0">Today's Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <strong>Pending:</strong>
                            <span id="pendingCount" class="badge bg-warning ms-2">0</span>
                        </div>
                        <div class="mb-2">
                            <strong>Approved:</strong>
                            <span id="approvedCount" class="badge bg-success ms-2">0</span>
                        </div>
                        <div class="mb-2">
                            <strong>Rejected:</strong>
                            <span id="rejectedCount" class="badge bg-danger ms-2">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Check authentication on page load
        fetch('/backend/api/auth.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action: 'check_auth'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success || data.role !== 'supervisor') {
                window.location.href = 'supervisor-login.html';
            } else {
                loadDashboardData();
            }
        })
        .catch(error => {
            window.location.href = 'supervisor-login.html';
        });

        function loadDashboardData() {
            fetch('/backend/api/supervisor.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'dashboard'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('welcomeName').textContent = data.name;
                    document.getElementById('supervisorName').textContent = data.name;
                    
                    // Update stats
                    document.getElementById('pendingReviews').textContent = data.pending_logs.length || 0;
                    document.getElementById('pendingCount').textContent = data.pending_logs.length || 0;
                    
                    // Load pending logs
                    loadPendingLogs();
                } else {
                    window.location.href = 'supervisor-login.html';
                }
            })
            .catch(error => {
                console.error('Error loading dashboard data:', error);
            });
        }

        function loadPendingLogs() {
            fetch('/backend/api/supervisor.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'get_pending_logs'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayPendingLogs(data.logs);
                }
            })
            .catch(error => {
                console.error('Error loading pending logs:', error);
            });
        }

        function displayPendingLogs(logs) {
            const container = document.getElementById('pendingLogsContainer');
            
            if (logs.length === 0) {
                container.innerHTML = '<p class="text-muted text-center">No pending log entries</p>';
                return;
            }
            
            let html = '';
            logs.forEach(log => {
                const date = new Date(log.date).toLocaleDateString();
                html += `
                    <div class="card log-entry-card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="card-title">${log.student_name}</h6>
                                    <p class="card-text text-muted">${log.matric_number} • ${log.department}</p>
                                    <p class="card-text">${log.activity.substring(0, 100)}${log.activity.length > 100 ? '...' : ''}</p>
                                    <small class="text-muted">Date: ${date}</small>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-success me-1" onclick="reviewLog(${log.id})">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="reviewLog(${log.id})">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }

        function reviewLog(logId) {
            // Redirect to review page with log ID
            window.location.href = `supervisor-review.html?log_id=${logId}`;
        }

        // Logout functionality
        document.getElementById('logoutBtn').addEventListener('click', function(e) {
            e.preventDefault();
            
            fetch('/backend/api/auth.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'logout'
                })
            })
            .then(() => {
                window.location.href = 'index.html';
            });
        });
    </script>
</body>
</html> 