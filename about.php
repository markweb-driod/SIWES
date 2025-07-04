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
    <title>About - SIWES Electronic Logbook</title>
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
        
        /* About Section */
        .about-section {
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
        
        .about-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: var(--shadow-soft);
            margin-bottom: 3rem;
            border: 1px solid rgba(26, 77, 46, 0.1);
            transition: all 0.3s ease;
        }
        
        .about-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-medium);
        }
        
        .about-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            font-size: 2rem;
            color: white;
            background: var(--gradient-primary);
            box-shadow: var(--shadow-medium);
        }
        
        .about-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--nsuk-primary);
            margin-bottom: 1rem;
        }
        
        .about-description {
            color: var(--text-secondary);
            line-height: 1.8;
            font-size: 1.1rem;
        }
        
        /* University Section */
        .university-section {
            padding: 100px 0;
            background: var(--nsuk-light);
        }
        
        .university-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: var(--shadow-soft);
            text-align: center;
            border: 1px solid rgba(26, 77, 46, 0.1);
        }
        
        .university-logo {
            width: 120px;
            height: 120px;
            border-radius: 20px;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            box-shadow: var(--shadow-medium);
        }
        
        .university-logo img {
            width: 80px;
            height: auto;
        }
        
        .university-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--nsuk-primary);
            margin-bottom: 1rem;
        }
        
        .university-subtitle {
            color: var(--nsuk-accent);
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        
        .university-description {
            color: var(--text-secondary);
            line-height: 1.8;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        
        .stat-item {
            text-align: center;
            padding: 1.5rem;
            background: rgba(26, 77, 46, 0.05);
            border-radius: 15px;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--nsuk-primary);
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: var(--text-secondary);
            font-weight: 500;
        }
        
        /* Mission Vision Section */
        .mission-vision {
            padding: 100px 0;
            background: white;
        }
        
        .mission-card, .vision-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: var(--shadow-soft);
            height: 100%;
            border: 1px solid rgba(26, 77, 46, 0.1);
            transition: all 0.3s ease;
        }
        
        .mission-card:hover, .vision-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-medium);
        }
        
        .mission-icon, .vision-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            font-size: 2rem;
            color: white;
            background: var(--gradient-primary);
            box-shadow: var(--shadow-medium);
        }
        
        .mission-title, .vision-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--nsuk-primary);
            margin-bottom: 1rem;
        }
        
        .mission-description, .vision-description {
            color: var(--text-secondary);
            line-height: 1.8;
            font-size: 1.1rem;
        }
        
        /* Team Section */
        .team-section {
            padding: 100px 0;
            background: var(--nsuk-light);
        }
        
        .team-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: var(--shadow-soft);
            text-align: center;
            border: 1px solid rgba(26, 77, 46, 0.1);
            transition: all 0.3s ease;
        }
        
        .team-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-medium);
        }
        
        .team-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.5rem;
            color: white;
            box-shadow: var(--shadow-medium);
        }
        
        .team-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--nsuk-primary);
            margin-bottom: 0.5rem;
        }
        
        .team-role {
            color: var(--nsuk-accent);
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .team-description {
            color: var(--text-secondary);
            line-height: 1.6;
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
            
            .about-card, .university-card, .mission-card, .vision-card, .team-card {
                padding: 2rem;
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
                            <a class="nav-link" href="features.php">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="about.php">About</a>
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
                <h1 class="hero-title">About SIWES</h1>
                <p class="hero-subtitle">
                    Learn about the Student Industrial Work Experience Scheme and how our electronic 
                    logbook system is revolutionizing industrial training documentation.
                </p>
            </div>
        </div>
    </section>

    <!-- About SIWES Section -->
    <section class="about-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">About SIWES</h2>
                <p class="section-subtitle">
                    Understanding the Student Industrial Work Experience Scheme
                </p>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="about-card">
                        <div class="about-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3 class="about-title">What is SIWES?</h3>
                        <p class="about-description">
                            The Student Industrial Work Experience Scheme (SIWES) is a skill training program designed 
                            to expose and prepare students of universities, polytechnics, and colleges of education 
                            for the industrial work situation they are likely to meet after graduation. It is a 
                            mandatory program for students in science, engineering, and technology-based courses.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-card">
                        <div class="about-icon">
                            <i class="fas fa-target"></i>
                        </div>
                        <h3 class="about-title">Objectives</h3>
                        <p class="about-description">
                            The primary objectives of SIWES include providing students with practical experience 
                            in their chosen fields, bridging the gap between theory and practice, and preparing 
                            students for the challenges of the real working environment. It also aims to enhance 
                            students' employability and career readiness.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- University Section -->
    <section class="university-section">
        <div class="container">
            <div class="university-card">
                <div class="university-logo">
                    <img src="assets/images/logo.jpg" alt="NSUK Logo">
                </div>
                <h2 class="university-title">Nasarawa State University, Keffi</h2>
                <p class="university-subtitle">Excellence in Education and Innovation</p>
                <p class="university-description">
                    Nasarawa State University, Keffi (NSUK) is a leading institution of higher learning 
                    committed to academic excellence, research, and community development. Established to 
                    provide quality education and produce well-rounded graduates, NSUK has been at the 
                    forefront of educational innovation and technological advancement.
                </p>
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number">20+</div>
                        <div class="stat-label">Years of Excellence</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">50+</div>
                        <div class="stat-label">Academic Programs</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">15,000+</div>
                        <div class="stat-label">Students</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Faculty Members</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Vision Section -->
    <section class="mission-vision">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Our Mission & Vision</h2>
                <p class="section-subtitle">
                    Driving innovation in industrial training documentation
                </p>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="mission-card">
                        <div class="mission-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3 class="mission-title">Our Mission</h3>
                        <p class="mission-description">
                            To provide a comprehensive, user-friendly electronic logbook system that streamlines 
                            the SIWES documentation process, ensuring accuracy, transparency, and efficiency 
                            in industrial training management while supporting the educational goals of 
                            Nasarawa State University, Keffi.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="vision-card">
                        <div class="vision-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3 class="vision-title">Our Vision</h3>
                        <p class="vision-description">
                            To become the leading digital platform for industrial training documentation, 
                            setting the standard for excellence in SIWES management across Nigerian 
                            universities and contributing to the development of world-class professionals 
                            through innovative technology solutions.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Development Team</h2>
                <p class="section-subtitle">
                    Meet the team behind the SIWES Electronic Logbook System
                </p>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="team-card">
                        <div class="team-avatar">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h4 class="team-name">SIWES Coordinator</h4>
                        <p class="team-role">Project Lead</p>
                        <p class="team-description">
                            Oversees the entire SIWES program and ensures smooth coordination between 
                            students, supervisors, and industrial partners.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="team-card">
                        <div class="team-avatar">
                            <i class="fas fa-code"></i>
                        </div>
                        <h4 class="team-name">Development Team</h4>
                        <p class="team-role">Technical Implementation</p>
                        <p class="team-description">
                            Responsible for developing and maintaining the electronic logbook system, 
                            ensuring reliability and user experience excellence.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="team-card">
                        <div class="team-avatar">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4 class="team-name">Support Team</h4>
                        <p class="team-role">User Support</p>
                        <p class="team-description">
                            Provides technical support and training to students, supervisors, and 
                            administrators using the system.
                        </p>
                    </div>
                </div>
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