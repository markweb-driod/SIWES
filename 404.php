<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | SIWES Logbook</title>
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
            --gradient-primary: linear-gradient(135deg, #1a4d2e 0%, #2d5a3d 50%, #4a7c59 100%);
            --gradient-secondary: linear-gradient(135deg, #d4af37 0%, #f4d03f 100%);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: var(--nsuk-cream);
            color: var(--nsuk-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .error-container {
            text-align: center;
            max-width: 600px;
            padding: 2rem;
        }
        
        .error-code {
            font-size: 8rem;
            font-weight: 900;
            color: var(--nsuk-primary);
            margin-bottom: 1rem;
            text-shadow: 0 4px 20px rgba(26, 77, 46, 0.3);
        }
        
        .error-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--nsuk-primary);
            margin-bottom: 1rem;
        }
        
        .error-message {
            font-size: 1.2rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .btn-home {
            background: var(--gradient-primary);
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 30px rgba(26, 77, 46, 0.2);
        }
        
        .btn-home:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(26, 77, 46, 0.3);
            color: white;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2rem;
            color: white;
            box-shadow: 0 10px 30px rgba(26, 77, 46, 0.2);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="logo">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="error-code">404</div>
        <h1 class="error-title">Page Not Found</h1>
        <p class="error-message">
            The page you're looking for doesn't exist. It might have been moved, deleted, or you entered the wrong URL.
        </p>
        <a href="index.php" class="btn-home">
            <i class="fas fa-home"></i>
            Go to Homepage
        </a>
    </div>
</body>
</html> 