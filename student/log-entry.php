<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Log Entry - SIWES Logbook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar-brand {
            font-weight: bold;
        }
        #map {
            height: 300px;
            width: 100%;
            border-radius: 8px;
        }
        .location-status {
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-book-open me-2"></i>SIWES Logbook
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="student-dashboard.html">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="student-log-entry.html">
                            <i class="fas fa-plus me-1"></i>Add Log Entry
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="student-history.html">
                            <i class="fas fa-history me-1"></i>History
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="student-profile.html">
                            <i class="fas fa-user me-1"></i>Profile
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i><span id="studentName">Student</span>
                        </a>
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
                <h2 class="mb-4">Add New Log Entry</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Log Entry Details</h5>
                    </div>
                    <div class="card-body">
                        <form id="logEntryForm">
                            <div class="mb-3">
                                <label for="activity" class="form-label">Activity Description *</label>
                                <textarea class="form-control" id="activity" rows="5" required 
                                    placeholder="Describe your SIWES activity for today..."></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Location</label>
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-primary" id="getLocationBtn">
                                        <i class="fas fa-map-marker-alt me-2"></i>Get Current Location
                                    </button>
                                </div>
                                <div id="locationStatus" class="location-status d-none"></div>
                                <input type="hidden" id="latitude">
                                <input type="hidden" id="longitude">
                            </div>
                            
                            <div id="mapContainer" class="mb-3 d-none">
                                <label class="form-label">Location Map</label>
                                <div id="map"></div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg" id="submitBtn" disabled>
                                    <i class="fas fa-save me-2"></i>Submit Log Entry
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Instructions</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-info-circle text-primary me-2"></i>
                                Describe your daily SIWES activities in detail
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-map-marker-alt text-success me-2"></i>
                                Get your current location for verification
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-calendar text-warning me-2"></i>
                                Select the correct date for your activity
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-clock text-info me-2"></i>
                                Submit before the end of the day
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
            if (!data.success || data.role !== 'student') {
                window.location.href = 'student-login.html';
            } else {
                document.getElementById('studentName').textContent = data.name;
                // Set today's date
                document.getElementById('date').value = new Date().toISOString().split('T')[0];
            }
        })
        .catch(error => {
            window.location.href = 'student-login.html';
        });

        // Get location functionality
        document.getElementById('getLocationBtn').addEventListener('click', function() {
            const statusDiv = document.getElementById('locationStatus');
            const submitBtn = document.getElementById('submitBtn');
            
            statusDiv.textContent = 'Getting location...';
            statusDiv.className = 'location-status alert alert-info d-block';
            
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        
                        document.getElementById('latitude').value = lat;
                        document.getElementById('longitude').value = lng;
                        
                        statusDiv.textContent = `Location captured: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                        statusDiv.className = 'location-status alert alert-success d-block';
                        
                        // Show map
                        document.getElementById('mapContainer').classList.remove('d-none');
                        initMap(lat, lng);
                        
                        // Enable submit button
                        submitBtn.disabled = false;
                    },
                    function(error) {
                        statusDiv.textContent = 'Error getting location: ' + error.message;
                        statusDiv.className = 'location-status alert alert-danger d-block';
                    }
                );
            } else {
                statusDiv.textContent = 'Geolocation is not supported by this browser.';
                statusDiv.className = 'location-status alert alert-danger d-block';
            }
        });

        // Initialize map
        function initMap(lat, lng) {
            const mapDiv = document.getElementById('map');
            const map = new google.maps.Map(mapDiv, {
                center: { lat: lat, lng: lng },
                zoom: 15
            });
            
            new google.maps.Marker({
                position: { lat: lat, lng: lng },
                map: map,
                title: 'Your Location'
            });
        }

        // Form submission
        document.getElementById('logEntryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const activity = document.getElementById('activity').value;
            const date = document.getElementById('date').value;
            const latitude = document.getElementById('latitude').value;
            const longitude = document.getElementById('longitude').value;
            
            if (!latitude || !longitude) {
                alert('Please get your location first.');
                return;
            }
            
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
            
            fetch('/backend/api/student.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'add_log',
                    activity: activity,
                    date: date,
                    latitude: latitude,
                    longitude: longitude
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Log entry submitted successfully!');
                    window.location.href = 'student-dashboard.html';
                } else {
                    alert('Error: ' + data.message);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Submit Log Entry';
                }
            })
            .catch(error => {
                alert('Network error. Please try again.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Submit Log Entry';
            });
        });

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
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap">
    </script>
</body>
</html> 