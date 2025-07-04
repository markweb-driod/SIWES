<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - SIWES Coordinator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar-brand {
            font-weight: bold;
        }
        .user-card {
            transition: transform 0.3s ease;
        }
        .user-card:hover {
            transform: translateY(-2px);
        }
        .role-badge {
            font-size: 0.8rem;
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
                        <a class="nav-link active" href="admin-manage.html">
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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Manage Users</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fas fa-plus me-2"></i>Add New User
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <ul class="nav nav-tabs" id="userTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="students-tab" data-bs-toggle="tab" data-bs-target="#students" type="button" role="tab">
                            <i class="fas fa-user-graduate me-1"></i>Students
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="supervisors-tab" data-bs-toggle="tab" data-bs-target="#supervisors" type="button" role="tab">
                            <i class="fas fa-user-tie me-1"></i>Supervisors
                        </button>
                    </li>
                </ul>
                
                <div class="tab-content" id="userTabsContent">
                    <div class="tab-pane fade show active" id="students" role="tabpanel">
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="mb-0">Student Management</h5>
                            </div>
                            <div class="card-body">
                                <div id="studentsContainer">
                                    <div class="text-center py-4">
                                        <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                                        <p class="mt-2 text-muted">Loading students...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="supervisors" role="tabpanel">
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="mb-0">Supervisor Management</h5>
                            </div>
                            <div class="card-body">
                                <div id="supervisorsContainer">
                                    <div class="text-center py-4">
                                        <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                                        <p class="mt-2 text-muted">Loading supervisors...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="userName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="userName" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="userEmail" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="userEmail" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="userRole" class="form-label">Role</label>
                                <select class="form-control" id="userRole" required>
                                    <option value="">Select Role</option>
                                    <option value="student">Student</option>
                                    <option value="supervisor">Supervisor</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="userPassword" class="form-label">Password</label>
                                <input type="password" class="form-control" id="userPassword" required>
                            </div>
                        </div>
                        
                        <div class="row" id="studentFields" style="display: none;">
                            <div class="col-md-6 mb-3">
                                <label for="userMatric" class="form-label">Matric Number</label>
                                <input type="text" class="form-control" id="userMatric">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="userDepartment" class="form-label">Department</label>
                                <select class="form-control" id="userDepartment">
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
                            <label for="userInstitution" class="form-label">Institution</label>
                            <input type="text" class="form-control" id="userInstitution" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="addUser()">Add User</button>
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
            if (!data.success || data.role !== 'admin') {
                window.location.href = 'admin-login.html';
            } else {
                document.getElementById('adminName').textContent = data.name;
                loadUsers();
            }
        })
        .catch(error => {
            window.location.href = 'admin-login.html';
        });

        function loadUsers() {
            loadStudents();
            loadSupervisors();
        }

        function loadStudents() {
            fetch('/backend/api/admin.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'get_all_students'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayStudents(data.students);
                }
            })
            .catch(error => {
                console.error('Error loading students:', error);
            });
        }

        function loadSupervisors() {
            fetch('/backend/api/admin.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'get_all_supervisors'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displaySupervisors(data.supervisors);
                }
            })
            .catch(error => {
                console.error('Error loading supervisors:', error);
            });
        }

        function displayStudents(students) {
            const container = document.getElementById('studentsContainer');
            
            if (students.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-4">
                        <i class="fas fa-user-graduate fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No students found</p>
                    </div>
                `;
                return;
            }
            
            let html = '<div class="row">';
            students.forEach(student => {
                const joinDate = new Date(student.created_at).toLocaleDateString();
                html += `
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card user-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="card-title mb-0">${student.name}</h6>
                                    <span class="badge bg-primary role-badge">Student</span>
                                </div>
                                <p class="card-text text-muted mb-1">
                                    <i class="fas fa-envelope me-1"></i>${student.email}
                                </p>
                                <p class="card-text text-muted mb-1">
                                    <i class="fas fa-id-card me-1"></i>${student.matric_number || 'Not specified'}
                                </p>
                                <p class="card-text text-muted mb-1">
                                    <i class="fas fa-building me-1"></i>${student.department || 'Not specified'}
                                </p>
                                <p class="card-text text-muted mb-2">
                                    <i class="fas fa-university me-1"></i>${student.institution || 'Not specified'}
                                </p>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>Joined: ${joinDate}
                                </small>
                                <div class="mt-2">
                                    <button class="btn btn-sm btn-danger" onclick="deleteUser(${student.id}, 'student')">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            container.innerHTML = html;
        }

        function displaySupervisors(supervisors) {
            const container = document.getElementById('supervisorsContainer');
            
            if (supervisors.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-4">
                        <i class="fas fa-user-tie fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No supervisors found</p>
                    </div>
                `;
                return;
            }
            
            let html = '<div class="row">';
            supervisors.forEach(supervisor => {
                const joinDate = new Date(supervisor.created_at).toLocaleDateString();
                html += `
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card user-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="card-title mb-0">${supervisor.name}</h6>
                                    <span class="badge bg-success role-badge">Supervisor</span>
                                </div>
                                <p class="card-text text-muted mb-1">
                                    <i class="fas fa-envelope me-1"></i>${supervisor.email}
                                </p>
                                <p class="card-text text-muted mb-1">
                                    <i class="fas fa-building me-1"></i>${supervisor.department || 'Not specified'}
                                </p>
                                <p class="card-text text-muted mb-2">
                                    <i class="fas fa-university me-1"></i>${supervisor.institution || 'Not specified'}
                                </p>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>Joined: ${joinDate}
                                </small>
                                <div class="mt-2">
                                    <button class="btn btn-sm btn-danger" onclick="deleteUser(${supervisor.id}, 'supervisor')">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            container.innerHTML = html;
        }

        function addUser() {
            const formData = {
                name: document.getElementById('userName').value,
                email: document.getElementById('userEmail').value,
                role: document.getElementById('userRole').value,
                password: document.getElementById('userPassword').value,
                institution: document.getElementById('userInstitution').value,
                matric_number: document.getElementById('userMatric').value,
                department: document.getElementById('userDepartment').value
            };
            
            if (!formData.name || !formData.email || !formData.role || !formData.password || !formData.institution) {
                alert('Please fill in all required fields');
                return;
            }
            
            fetch('/backend/api/admin.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'add_user',
                    ...formData
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('User added successfully!');
                    document.getElementById('addUserForm').reset();
                    document.getElementById('studentFields').style.display = 'none';
                    bootstrap.Modal.getInstance(document.getElementById('addUserModal')).hide();
                    loadUsers();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Network error. Please try again.');
            });
        }

        function deleteUser(userId, role) {
            if (!confirm(`Are you sure you want to delete this ${role}?`)) {
                return;
            }
            
            fetch('/backend/api/admin.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'delete_user',
                    user_id: userId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('User deleted successfully!');
                    loadUsers();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Network error. Please try again.');
            });
        }

        // Show/hide student fields based on role selection
        document.getElementById('userRole').addEventListener('change', function() {
            const studentFields = document.getElementById('studentFields');
            if (this.value === 'student') {
                studentFields.style.display = 'block';
            } else {
                studentFields.style.display = 'none';
            }
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
