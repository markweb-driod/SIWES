<?php
session_start();
require_once '../backend/config/db.php';
require_once '../backend/config/session.php';

// Check if user is already logged in
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'supervisor') {
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Login - SIWES Logbook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --nsukka-green: #2E8B57;
            --nsukka-green-light: #3CB371;
            --nsukka-green-dark: #228B22;
            --nsukka-gold: #FFD700;
            --nsukka-cream: #F5F5DC;
            --text-dark: #2C3E50;
            --text-light: #6C757D;
        }
        
        body {
            background: linear-gradient(135deg, var(--nsukka-green) 0%, var(--nsukka-green-dark) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            max-width: 450px;
            width: 100%;
            border: 3px solid var(--nsukka-green);
        }
        
        .login-header {
            background: linear-gradient(45deg, var(--nsukka-green), var(--nsukka-green-light));
            color: white;
            padding: 2rem;
            border-radius: 17px 17px 0 0;
            text-align: center;
        }
        
        .login-header h2 {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            margin-bottom: 0;
            opacity: 0.9;
        }
        
        .login-body {
            padding: 2.5rem;
        }
        
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--nsukka-green);
            box-shadow: 0 0 0 0.2rem rgba(46, 139, 87, 0.25);
        }
        
        .input-group-text {
            background: var(--nsukka-green);
            color: white;
            border: 2px solid var(--nsukka-green);
            border-radius: 10px 0 0 10px;
        }
        
        .btn-nsukka {
            background: linear-gradient(45deg, var(--nsukka-green), var(--nsukka-green-light));
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(46, 139, 87, 0.3);
        }
        
        .btn-nsukka:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(46, 139, 87, 0.4);
            color: white;
        }
        
        .university-logo {
            max-width: 80px;
            height: auto;
            margin-bottom: 1rem;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
        
        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border-left: 4px solid #dc3545;
        }
        
        .back-link {
            color: var(--nsukka-green);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .back-link:hover {
            color: var(--nsukka-green-dark);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-container">
                    <div class="login-header">
                        <img src="../assets/images/nsukka-logo.png" alt="Nsukka Keffi Logo" class="university-logo">
                        <h2>Supervisor Login</h2>
                        <p>Review and approve student log entries</p>
                    </div>
                    
                    <div class="login-body">
                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?php echo htmlspecialchars($_GET['error']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <form action="../backend/api/auth.php" method="POST">
                            <input type="hidden" name="action" value="login">
                            <input type="hidden" name="role" value="supervisor">
                            
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="password" class="form-label fw-bold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                                </div>
                            </div>
                            
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-nsukka">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login as Supervisor
                                </button>
                            </div>
                        </form>
                        
                        <div class="text-center">
                            <a href="../index.php" class="back-link">
                                <i class="fas fa-arrow-left me-1"></i>Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 