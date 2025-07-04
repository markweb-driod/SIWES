<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Log Entry - SIWES Logbook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar-brand { font-weight: bold; }
        #map { height: 300px; width: 100%; border-radius: 8px; }
        .log-details { background-color: #f8f9fa; border-radius: 8px; padding: 20px; }
        .status-badge {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-user-tie me-2"></i>Supervisor Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="supervisor-dashboard.html"><i class="fas fa-home me-1"></i>Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link active" href="supervisor-review.html"><i class="fas fa-clipboard-check me-1"></i>Review Logs</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"><i class="fas fa-user-circle me-1"></i><span id="supervisorName">Supervisor</span></a>
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
                    <h2>Review Log Entry</h2>
                    <a href="supervisor-dashboard.html" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0">Log Entry Details</h5></div>
                    <div class="card-body">
                        <div id="logDetails" class="log-details">
                            <div class="text-center py-4">
                                <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                                <p class="mt-2 text-muted">Loading log details...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header"><h5 class="mb-0">Review Decision</h5></div>
                    <div class="card-body">
                        <form id="reviewForm">
                            <div class="mb-3">
                                <label for="supervisorComment" class="form-label">Supervisor Comment</label>
                                <textarea class="form-control" id="supervisorComment" rows="4" 
                                    placeholder="Add your feedback or comments about this log entry..."></textarea>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-success btn-lg flex-fill" onclick="approveLog()">
                                    <i class="fas fa-check me-2"></i>Approve
                                </button>
                                <button type="button" class="btn btn-danger btn-lg flex-fill" onclick="rejectLog()">
                                    <i class="fas fa-times me-2"></i>Reject
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0">Student Information</h5></div>
                    <div class="card-body" id="studentInfo">
                        <div class="text-center py-3">
                            <i class="fas fa-spinner fa-spin text-muted"></i>
                            <p class="mt-2 text-muted">Loading...</p>
                        </div>
                    </div>
                </div>
                
                <div class="card mt-3">
                    <div class="card-header"><h5 class="mb-0">Location</h5></div>
                    <div class="card-body">
                        <div id="mapContainer"><div id="map"></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentLogId = null;
        let currentLog = null;

        fetch("/backend/api/auth.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ action: "check_auth" })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success || data.role !== "supervisor") {
                window.location.href = "supervisor-login.html";
            } else {
                document.getElementById("supervisorName").textContent = data.name;
                loadLogDetails();
            }
        })
        .catch(error => { window.location.href = "supervisor-login.html"; });

        function loadLogDetails() {
            const urlParams = new URLSearchParams(window.location.search);
            currentLogId = urlParams.get('log_id');
            
            if (!currentLogId) {
                document.getElementById('logDetails').innerHTML = 
                    '<div class="alert alert-danger">No log ID provided</div>';
                return;
            }

            fetch("/backend/api/supervisor.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ action: "get_log_details", log_id: currentLogId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    currentLog = data.log;
                    displayLogDetails(data.log);
                    displayStudentInfo(data.log);
                    if (data.log.latitude && data.log.longitude) {
                        initMap(parseFloat(data.log.latitude), parseFloat(data.log.longitude));
                    }
                } else {
                    document.getElementById('logDetails').innerHTML = 
                        '<div class="alert alert-danger">Log not found</div>';
                }
            })
            .catch(error => {
                console.error('Error loading log details:', error);
                document.getElementById('logDetails').innerHTML = 
                    '<div class="alert alert-danger">Error loading log details</div>';
            });
        }

        function displayLogDetails(log) {
            const date = new Date(log.date).toLocaleDateString();
            const statusClass = log.status === "pending" ? "warning" : log.status === "approved" ? "success" : "danger";
            
            document.getElementById("logDetails").innerHTML = `
                <div class="log-details">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Student:</strong> ${log.student_name}
                        </div>
                        <div class="col-md-6">
                            <strong>Date:</strong> ${date}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Matric Number:</strong> ${log.matric_number}
                        </div>
                        <div class="col-md-6">
                            <strong>Department:</strong> ${log.department}
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong>Status:</strong> 
                        <span class="badge bg-${statusClass} status-badge">${log.status.toUpperCase()}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Activity Description:</strong>
                        <p class="mt-2">${log.activity}</p>
                    </div>
                    ${log.supervisor_comment ? `
                        <div class="mb-3">
                            <strong>Previous Comment:</strong>
                            <p class="mt-2 text-muted">${log.supervisor_comment}</p>
                        </div>
                    ` : ''}
                </div>
            `;
        }

        function displayStudentInfo(log) {
            document.getElementById('studentInfo').innerHTML = `
                <div class="mb-3">
                    <strong>Name:</strong><br>
                    ${log.student_name}
                </div>
                <div class="mb-3">
                    <strong>Matric Number:</strong><br>
                    ${log.matric_number}
                </div>
                <div class="mb-3">
                    <strong>Department:</strong><br>
                    ${log.department}
                </div>
                <div class="mb-3">
                    <strong>Institution:</strong><br>
                    ${log.institution || 'Not specified'}
                </div>
            `;
        }

        function initMap(lat, lng) {
            const mapDiv = document.getElementById("map");
            const map = new google.maps.Map(mapDiv, {
                center: { lat: lat, lng: lng },
                zoom: 15
            });
            new google.maps.Marker({
                position: { lat: lat, lng: lng },
                map: map,
                title: "Student Location"
            });
        }

        function approveLog() {
            if (!currentLogId) return;
            
            const comment = document.getElementById("supervisorComment").value;
            
            fetch("/backend/api/supervisor.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ action: "approve_log", log_id: currentLogId, comment: comment })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Log approved successfully!");
                    window.location.href = "supervisor-dashboard.html";
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(error => { alert("Network error. Please try again."); });
        }

        function rejectLog() {
            if (!currentLogId) return;
            
            const comment = document.getElementById("supervisorComment").value;
            
            if (!comment.trim()) {
                alert("Please provide a comment when rejecting a log entry.");
                return;
            }
            
            fetch("/backend/api/supervisor.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ action: "reject_log", log_id: currentLogId, comment: comment })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Log rejected successfully!");
                    window.location.href = "supervisor-dashboard.html";
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(error => { alert("Network error. Please try again."); });
        }

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
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap"></script>
</body>
</html>
