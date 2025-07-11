<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings - SIWES Logbook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar-brand {
            font-weight: bold;
        }
        .profile-card {
            transition: transform 0.3s ease;
        }
        .profile-card:hover {
            transform: translateY(-2px);
        }
        .form-section {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
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
                        <a class="nav-link" href="student-log-entry.html">
                            <i class="fas fa-plus me-1"></i>Add Log Entry
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="student-history.html">
                            <i class="fas fa-history me-1"></i>History
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="student-profile.html">
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
                <h2 class="mb-4">Profile Settings</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card profile-card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-user-edit me-2"></i>Personal Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="profileForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="matricNumber" class="form-label">Matric Number</label>
                                    <input type="text" class="form-control" id="matricNumber" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="department" class="form-label">Department</label>
                                    <select class="form-control" id="department" required>
                                        <option value="">Select Department</option>
                                        <option value="Computer Science">Computer Science</option>
                                        <option value="Electrical Engineering">Electrical Engineering</option>
                                        <option value="Mechanical Engineering">Mechanical Engineering</option>
                                        <option value="Civil Engineering">Civil Engineering</option>
                                        <option value="Chemical Engineering">Chemical Engineering</option>
                                        <option value="Agricultural Engineering">Agricultural Engineering</option>
                                        <option value="Food Technology">Food Technology</option>
                                        <option value="Architecture">Architecture</option>
                                        <option value="Urban and Regional Planning">Urban and Regional Planning</option>
                                        <option value="Estate Management">Estate Management</option>
                                        <option value="Quantity Surveying">Quantity Surveying</option>
                                        <option value="Building Technology">Building Technology</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="institution" class="form-label">Institution</label>
                                <input type="text" class="form-control" id="institution" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Profile
                            </button>
                        </form>
                        
                        <div id="profileAlert" class="alert mt-3 d-none"></div>
                    </div>
                </div>

                <div class="card profile-card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-lock me-2"></i>Change Password
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="passwordForm">
                            <div class="mb-3">
                                <label for="currentPassword" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="currentPassword" required>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="newPassword" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="newPassword" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirmPassword" required>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-key me-2"></i>Change Password
                            </button>
                        </form>
                        
                        <div id="passwordAlert" class="alert mt-3 d-none"></div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card profile-card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>Account Information
                        </h5>
                    </div>
                    <div class="card-body" id="accountInfo">
                        <div class="text-center py-3">
                            <i class="fas fa-spinner fa-spin text-muted"></i>
                            <p class="mt-2 text-muted">Loading...</p>
                        </div>
                    </div>
                </div>
                
                <div class="card profile-card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-shield-alt me-2"></i>Security Tips
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Use a strong password with letters, numbers, and symbols
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Never share your login credentials
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Log out when using shared computers
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Keep your contact information updated
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
                loadProfileData();
            }
        })
        .catch(error => {
            window.location.href = 'student-login.html';
        });

        function loadProfileData() {
            fetch('/backend/api/student.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'get_profile'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    populateProfileForm(data.profile);
                    displayAccountInfo(data.profile);
                } else {
                    alert('Error loading profile data');
                }
            })
            .catch(error => {
                console.error('Error loading profile data:', error);
            });
        }

        function populateProfileForm(profile) {
            document.getElementById('name').value = profile.name || '';
            document.getElementById('email').value = profile.email || '';
            document.getElementById('matricNumber').value = profile.matric_number || '';
            document.getElementById('department').value = profile.department || '';
            document.getElementById('institution').value = profile.institution || '';
        }

        function displayAccountInfo(profile) {
            const joinDate = new Date(profile.created_at).toLocaleDateString();
            document.getElementById('accountInfo').innerHTML = `
                <div class="text-center mb-3">
                    <i class="fas fa-user-circle fa-3x text-primary mb-2"></i>
                    <h6>${profile.name}</h6>
                    <p class="text-muted">Student</p>
                </div>
                <div class="mb-2">
                    <strong>Email:</strong><br>
                    ${profile.email}
                </div>
                <div class="mb-2">
                    <strong>Matric Number:</strong><br>
                    ${profile.matric_number || 'Not specified'}
                </div>
                <div class="mb-2">
                    <strong>Department:</strong><br>
                    ${profile.department || 'Not specified'}
                </div>
                <div class="mb-2">
                    <strong>Institution:</strong><br>
                    ${profile.institution || 'Not specified'}
                </div>
                <div class="mb-2">
                    <strong>Member Since:</strong><br>
                    ${joinDate}
                </div>
            `;
        }

        // Profile form submission
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                department: document.getElementById('department').value,
                institution: document.getElementById('institution').value
            };
            
            const alertDiv = document.getElementById('profileAlert');
            alertDiv.classList.add('d-none');
            
            fetch('/backend/api/student.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'update_profile',
                    ...formData
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alertDiv.textContent = 'Profile updated successfully!';
                    alertDiv.className = 'alert alert-success mt-3';
                    alertDiv.classList.remove('d-none');
                } else {
                    alertDiv.textContent = data.message || 'Failed to update profile';
                    alertDiv.className = 'alert alert-danger mt-3';
                    alertDiv.classList.remove('d-none');
                }
            })
            .catch(error => {
                alertDiv.textContent = 'Network error. Please try again.';
                alertDiv.className = 'alert alert-danger mt-3';
                alertDiv.classList.remove('d-none');
            });
        });

        // Password form submission
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            const alertDiv = document.getElementById('passwordAlert');
            alertDiv.classList.add('d-none');
            
            // Validation
            if (newPassword !== confirmPassword) {
                alertDiv.textContent = 'New passwords do not match!';
                alertDiv.className = 'alert alert-danger mt-3';
                alertDiv.classList.remove('d-none');
                return;
            }
            
            if (newPassword.length < 6) {
                alertDiv.textContent = 'Password must be at least 6 characters long!';
                alertDiv.className = 'alert alert-danger mt-3';
                alertDiv.classList.remove('d-none');
                return;
            }
            
            fetch('/backend/api/student.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'change_password',
                    current_password: currentPassword,
                    new_password: newPassword
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alertDiv.textContent = 'Password changed successfully!';
                    alertDiv.className = 'alert alert-success mt-3';
                    alertDiv.classList.remove('d-none');
                    document.getElementById('passwordForm').reset();
                } else {
                    alertDiv.textContent = data.message || 'Failed to change password';
                    alertDiv.className = 'alert alert-danger mt-3';
                    alertDiv.classList.remove('d-none');
                }
            })
            .catch(error => {
                alertDiv.textContent = 'Network error. Please try again.';
                alertDiv.className = 'alert alert-danger mt-3';
                alertDiv.classList.remove('d-none');
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
</body>
</html>
