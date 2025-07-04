<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & Analytics - SIWES Coordinator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .navbar-brand {
            font-weight: bold;
        }
        .stats-card {
            transition: transform 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-2px);
        }
        .chart-container {
            position: relative;
            height: 300px;
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
                        <a class="nav-link" href="admin-dashboard.html">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin-manage.html">
                            <i class="fas fa-users me-1"></i>Manage Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="admin-reports.html">
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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Reports & Analytics</h2>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary" onclick="loadReports()">
                            <i class="fas fa-sync-alt me-1"></i>Refresh
                        </button>
                        <button class="btn btn-success" onclick="exportReport()">
                            <i class="fas fa-download me-1"></i>Export
                        </button>
                    </div>
                </div>
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
                        <h5 class="card-title">Total Log Entries</h5>
                        <h3 class="card-text" id="totalLogs">0</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card stats-card bg-warning text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-clock fa-2x mb-2"></i>
                        <h5 class="card-title">Pending Reviews</h5>
                        <h3 class="card-text" id="pendingReviews">0</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Log Entry Status Distribution</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Department Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="departmentChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Recent Activity</h5>
                    </div>
                    <div class="card-body">
                        <div id="recentActivity">
                            <div class="text-center py-4">
                                <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                                <p class="mt-2 text-muted">Loading recent activity...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Top Performing Students</h5>
                    </div>
                    <div class="card-body">
                        <div id="topStudents">
                            <div class="text-center py-3">
                                <i class="fas fa-spinner fa-spin text-muted"></i>
                                <p class="mt-2 text-muted">Loading...</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0">System Health</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <strong>Database:</strong>
                            <span class="badge bg-success ms-2">Connected</span>
                        </div>
                        <div class="mb-2">
                            <strong>API Status:</strong>
                            <span class="badge bg-success ms-2">Online</span>
                        </div>
                        <div class="mb-2">
                            <strong>Last Backup:</strong>
                            <span class="text-muted ms-2" id="lastBackup">Today</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let statusChart, departmentChart;

        // Check authentication
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
                document.getElementById('adminName').textContent = data.name;
                loadReports();
            }
        })
        .catch(error => {
            window.location.href = 'admin-login.html';
        });

        function loadReports() {
            fetch('/backend/api/admin.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'get_reports'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateStatistics(data.statistics);
                    createCharts(data.charts);
                    displayRecentActivity(data.recent_activity);
                    displayTopStudents(data.top_students);
                }
            })
            .catch(error => {
                console.error('Error loading reports:', error);
            });
        }

        function updateStatistics(stats) {
            document.getElementById('totalStudents').textContent = stats.total_students || 0;
            document.getElementById('totalSupervisors').textContent = stats.total_supervisors || 0;
            document.getElementById('totalLogs').textContent = stats.total_logs || 0;
            document.getElementById('pendingReviews').textContent = stats.pending_reviews || 0;
        }

        function createCharts(chartData) {
            // Status Chart
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            if (statusChart) statusChart.destroy();
            
            statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Approved', 'Pending', 'Rejected'],
                    datasets: [{
                        data: [
                            chartData.status.approved || 0,
                            chartData.status.pending || 0,
                            chartData.status.rejected || 0
                        ],
                        backgroundColor: ['#28a745', '#ffc107', '#dc3545']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Department Chart
            const deptCtx = document.getElementById('departmentChart').getContext('2d');
            if (departmentChart) departmentChart.destroy();
            
            const deptLabels = Object.keys(chartData.departments || {});
            const deptData = Object.values(chartData.departments || {});
            
            departmentChart = new Chart(deptCtx, {
                type: 'bar',
                data: {
                    labels: deptLabels,
                    datasets: [{
                        label: 'Students',
                        data: deptData,
                        backgroundColor: '#007bff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        function displayRecentActivity(activities) {
            const container = document.getElementById('recentActivity');
            
            if (!activities || activities.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-4">
                        <i class="fas fa-info-circle fa-2x text-muted mb-2"></i>
                        <p class="text-muted">No recent activity</p>
                    </div>
                `;
                return;
            }
            
            let html = '';
            activities.forEach(activity => {
                const date = new Date(activity.timestamp).toLocaleString();
                const iconClass = activity.type === 'login' ? 'sign-in-alt' : 
                                activity.type === 'log_entry' ? 'plus' : 'check';
                const colorClass = activity.type === 'login' ? 'text-info' : 
                                 activity.type === 'log_entry' ? 'text-primary' : 'text-success';
                
                html += `
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-${iconClass} ${colorClass} fa-lg"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-0">${activity.description}</p>
                            <small class="text-muted">${date}</small>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }

        function displayTopStudents(students) {
            const container = document.getElementById('topStudents');
            
            if (!students || students.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-3">
                        <i class="fas fa-user-graduate fa-2x text-muted mb-2"></i>
                        <p class="text-muted">No data available</p>
                    </div>
                `;
                return;
            }
            
            let html = '';
            students.forEach((student, index) => {
                html += `
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <span class="badge bg-primary rounded-circle">${index + 1}</span>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <p class="mb-0 small">${student.name}</p>
                            <small class="text-muted">${student.approved_logs} approved logs</small>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }

        function exportReport() {
            // Create a simple CSV export
            const csvContent = "data:text/csv;charset=utf-8," + 
                "Category,Count\n" +
                "Total Students," + document.getElementById('totalStudents').textContent + "\n" +
                "Total Supervisors," + document.getElementById('totalSupervisors').textContent + "\n" +
                "Total Log Entries," + document.getElementById('totalLogs').textContent + "\n" +
                "Pending Reviews," + document.getElementById('pendingReviews').textContent;
            
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "siwes_report_" + new Date().toISOString().split('T')[0] + ".csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
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