<?php
session_start();
require_once '../backend/config/db.php';
require_once '../backend/config/session.php';

// Check if user is already logged in
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'student') {
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login - SIWES Logbook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --nsuk-primary: #1a4d2e;
            --nsuk-secondary: #2d5a3d;
            --nsuk-accent: #4a7c59;
            --nsuk-gold: #d4af37;
            --nsuk-cream: #f8f6f0;
            --nsuk-dark: #0f2b1a;
            --nsuk-light: #e8f5e8;
            --text-primary: #2c3e50;
            --text-secondary: #6c757d;
            --gradient-primary: linear-gradient(135deg, #1a4d2e 0%, #2d5a3d 50%, #4a7c59 100%);
            --gradient-secondary: linear-gradient(135deg, #d4af37 0%, #f4d03f 100%);
            --shadow-soft: 0 10px 30px rgba(26, 77, 46, 0.1);
            --shadow-medium: 0 20px 40px rgba(26, 77, 46, 0.15);
            --shadow-strong: 0 30px 60px rgba(26, 77, 46, 0.2);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: var(--gradient-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            box-shadow: var(--shadow-strong);
            max-width: 500px;
            width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 2;
            overflow: hidden;
        }
        
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--gradient-secondary);
        }
        
        .login-header {
            background: var(--gradient-primary);
            color: white;
            padding: 3rem 2.5rem 2rem;
            text-align: center;
            position: relative;
        }
        
        .login-header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 20px solid transparent;
            border-right: 20px solid transparent;
            border-top: 20px solid var(--nsuk-primary);
        }
        
        .university-logo {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .login-header h2 {
            font-weight: 800;
            font-size: 2rem;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        
        .login-header p {
            margin-bottom: 0;
            opacity: 0.9;
            font-size: 1.1rem;
        }
        
        .login-body {
            padding: 3rem 2.5rem 2.5rem;
        }
        
        .form-group {
            margin-bottom: 2rem;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--nsuk-primary);
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .input-group {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--shadow-soft);
        }
        
        .input-group-text {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 1rem 1.25rem;
            font-size: 1.1rem;
        }
        
        .form-control {
            border: none;
            padding: 1rem 1.25rem;
            font-size: 1rem;
            background: white;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            box-shadow: none;
            background: #f8f9fa;
        }
        
        .form-control::placeholder {
            color: var(--text-secondary);
            opacity: 0.7;
        }
        
        .btn-login {
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: 15px;
            padding: 1rem 2.5rem;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.4s ease;
            box-shadow: var(--shadow-medium);
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-strong);
            color: white;
        }
        
        .btn-login:active {
            transform: translateY(-1px);
        }
        
        .alert {
            border-radius: 15px;
            border: none;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            font-weight: 500;
        }
        
        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border-left: 4px solid #dc3545;
        }
        
        .alert-success {
            background: rgba(25, 135, 84, 0.1);
            color: #198754;
            border-left: 4px solid #198754;
        }
        
        .login-footer {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(26, 77, 46, 0.1);
        }
        
        .login-footer p {
            color: var(--text-secondary);
            margin-bottom: 1rem;
            font-size: 0.95rem;
        }
        
        .btn-register {
            background: transparent;
            color: var(--nsuk-primary);
            border: 2px solid var(--nsuk-primary);
            border-radius: 25px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 1.5rem;
        }
        
        .btn-register:hover {
            background: var(--nsuk-primary);
            color: white;
            transform: translateY(-2px);
        }
        
        .back-link {
            color: var(--nsuk-primary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .back-link:hover {
            color: var(--nsuk-secondary);
            transform: translateX(-5px);
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.8s ease forwards;
        }
        
        /* Responsive */
        @media (max-width: 576px) {
            .login-container {
                margin: 1rem;
                border-radius: 20px;
            }
            
            .login-header {
                padding: 2rem 1.5rem 1.5rem;
            }
            
            .login-body {
                padding: 2rem 1.5rem 1.5rem;
            }
            
            .login-header h2 {
                font-size: 1.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-container fade-in-up">
                    <div class="login-header">
                        <div class="university-logo">
                            <img src="../assets/images/nsuk-logo.png" alt="NSUK Logo" style="width: 50px; height: auto;">
                        </div>
                        <h2>Student Login</h2>
                        <p>Access your SIWES logbook</p>
                    </div>
                    
                    <div class="login-body">
                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?php echo htmlspecialchars($_GET['error']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($_GET['success'])): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                <?php echo htmlspecialchars($_GET['success']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <form action="../backend/api/auth.php" method="POST">
                            <input type="hidden" name="action" value="login">
                            <input type="hidden" name="role" value="student">
                            
                            <div class="form-group">
                                <label for="email" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           placeholder="Enter your email address" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" id="password" name="password" 
                                           placeholder="Enter your password" required>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn-login">
                                <i class="fas fa-sign-in-alt"></i>
                                Login to SIWES
                            </button>
                        </form>
                        
                        <div class="login-footer">
                            <p>Don't have an account?</p>
                            <a href="register.php" class="btn-register">
                                <i class="fas fa-user-plus"></i>
                                Register as Student
                            </a>
                            <br>
                            <a href="../index.php" class="back-link">
                                <i class="fas fa-arrow-left"></i>
                                Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 