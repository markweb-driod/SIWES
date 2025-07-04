<?php
session_start();
require_once 'backend/config/db.php';
require_once 'backend/config/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Features - SIWES Electronic Logbook</title>
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
            background: var(--nsuk-cream);
            color: var(--text-primary);
            overflow-x: hidden;
        }
        
        /* Header */
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(26, 77, 46, 0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .header.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: var(--shadow-soft);
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.8rem;
            color: var(--nsuk-primary) !important;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .navbar-brand img {
            height: 45px;
            width: auto;
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--text-primary) !important;
            position: relative;
            padding: 0.75rem 1.25rem !important;
            transition: all 0.3s ease;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--gradient-secondary);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after {
            width: 80%;
        }
        
        .nav-link:hover {
            color: var(--nsuk-primary) !important;
        }
        
        /* Hero Section */
        .hero-section {
            background: var(--gradient-primary);
            padding: 150px 0 100px;
            position: relative;
            overflow: hidden;
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
        
        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
        }
        
        .hero-title {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            margin-bottom: 1rem;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }
        
        /* Features Section */
        .features-section {
            padding: 100px 0;
            background: white;
        }
        
        .section-title {
            font-size: clamp(2rem, 4vw, 3.5rem);
            font-weight: 800;
            color: var(--nsuk-primary);
            text-align: center;
            margin-bottom: 1rem;
        }
        
        .section-subtitle {
            font-size: 1.2rem;
            color: var(--text-secondary);
            text-align: center;
            margin-bottom: 4rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .feature-card {
            background: white;
            border-radius: 20px;
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
            height: 4px;
            background: var(--gradient-secondary);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-strong);
        }
        
        .feature-card:hover::before {
            transform: scaleX(1);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2rem;
            color: white;
            background: var(--gradient-primary);
            box-shadow: var(--shadow-medium);
        }
        
        .feature-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--nsuk-primary);
            margin-bottom: 1rem;
            text-align: center;
        }
        
        .feature-description {
            color: var(--text-secondary);
            text-align: center;
            line-height: 1.6;
        }
        
        /* Detailed Features */
        .detailed-features {
            padding: 100px 0;
            background: var(--nsuk-light);
        }
        
        .feature-item {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-soft);
            transition: all 0.3s ease;
            border: 1px solid rgba(26, 77, 46, 0.1);
        }
        
        .feature-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-medium);
        }
        
        .feature-item-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            background: var(--gradient-primary);
            margin-bottom: 1.5rem;
        }
        
        .feature-item-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--nsuk-primary);
            margin-bottom: 1rem;
        }
        
        .feature-item-description {
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 1rem;
        }
        
        .feature-benefits {
            list-style: none;
            padding: 0;
        }
        
        .feature-benefits li {
            padding: 0.5rem 0;
            color: var(--text-secondary);
            position: relative;
            padding-left: 1.5rem;
        }
        
        .feature-benefits li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--nsuk-accent);
            font-weight: bold;
        }
        
        /* CTA Section */
        .cta-section {
            background: var(--gradient-primary);
            padding: 100px 0;
            text-align: center;
            color: white;
            position: relative;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
        }
        
        .cta-content {
            position: relative;
            z-index: 2;
        }
        
        .cta-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        
        .cta-description {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .btn-cta {
            background: var(--gradient-secondary);
            color: var(--nsuk-dark);
            border: none;
            border-radius: 50px;
            padding: 1rem 2.5rem;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.4s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: var(--shadow-medium);
        }
        
        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-strong);
            color: var(--nsuk-dark);
        }
        
        /* Footer */
        .footer {
            background: var(--nsuk-dark);
            color: white;
            padding: 80px 0 40px;
        }
        
        .footer h5 {
            color: var(--nsuk-gold);
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
            display: block;
            margin-bottom: 0.5rem;
        }
        
        .footer-links a:hover {
            color: var(--nsuk-gold);
        }
        
        .social-links a {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.5rem;
            margin-right: 1rem;
            transition: color 0.3s ease;
        }
        
        .social-links a:hover {
            color: var(--nsuk-gold);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            margin-top: 3rem;
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
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .feature-card {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header" id="header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <img src="assets/images/logo.jpg" alt="NSUK Logo">
                    SIWES Logbook
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="features.php">Features</a>
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

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content fade-in-up">
                <h1 class="hero-title">Revolutionary Features</h1>
                <p class="hero-subtitle">
                    Discover the cutting-edge capabilities that make our SIWES Electronic Logbook System 
                    the preferred choice for industrial training documentation.
                </p>
            </div>
        </div>
    </section>

    <!-- Core Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Core Features</h2>
                <p class="section-subtitle">
                    Our comprehensive suite of features designed to streamline your SIWES experience
                </p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
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
                    <div class="feature-card">
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
                    <div class="feature-card">
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

    <!-- Detailed Features Section -->
    <section class="detailed-features">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Detailed Features</h2>
                <p class="section-subtitle">
                    Explore the advanced capabilities that set our system apart
                </p>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="feature-item">
                        <div class="feature-item-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h4 class="feature-item-title">Mobile-First Design</h4>
                        <p class="feature-item-description">
                            Access your logbook from any device with our responsive mobile-first design. 
                            Perfect for on-the-go logging and real-time updates.
                        </p>
                        <ul class="feature-benefits">
                            <li>Responsive design works on all devices</li>
                            <li>Offline capability for remote areas</li>
                            <li>Touch-friendly interface</li>
                            <li>Fast loading times</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="feature-item">
                        <div class="feature-item-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 class="feature-item-title">Advanced Security</h4>
                        <p class="feature-item-description">
                            Enterprise-grade security ensures your data is protected with encryption, 
                            secure authentication, and regular backups.
                        </p>
                        <ul class="feature-benefits">
                            <li>End-to-end encryption</li>
                            <li>Two-factor authentication</li>
                            <li>Regular security audits</li>
                            <li>GDPR compliant</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="feature-item">
                        <div class="feature-item-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h4 class="feature-item-title">Comprehensive Reporting</h4>
                        <p class="feature-item-description">
                            Generate detailed reports and analytics to track your progress and meet 
                            institutional requirements with ease.
                        </p>
                        <ul class="feature-benefits">
                            <li>Custom report generation</li>
                            <li>Progress tracking</li>
                            <li>Export to PDF/Excel</li>
                            <li>Historical data analysis</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="feature-item">
                        <div class="feature-item-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4 class="feature-item-title">Multi-Role Support</h4>
                        <p class="feature-item-description">
                            Support for students, supervisors, and administrators with role-based 
                            access control and customized interfaces.
                        </p>
                        <ul class="feature-benefits">
                            <li>Student logbook management</li>
                            <li>Supervisor review tools</li>
                            <li>Admin dashboard</li>
                            <li>Role-based permissions</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="feature-item">
                        <div class="feature-item-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h4 class="feature-item-title">Smart Notifications</h4>
                        <p class="feature-item-description">
                            Stay informed with intelligent notifications for approvals, deadlines, 
                            and important updates.
                        </p>
                        <ul class="feature-benefits">
                            <li>Real-time notifications</li>
                            <li>Email alerts</li>
                            <li>SMS reminders</li>
                            <li>Customizable preferences</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="feature-item">
                        <div class="feature-item-icon">
                            <i class="fas fa-database"></i>
                        </div>
                        <h4 class="feature-item-title">Data Integration</h4>
                        <p class="feature-item-description">
                            Seamless integration with existing university systems and third-party 
                            applications for enhanced functionality.
                        </p>
                        <ul class="feature-benefits">
                            <li>API integration</li>
                            <li>Student portal sync</li>
                            <li>Third-party plugins</li>
                            <li>Data migration tools</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Ready to Get Started?</h2>
                <p class="cta-description">
                    Join thousands of students and supervisors who are already using our 
                    advanced SIWES Electronic Logbook System.
                </p>
                <a href="student/register.php" class="btn-cta">
                    <i class="fas fa-user-plus"></i>
                    Register Now
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>SIWES Electronic Logbook</h5>
                    <p style="color: rgba(255, 255, 255, 0.8); margin-bottom: 1.5rem;">
                        Revolutionizing industrial training documentation for Nigerian students with 
                        cutting-edge technology and user-friendly interfaces.
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
                        <a href="index.php">Home</a>
                        <a href="features.php">Features</a>
                        <a href="about.php">About</a>
                        <a href="contact.php">Contact</a>
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
        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html> 