<?php
session_start();
require_once 'backend/config/db.php';
require_once 'backend/config/session.php';

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    $role = $_SESSION['role'];
    switch ($role) {
        case 'student':
            header('Location: student/dashboard.php');
            exit();
        case 'supervisor':
            header('Location: supervisor/dashboard.php');
            exit();
        case 'admin':
            header('Location: admin/dashboard.php');
            exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIWES Electronic Logbook - Nasarawa State University</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
            --gradient-hero: linear-gradient(135deg, #1a4d2e 0%, #2d5a3d 30%, #4a7c59 70%, #6b8e7a 100%);
            --shadow-soft: 0 10px 30px rgba(26, 77, 46, 0.1);
            --shadow-medium: 0 20px 40px rgba(26, 77, 46, 0.15);
            --shadow-strong: 0 30px 60px rgba(26, 77, 46, 0.2);
            --shadow-gold: 0 10px 30px rgba(212, 175, 55, 0.3);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: var(--nsuk-cream);
            color: var(--text-primary);
            overflow-x: hidden;
            line-height: 1.6;
        }
        
        /* Enhanced Header */
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(26, 77, 46, 0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            transition: all 0.4s ease;
            padding: 0.5rem 0;
        }
        
        .header.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: var(--shadow-soft);
            padding: 0.25rem 0;
        }
        
        .navbar-brand {
            font-weight: 900;
            font-size: 1.8rem;
            color: var(--nsuk-primary) !important;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        
        .navbar-brand img {
            height: 50px;
            width: auto;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }
        
        .nav-link {
            font-weight: 600;
            color: var(--text-primary) !important;
            position: relative;
            padding: 0.75rem 1.25rem !important;
            transition: all 0.3s ease;
            border-radius: 25px;
            margin: 0 0.25rem;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 3px;
            background: var(--gradient-secondary);
            transition: all 0.3s ease;
            transform: translateX(-50%);
            border-radius: 2px;
        }
        
        .nav-link:hover::after {
            width: 80%;
        }
        
        .nav-link:hover {
            color: var(--nsuk-primary) !important;
            background: rgba(26, 77, 46, 0.05);
        }
        
        /* Enhanced Hero Section */
        .hero-section {
            min-height: 100vh;
            background: var(--gradient-hero);
            position: relative;
            display: flex;
            align-items: center;
            overflow: hidden;
            padding: 120px 0 80px;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        
        .hero-section::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 20%, rgba(212, 175, 55, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 70% 80%, rgba(74, 124, 89, 0.1) 0%, transparent 50%);
        }
        
        .hero-content {
            position: relative;
            z-index: 3;
        }
        
        .hero-title {
            font-size: clamp(3rem, 6vw, 5rem);
            font-weight: 900;
            color: white;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        
        .hero-title .highlight {
            background: var(--gradient-secondary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: none;
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 2.5rem;
            line-height: 1.7;
            max-width: 600px;
            font-weight: 400;
        }
        
        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            margin-bottom: 3rem;
            align-items: center;
        }
        
        .btn-hero {
            padding: 1rem 2rem;
            font-weight: 700;
            font-size: 1rem;
            border-radius: 50px;
            border: none;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: var(--shadow-medium);
            min-width: 160px;
            justify-content: center;
        }
        
        .btn-primary-hero {
            background: var(--gradient-secondary);
            color: var(--nsuk-dark);
        }
        
        .btn-primary-hero:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-gold);
            color: var(--nsuk-dark);
        }
        
        .btn-outline-hero {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }
        
        .btn-outline-hero:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: white;
            color: white;
            transform: translateY(-5px);
        }
        
        .hero-image-container {
            position: relative;
            z-index: 3;
        }
        
        .hero-image {
            width: 100%;
            max-width: 600px;
            border-radius: 25px;
            box-shadow: var(--shadow-strong);
            transition: all 0.4s ease;
        }
        
        .hero-image:hover {
            transform: scale(1.02);
            box-shadow: 0 40px 80px rgba(26, 77, 46, 0.3);
        }
        
        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            z-index: 1;
        }
        
        .floating-element {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        .floating-element:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .floating-element:nth-child(2) {
            width: 60px;
            height: 60px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }
        
        .floating-element:nth-child(3) {
            width: 40px;
            height: 40px;
            bottom: 30%;
            left: 20%;
            animation-delay: 4s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        /* Enhanced Features Section */
        .features-section {
            padding: 120px 0;
            background: white;
            position: relative;
        }
        
        .features-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(to bottom, var(--nsuk-cream), white);
        }
        
        .section-title {
            font-size: clamp(2rem, 4vw, 3.5rem);
            font-weight: 900;
            color: var(--nsuk-primary);
            text-align: center;
            margin-bottom: 1rem;
            position: relative;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--gradient-secondary);
            border-radius: 2px;
        }
        
        .section-subtitle {
            font-size: 1.1rem;
            color: var(--text-secondary);
            text-align: center;
            margin-bottom: 4rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            font-weight: 400;
        }
        
        .feature-card {
            background: white;
            border-radius: 25px;
            padding: 3rem 2rem;
            box-shadow: var(--shadow-soft);
            transition: all 0.4s ease;
            border: 1px solid rgba(26, 77, 46, 0.1);
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--gradient-secondary);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-15px);
            box-shadow: var(--shadow-strong);
        }
        
        .feature-card:hover::before {
            transform: scaleX(1);
        }
        
        .feature-icon {
            width: 90px;
            height: 90px;
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2.2rem;
            color: white;
            background: var(--gradient-primary);
            box-shadow: var(--shadow-medium);
            transition: all 0.3s ease;
        }
        
        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }
        
        .feature-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--nsuk-primary);
            margin-bottom: 1rem;
            text-align: center;
        }
        
        .feature-description {
            color: var(--text-secondary);
            text-align: center;
            line-height: 1.6;
            font-size: 0.95rem;
        }
        
        /* Enhanced Stats Section */
        .stats-section {
            background: var(--gradient-primary);
            padding: 120px 0;
            position: relative;
        }
        
        .stats-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
        }
        
        .stat-item {
            text-align: center;
            color: white;
            position: relative;
            z-index: 2;
            padding: 2rem 1rem;
        }
        
        .stat-number {
            font-size: 4rem;
            font-weight: 900;
            color: var(--nsuk-gold);
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            display: block;
        }
        
        .stat-label {
            font-size: 1.2rem;
            font-weight: 600;
            opacity: 0.95;
        }
        
        /* Enhanced Login Section */
        .login-section {
            padding: 120px 0;
            background: var(--nsuk-light);
            position: relative;
        }
        
        .login-container {
            background: white;
            border-radius: 30px;
            box-shadow: var(--shadow-strong);
            overflow: hidden;
            border: 1px solid rgba(26, 77, 46, 0.1);
            position: relative;
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
        
        .login-card {
            padding: 3.5rem 2rem;
            text-align: center;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            border-right: 1px solid rgba(26, 77, 46, 0.1);
        }
        
        .login-card:last-child {
            border-right: none;
        }
        
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--gradient-primary);
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        
        .login-card:hover::before {
            opacity: 0.05;
        }
        
        .login-card:hover {
            transform: translateY(-8px);
        }
        
        .login-icon {
            width: 80px;
            height: 80px;
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2rem;
            color: white;
            background: var(--gradient-primary);
            box-shadow: var(--shadow-medium);
            transition: all 0.3s ease;
        }
        
        .login-card:hover .login-icon {
            transform: scale(1.1);
        }
        
        .login-title {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--nsuk-primary);
            margin-bottom: 0.5rem;
        }
        
        .login-description {
            color: var(--text-secondary);
            margin-bottom: 2rem;
            font-size: 0.9rem;
            line-height: 1.5;
        }
        
        .btn-login {
            background: var(--gradient-primary);
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 25px;
            border: none;
            font-weight: 700;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: var(--shadow-medium);
        }
        
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-strong);
            color: white;
        }
        
        /* Enhanced Footer */
        .footer {
            background: var(--nsuk-dark);
            color: white;
            padding: 100px 0 40px;
            position: relative;
        }
        
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--gradient-secondary);
        }
        
        .footer h5 {
            color: var(--nsuk-gold);
            font-weight: 800;
            margin-bottom: 1.5rem;
            font-size: 1.3rem;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
            display: block;
            margin-bottom: 0.75rem;
            font-weight: 500;
        }
        
        .footer-links a:hover {
            color: var(--nsuk-gold);
        }
        
        .social-links a {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.8rem;
            margin-right: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            color: var(--nsuk-gold);
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            margin-top: 3rem;
        }
        
        /* Enhanced Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.8s ease forwards;
        }
        
        .slide-in-left {
            animation: slideInLeft 0.8s ease forwards;
        }
        
        .slide-in-right {
            animation: slideInRight 0.8s ease forwards;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .btn-hero {
                padding: 0.875rem 1.5rem;
                font-size: 0.9rem;
                min-width: 140px;
            }
            
            .feature-card {
                padding: 2rem 1.5rem;
            }
            
            .login-card {
                border-right: none;
                border-bottom: 1px solid rgba(26, 77, 46, 0.1);
            }
            
            .login-card:last-child {
                border-bottom: none;
            }
            
            .stat-number {
                font-size: 2.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .hero-buttons {
                flex-direction: column;
                align-items: center;
                gap: 1rem;
            }
            
            .btn-hero {
                width: 100%;
                max-width: 280px;
                justify-content: center;
                padding: 0.875rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Enhanced Header -->
    <header class="header" id="header">
        <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                    <img src="assets/images/logo.jpg" alt="NSUK Logo">
                    SIWES Logbook
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                            <a class="nav-link" href="features.php">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                            <a class="nav-link" href="student/login.php">Student Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    </header>

    <!-- Enhanced Hero Section -->
    <section class="hero-section">
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>
        <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                    <div class="hero-content slide-in-left">
                        <h1 class="hero-title">
                            SIWES Electronic<br>
                            <span class="highlight">Logbook System</span>
                        </h1>
                    <p class="hero-subtitle">
                            Experience the future of industrial training documentation. Track your progress, 
                            capture real-time location data, and maintain comprehensive records with our 
                            advanced electronic logbook system designed for Nasarawa State University.
                        </p>
                        <div class="hero-buttons">
                            <a href="student/login.php" class="btn-hero btn-primary-hero">
                                <i class="fas fa-user-graduate"></i>
                                Student Login
                            </a>
                            <a href="student/register.php" class="btn-hero btn-outline-hero">
                                <i class="fas fa-user-plus"></i>
                                Register Now
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image-container slide-in-right" style="animation-delay: 0.2s;">
                        <img src="assets/images/lander.png" alt="SIWES Electronic Logbook" class="hero-image">
            </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Features Section -->
    <section id="features" class="features-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Revolutionary Features</h2>
                <p class="section-subtitle">
                    Discover the cutting-edge capabilities that make our SIWES system the preferred choice 
                    for industrial training documentation and management.
                </p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card fade-in-up">
                        <div class="feature-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4 class="feature-title">GPS Location Tracking</h4>
                        <p class="feature-description">
                            Advanced GPS technology automatically captures and verifies your location for each log entry, 
                            ensuring authenticity and compliance with training requirements.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card fade-in-up" style="animation-delay: 0.2s;">
                        <div class="feature-icon">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <h4 class="feature-title">Real-time Supervisor Review</h4>
                        <p class="feature-description">
                            Get instant feedback from supervisors with our real-time approval and rejection system, 
                            complete with detailed comments and progress tracking.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card fade-in-up" style="animation-delay: 0.4s;">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4 class="feature-title">Advanced Analytics</h4>
                        <p class="feature-description">
                            Comprehensive analytics and reporting features help you track your progress, 
                            identify areas for improvement, and maintain detailed training records.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Statistics Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-item fade-in-up">
                        <span class="stat-number">500+</span>
                        <div class="stat-label">Active Students</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item fade-in-up" style="animation-delay: 0.1s;">
                        <span class="stat-number">50+</span>
                        <div class="stat-label">Supervisors</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item fade-in-up" style="animation-delay: 0.2s;">
                        <span class="stat-number">10,000+</span>
                        <div class="stat-label">Log Entries</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item fade-in-up" style="animation-delay: 0.3s;">
                        <span class="stat-number">95%</span>
                        <div class="stat-label">Approval Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Login Section -->
    <section id="login" class="login-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Access Your Account</h2>
                <p class="section-subtitle">
                    Choose your role to access the advanced SIWES electronic logbook system
                </p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="login-container">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <div class="login-card fade-in-up">
                                    <div class="login-icon">
                                        <i class="fas fa-user-graduate"></i>
                            </div>
                                    <h5 class="login-title">Student</h5>
                                    <p class="login-description">
                                        Access your SIWES logbook and track your industrial training progress with real-time updates
                                    </p>
                                    <a href="student/login.php" class="btn-login">
                                        <i class="fas fa-sign-in-alt"></i>
                                        Login
                                    </a>
                                </div>
                                </div>
                            <div class="col-md-4">
                                <div class="login-card fade-in-up" style="animation-delay: 0.2s;">
                                    <div class="login-icon">
                                        <i class="fas fa-user-tie"></i>
                                    </div>
                                    <h5 class="login-title">Supervisor</h5>
                                    <p class="login-description">
                                        Review and approve student log entries with detailed feedback and progress monitoring
                                    </p>
                                    <a href="supervisor/login.php" class="btn-login">
                                        <i class="fas fa-sign-in-alt"></i>
                                        Login
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="login-card fade-in-up" style="animation-delay: 0.4s;">
                                    <div class="login-icon">
                                        <i class="fas fa-user-shield"></i>
                                    </div>
                                    <h5 class="login-title">Coordinator</h5>
                                    <p class="login-description">
                                        Manage system settings and oversee all SIWES activities with comprehensive controls
                                    </p>
                                    <a href="admin/login.php" class="btn-login">
                                        <i class="fas fa-sign-in-alt"></i>
                                        Login
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>SIWES Electronic Logbook</h5>
                    <p style="color: rgba(255, 255, 255, 0.8); margin-bottom: 1.5rem;">
                        Revolutionizing industrial training documentation for Nigerian students with 
                        cutting-edge technology and user-friendly interfaces designed for excellence.
                    </p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold" style="color: var(--nsuk-gold);">Quick Links</h6>
                    <div class="footer-links">
                        <a href="features.php">Features</a>
                        <a href="student/register.php">Student Registration</a>
                        <a href="about.php">About SIWES</a>
                        <a href="contact.php">Contact Us</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold" style="color: var(--nsuk-gold);">Contact Information</h6>
                    <div class="footer-links">
                        <p style="color: rgba(255, 255, 255, 0.8); margin-bottom: 0.5rem;">
                            <i class="fas fa-map-marker-alt me-2"></i>Nasarawa State University, Keffi
                        </p>
                        <p style="color: rgba(255, 255, 255, 0.8); margin-bottom: 0.5rem;">
                            <i class="fas fa-phone me-2"></i>+234 XXX XXX XXXX
                        </p>
                        <p style="color: rgba(255, 255, 255, 0.8); margin-bottom: 0;">
                            <i class="fas fa-envelope me-2"></i>siwes@nsuk.edu.ng
                        </p>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="row">
                    <div class="col-md-6">
                        <p style="color: rgba(255, 255, 255, 0.7); margin-bottom: 0;">
                        &copy; <?php echo date('Y'); ?> SIWES Logbook System. All rights reserved.
                    </p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p style="color: rgba(255, 255, 255, 0.7); margin-bottom: 0;">
                            Powered by Nasarawa State University, Keffi
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Enhanced header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
        
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        // Observe elements for animation
        document.querySelectorAll('.feature-card, .stat-item, .login-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s ease';
            observer.observe(el);
        });
    </script>
</body>
</html> 