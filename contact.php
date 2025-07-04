<?php
session_start();
require_once 'backend/config/db.php';
require_once 'backend/config/session.php';

// Handle contact form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message_text = trim($_POST['message'] ?? '');
    
    if (empty($name) || empty($email) || empty($subject) || empty($message_text)) {
        $message = '<div class="alert alert-danger">Please fill in all fields.</div>';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = '<div class="alert alert-danger">Please enter a valid email address.</div>';
    } else {
        // Here you would typically save to database or send email
        // For now, we'll just show a success message
        $message = '<div class="alert alert-success">Thank you for your message! We will get back to you soon.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - SIWES Electronic Logbook</title>
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
        
        /* Contact Section */
        .contact-section {
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
        
        .contact-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(26, 77, 46, 0.1);
            transition: all 0.3s ease;
        }
        
        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-medium);
        }
        
        .form-control {
            border: 2px solid rgba(26, 77, 46, 0.1);
            border-radius: 15px;
            padding: 1rem 1.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
        }
        
        .form-control:focus {
            border-color: var(--nsuk-accent);
            box-shadow: 0 0 0 0.2rem rgba(74, 124, 89, 0.25);
            background: white;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--nsuk-primary);
            margin-bottom: 0.5rem;
        }
        
        .btn-submit {
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 1rem 2.5rem;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.4s ease;
            box-shadow: var(--shadow-medium);
        }
        
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-strong);
            color: white;
        }
        
        /* Contact Info Section */
        .contact-info-section {
            padding: 100px 0;
            background: var(--nsuk-light);
        }
        
        .contact-info-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: var(--shadow-soft);
            text-align: center;
            border: 1px solid rgba(26, 77, 46, 0.1);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .contact-info-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-medium);
        }
        
        .contact-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
            background: var(--gradient-primary);
            box-shadow: var(--shadow-medium);
        }
        
        .contact-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--nsuk-primary);
            margin-bottom: 1rem;
        }
        
        .contact-details {
            color: var(--text-secondary);
            line-height: 1.6;
        }
        
        .contact-details a {
            color: var(--nsuk-accent);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .contact-details a:hover {
            color: var(--nsuk-primary);
        }
        
        /* Map Section */
        .map-section {
            padding: 100px 0;
            background: white;
        }
        
        .map-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(26, 77, 46, 0.1);
        }
        
        .map-placeholder {
            background: var(--nsuk-light);
            border-radius: 15px;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--nsuk-accent);
            font-size: 1.2rem;
            font-weight: 600;
            border: 2px dashed var(--nsuk-accent);
        }
        
        /* FAQ Section */
        .faq-section {
            padding: 100px 0;
            background: var(--nsuk-light);
        }
        
        .faq-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: var(--shadow-soft);
            margin-bottom: 2rem;
            border: 1px solid rgba(26, 77, 46, 0.1);
            transition: all 0.3s ease;
        }
        
        .faq-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-medium);
        }
        
        .faq-question {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--nsuk-primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .faq-question i {
            color: var(--nsuk-accent);
            font-size: 1.5rem;
        }
        
        .faq-answer {
            color: var(--text-secondary);
            line-height: 1.6;
            padding-left: 2.5rem;
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
            
            .contact-card, .contact-info-card, .map-card, .faq-card {
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
                            <a class="nav-link" href="about.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="contact.php">Contact</a>
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
                <h1 class="hero-title">Get in Touch</h1>
                <p class="hero-subtitle">
                    Have questions about our SIWES Electronic Logbook System? We're here to help. 
                    Reach out to us for support, feedback, or any inquiries.
                </p>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Send us a Message</h2>
                <p class="section-subtitle">
                    We'd love to hear from you. Send us a message and we'll respond as soon as possible.
                </p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact-card">
                        <?php echo $message; ?>
                        <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject" required>
                            </div>
                            <div class="mb-4">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-submit">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Info Section -->
    <section class="contact-info-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Contact Information</h2>
                <p class="section-subtitle">
                    Get in touch with us through various channels
                </p>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="contact-info-card">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4 class="contact-title">Visit Us</h4>
                        <p class="contact-details">
                            Nasarawa State University<br>
                            Keffi, Nasarawa State<br>
                            Nigeria
                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="contact-info-card">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h4 class="contact-title">Call Us</h4>
                        <p class="contact-details">
                            <a href="tel:+234XXXXXXXXX">+234 XXX XXX XXXX</a><br>
                            <a href="tel:+234XXXXXXXXX">+234 XXX XXX XXXX</a><br>
                            Monday - Friday, 8:00 AM - 5:00 PM
                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="contact-info-card">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4 class="contact-title">Email Us</h4>
                        <p class="contact-details">
                            <a href="mailto:siwes@nsuk.edu.ng">siwes@nsuk.edu.ng</a><br>
                            <a href="mailto:support@siwes.edu.ng">support@siwes.edu.ng</a><br>
                            We'll respond within 24 hours
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Find Us</h2>
                <p class="section-subtitle">
                    Visit our campus at Nasarawa State University, Keffi
                </p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="map-card">
                        <div class="map-placeholder">
                            <div>
                                <i class="fas fa-map-marked-alt me-3"></i>
                                Interactive Map Coming Soon
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Frequently Asked Questions</h2>
                <p class="section-subtitle">
                    Find answers to common questions about our SIWES system
                </p>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="faq-card">
                        <h4 class="faq-question">
                            <i class="fas fa-question-circle"></i>
                            How do I register for SIWES?
                        </h4>
                        <p class="faq-answer">
                            Registration for SIWES is typically done through your department. 
                            Contact your SIWES coordinator for registration details and requirements.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="faq-card">
                        <h4 class="faq-question">
                            <i class="fas fa-question-circle"></i>
                            How often should I update my logbook?
                        </h4>
                        <p class="faq-answer">
                            Students are required to update their logbook daily with their activities, 
                            learning outcomes, and experiences during their industrial training.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="faq-card">
                        <h4 class="faq-question">
                            <i class="fas fa-question-circle"></i>
                            What if I forget my password?
                        </h4>
                        <p class="faq-answer">
                            You can reset your password using the "Forgot Password" link on the login page. 
                            A reset link will be sent to your registered email address.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="faq-card">
                        <h4 class="faq-question">
                            <i class="fas fa-question-circle"></i>
                            How do supervisors review my entries?
                        </h4>
                        <p class="faq-answer">
                            Supervisors receive notifications when you submit new entries. They can review, 
                            approve, or request modifications through their dashboard.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="faq-card">
                        <h4 class="faq-question">
                            <i class="fas fa-question-circle"></i>
                            Is the system available on mobile devices?
                        </h4>
                        <p class="faq-answer">
                            Yes! Our system is fully responsive and works on all devices including 
                            smartphones and tablets for convenient on-the-go logging.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="faq-card">
                        <h4 class="faq-question">
                            <i class="fas fa-question-circle"></i>
                            How secure is my data?
                        </h4>
                        <p class="faq-answer">
                            We use enterprise-grade security measures including encryption, secure 
                            authentication, and regular backups to protect your data.
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