<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log History - SIWES Logbook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar-brand { font-weight: bold; }
        .log-card { transition: transform 0.3s ease; }
        .log-card:hover { transform: translateY(-2px); }
        .status-badge { font-size: 0.8rem; }
        .activity-text {
            max-height: 100px;
            overflow: hidden;
            position: relative;
        }
        .activity-text.expanded {
            max-height: none;
        }
        .read-more {
            color: #007bff;
            cursor: pointer;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-book-open me-2"></i>SIWES Logbook</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="student-dashboard.html"><i class="fas fa-home me-1"></i>Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="student-log-entry.html"><i class="fas fa-plus me-1"></i>Add Log Entry</a></li>
                    <li class="nav-item"><a class="nav-link active" href="student-history.html"><i class="fas fa-history me-1"></i>History</a></li>
                    <li class="nav-item"><a class="nav-link" href="student-profile.html"><i class="fas fa-user me-1"></i>Profile</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"><i class="fas fa-user-circle me-1"></i><span id="studentName">Student</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="student-profile.html">Profile Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
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
                    <h2>Log History</h2>
                    <div class="d-flex gap-2">
                        <select class="form-select" id="statusFilter" style="width: auto;">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                        <button class="btn btn-outline-primary" onclick="loadLogHistory()">
                            <i class="fas fa-sync-alt me-1"></i>Refresh
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Your Log Entries</h5>
                    </div>
                    <div class="card-body">
                        <div id="logHistoryContainer">
                            <div class="text-center py-4">
                                <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                                <p class="mt-2 text-muted">Loading your log history...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let allLogs = [];
        let filteredLogs = [];

        fetch("/backend/api/auth.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ action: "check_auth" })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success || data.role !== "student") {
                window.location.href = "student-login.html";
            } else {
                document.getElementById("studentName").textContent = data.name;
                loadLogHistory();
            }
        })
        .catch(error => { window.location.href = "student-login.html"; });

        function loadLogHistory() {
            fetch("/backend/api/student.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ action: "get_logs" })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    allLogs = data.logs;
                    filteredLogs = data.logs;
                    displayLogHistory(data.logs);
                } else {
                    document.getElementById("logHistoryContainer").innerHTML = 
                        "<div class=\"text-center py-4\"><p class=\"text-muted\">No log entries found.</p></div>";
                }
            })
            .catch(error => {
                console.error("Error loading log history:", error);
                document.getElementById("logHistoryContainer").innerHTML = 
                    "<div class=\"text-center py-4\"><p class=\"text-danger\">Error loading log history.</p></div>";
            });
        }

        function displayLogHistory(logs) {
            const container = document.getElementById("logHistoryContainer");
            const statusFilter = document.getElementById("statusFilter").value;
            
            if (statusFilter) {
                filteredLogs = logs.filter(log => log.status === statusFilter);
            } else {
                filteredLogs = logs;
            }
            
            if (filteredLogs.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-4">
                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No log entries found</p>
                        <a href="student-log-entry.html" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add Your First Log Entry
                        </a>
                    </div>
                `;
                return;
            }
            
            let html = "";
            filteredLogs.forEach((log, index) => {
                const date = new Date(log.date).toLocaleDateString();
                const statusClass = log.status === "pending" ? "warning" : 
                                  log.status === "approved" ? "success" : "danger";
                const statusIcon = log.status === "pending" ? "clock" : 
                                 log.status === "approved" ? "check-circle" : "times-circle";
                
                html += `
                    <div class="card log-card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="card-title mb-0">Log Entry #${log.id}</h6>
                                        <span class="badge bg-${statusClass} status-badge">
                                            <i class="fas fa-${statusIcon} me-1"></i>${log.status.toUpperCase()}
                                        </span>
                                    </div>
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-calendar me-1"></i>${date}
                                        <span class="ms-3">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            ${log.latitude ? `${log.latitude}, ${log.longitude}` : 'Location not captured'}
                                        </span>
                                    </p>
                                    <div class="activity-text" id="activity-${index}">
                                        <strong>Activity:</strong><br>
                                        ${log.activity}
                                    </div>
                                    ${log.activity.length > 150 ? `
                                        <span class="read-more" onclick="toggleActivity(${index})">
                                            Read more
                                        </span>
                                    ` : ''}
                                    ${log.supervisor_comment ? `
                                        <div class="mt-3 p-3 bg-light rounded">
                                            <strong><i class="fas fa-comment me-1"></i>Supervisor Comment:</strong><br>
                                            ${log.supervisor_comment}
                                        </div>
                                    ` : ''}
                                </div>
                                <div class="col-md-4 text-end">
                                    <small class="text-muted">
                                        Submitted: ${new Date(log.created_at).toLocaleString()}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }

        function toggleActivity(index) {
            const activityDiv = document.getElementById(`activity-${index}`);
            const readMoreSpan = activityDiv.nextElementSibling;
            
            if (activityDiv.classList.contains('expanded')) {
                activityDiv.classList.remove('expanded');
                readMoreSpan.textContent = 'Read more';
            } else {
                activityDiv.classList.add('expanded');
                readMoreSpan.textContent = 'Show less';
            }
        }

        document.getElementById("statusFilter").addEventListener("change", function() {
            loadLogHistory();
        });

        document.getElementById("logoutBtn").addEventListener("click", function(e) {
            e.preventDefault();
            fetch("/backend/api/auth.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ action: "logout" })
            })
            .then(() => { window.location.href = "index.html"; });
        });
    </script>
</body>
</html>
