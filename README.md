# SIWES Electronic Logbook System

A location-based electronic logbook system for SIWES (Students Industrial Work Experience Scheme) with role-based access for students, supervisors, and coordinators.

## 🚀 Features

- **Student Portal**: Log daily activities with GPS verification
- **Supervisor Portal**: Review and approve/reject student log entries
- **Admin Portal**: Manage users and generate reports
- **GPS Location Tracking**: HTML5 Geolocation API integration
- **Google Maps Integration**: Visual location verification
- **Role-based Authentication**: Secure access control
- **Responsive Design**: Works on desktop and mobile devices

## 🛠️ Technology Stack

- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Location Services**: HTML5 Geolocation API, Google Maps API
- **Authentication**: PHP Sessions

## 📁 Project Structure

```
/SIWES/
├── backend/
│   ├── api/
│   │   ├── auth.php          # Authentication endpoints
│   │   ├── student.php       # Student API
│   │   ├── supervisor.php    # Supervisor API
│   │   └── admin.php         # Admin API
│   ├── config/
│   │   ├── db.php           # Database configuration
│   │   └── session.php      # Session management
│   ├── models/
│   │   ├── User.php         # User model
│   │   └── LogEntry.php     # Log entry model
│   └── setup_database.php   # Database setup script
├── pages/
│   ├── index.html           # Homepage
│   ├── student-login.html   # Student login
│   ├── student-dashboard.html # Student dashboard
│   ├── student-log-entry.html # Add log entry
│   ├── admin-login.html     # Admin login
│   ├── admin-dashboard.html # Admin dashboard
│   └── register.html        # Student registration
└── README.md
```

## 🚀 Quick Setup

### 1. Database Setup

1. Create a MySQL database named `siwes_db`
2. Update database credentials in `backend/config/db.php`
3. Run the database setup script:

```bash
php backend/setup_database.php
```

### 2. Web Server Configuration

1. Place the project in your web server directory (e.g., `htdocs/` for XAMPP)
2. Ensure PHP is configured and running
3. Access the system via: `http://localhost/SIWES/pages/`

### 3. Google Maps API (Optional)

1. Get a Google Maps API key from [Google Cloud Console](https://console.cloud.google.com/)
2. Replace `YOUR_GOOGLE_MAPS_API_KEY` in `pages/student-log-entry.html`

## 👥 User Roles & Access

### Student
- **Login**: `pages/student-login.html`
- **Default Credentials**: `alice@student.com` / `student123`
- **Features**:
  - Add daily log entries with GPS location
  - View log history and status
  - Update profile information

### Supervisor
- **Login**: `pages/supervisor-login.html`
- **Default Credentials**: `supervisor@company.com` / `supervisor123`
- **Features**:
  - Review pending log entries
  - Approve/reject entries with comments
  - View student activities

### SIWES Coordinator (Admin)
- **Login**: `pages/admin-login.html`
- **Default Credentials**: `admin@siwes.com` / `admin123`
- **Features**:
  - Manage students and supervisors
  - Generate reports and analytics
  - System administration

## 📊 Database Schema

### Users Table
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    matric_number VARCHAR(50),
    department VARCHAR(100),
    institution VARCHAR(100),
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('student', 'supervisor', 'admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Log Entries Table
```sql
CREATE TABLE log_entries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    activity TEXT NOT NULL,
    date DATE NOT NULL,
    latitude VARCHAR(50),
    longitude VARCHAR(50),
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    supervisor_comment TEXT,
    supervisor_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id),
    FOREIGN KEY (supervisor_id) REFERENCES users(id)
);
```

## 🔧 API Endpoints

### Authentication (`/backend/api/auth.php`)
- `POST` - Login (student/supervisor/admin)
- `POST` - Register (students only)
- `POST` - Logout
- `POST` - Check authentication status

### Student API (`/backend/api/student.php`)
- `POST` - Dashboard data
- `POST` - Add log entry
- `POST` - Get log history
- `POST` - Update profile

### Supervisor API (`/backend/api/supervisor.php`)
- `POST` - Dashboard data
- `POST` - Get pending logs
- `POST` - Approve/reject logs

### Admin API (`/backend/api/admin.php`)
- `POST` - Dashboard statistics
- `POST` - Manage users
- `POST` - Generate reports

## 🎨 Frontend Features

- **Responsive Design**: Bootstrap 5 for mobile-friendly interface
- **Modern UI**: Clean, professional design with icons
- **Real-time Updates**: AJAX for seamless user experience
- **Form Validation**: Client-side and server-side validation
- **GPS Integration**: Automatic location capture
- **Google Maps**: Visual location verification

## 🔒 Security Features

- **Password Hashing**: Bcrypt password encryption
- **Session Management**: Secure PHP sessions
- **Role-based Access**: Protected routes and endpoints
- **Input Validation**: Sanitized user inputs
- **SQL Injection Protection**: Prepared statements

## 📱 Mobile Responsiveness

The system is fully responsive and works on:
- Desktop computers
- Tablets
- Mobile phones
- All modern browsers

## 🚀 Deployment

### Local Development (XAMPP/WAMP)
1. Install XAMPP or WAMP
2. Place project in `htdocs/` directory
3. Start Apache and MySQL services
4. Access via `http://localhost/SIWES/`

### Production Deployment
1. Upload files to web server
2. Configure database connection
3. Set up SSL certificate (recommended)
4. Configure Google Maps API key

## 🐛 Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check database credentials in `backend/config/db.php`
   - Ensure MySQL service is running

2. **GPS Location Not Working**
   - Ensure HTTPS is enabled (required for geolocation)
   - Check browser permissions for location access

3. **Google Maps Not Loading**
   - Verify API key is correct
   - Check API key restrictions and billing

4. **Session Issues**
   - Ensure PHP sessions are enabled
   - Check file permissions

## 📞 Support

For technical support or questions:
- Check the troubleshooting section above
- Review browser console for JavaScript errors
- Check PHP error logs for backend issues

## 📄 License

This project is developed for educational purposes as part of the SIWES program.

---

**Note**: Replace `YOUR_GOOGLE_MAPS_API_KEY` with an actual Google Maps API key for full functionality. The system will work without it, but the map visualization feature will be disabled. 