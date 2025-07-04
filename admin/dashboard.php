<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIWES Coordinator Dashboard</title>
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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-cogs me-2"></i>SIWES Coordinator
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="admin-dashboard.html">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin-manage.html">
                            <i class="fas fa-users me-1"></i>Manage Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin-reports.html">
                            <i class="fas fa-chart-bar me-1"></i>Reports
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i><span id="adminName">Coordinator</span>
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
                <h2 class="mb-4">Welcome, <span id="welcomeName">Coordinator</span>!</h2>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card stats-card bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-2x mb-2"></i>
                        <h5 class="card-title">Total Students</h5>
                        <h3 class="card-text" id="totalStudents">0</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card stats-card bg-success text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-user-tie fa-2x mb-2"></i>
                        <h5 class="card-title">Total Supervisors</h5>
                        <h3 class="card-text" id="totalSupervisors">0</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card stats-card bg-info text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                        <h5 class="card-title">Total Logs</h5>
                        <h3 class="card-text" id="totalLogs">0</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card stats-card bg-warning text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-clock fa-2x mb-2"></i>
                        <h5 class="card-title">Pending Reviews</h5>
                        <h3 class="card-text" id="pendingLogs">0</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <a href="admin-manage.html" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-users me-2"></i>Manage Users
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="admin-reports.html" class="btn btn-success btn-lg w-100">
                                    <i class="fas fa-chart-bar me-2"></i>Generate Reports
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">System Overview</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Approved Logs:</strong>
                            <span id="approvedLogs" class="badge bg-success ms-2">0</span>
                        </div>
                        <div class="mb-3">
                            <strong>Rejected Logs:</strong>
                            <span id="rejectedLogs" class="badge bg-danger ms-2">0</span>
                        </div>
                        <div class="mb-3">
                            <strong>Active Students:</strong>
                            <span id="activeStudents" class="badge bg-primary ms-2">0</span>
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
            if (!data.success || data.role !== 'admin') {
                window.location.href = 'admin-login.html';
            } else {
                loadDashboardData();
            }
        })
        .catch(error => {
            window.location.href = 'admin-login.html';
        });

        function loadDashboardData() {
            fetch('/backend/api/admin.php', {
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
                    document.getElementById('adminName').textContent = data.name;
                    
                    // Update stats
                    document.getElementById('totalStudents').textContent = data.stats.total_students || 0;
                    document.getElementById('totalSupervisors').textContent = data.stats.total_supervisors || 0;
                    document.getElementById('totalLogs').textContent = data.stats.total_logs || 0;
                    document.getElementById('pendingLogs').textContent = data.stats.pending || 0;
                    document.getElementById('approvedLogs').textContent = data.stats.approved || 0;
                    document.getElementById('rejectedLogs').textContent = data.stats.rejected || 0;
                    document.getElementById('activeStudents').textContent = data.stats.total_students || 0;
                } else {
                    window.location.href = 'admin-login.html';
                }
            })
            .catch(error => {
                console.error('Error loading dashboard data:', error);
            });
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