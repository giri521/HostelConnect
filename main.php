<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HostelConnect | Kalasalingam University</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            background-color: #121212;
            color: white;
            height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #1a1a1a;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            text-align: center;
        }
        .sidebar .logo {
            width: 120px;
            margin-bottom: 10px;
        }
        .sidebar h2 {
            color: #fbc531;
            font-size: 22px;
            margin-bottom: 20px;
        }
        .nav-links a {
            text-decoration: none;
            color: white;
            font-size: 18px;
            padding: 12px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
        }
        .nav-links a:hover {
            background: #fbc531;
            color: black;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            padding: 30px;
            margin-left: 260px;
            overflow-y: auto;
        }
        .welcome-box {
            background: #1e1e1e;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 0 15px rgba(255, 204, 0, 0.2);
        }
        .welcome-box h1 {
            font-size: 28px;
            color: #ffcc00;
        }
        .features-container {
            margin-top: 30px;
        }
        .features-container h2 {
            font-size: 24px;
            color: #ffcc00;
            margin-bottom: 15px;
            border-bottom: 2px solid #ffcc00;
            padding-bottom: 5px;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }
        .feature-box {
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            text-align: center;
            transition: 0.3s;
            box-shadow: 0 0 10px rgba(255, 204, 0, 0.1);
        }
        .feature-box:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(255, 204, 0, 0.5);
        }
        .feature-box .icon {
            font-size: 40px;
            color: #ffcc00;
            margin-bottom: 10px;
        }
        .feature-box h3 {
            font-size: 20px;
            margin-bottom: 5px;
        }
        .feature-box p {
            font-size: 14px;
            color: #ddd;
        }
        
        /* Footer */
        .footer {
            margin-top: 30px;
            background-color: #1e1e1e;
            padding: 10px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <img src="kalasalingam.jpeg" alt="KLU Logo" class="logo">
        <h2>Kalasalingam HostelConnect</h2>
        <div class="nav-links">
            <a href="#">🏠 Home</a>
            <a href="student_login.php">🎓 Student Login</a>
            <a href="admin_login.php">🛡️ Admin Login</a>
            <a href="maintenance_login.php">🛠️ Maintenance Login</a>
            <a href="contact.php">📞 Contact</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="welcome-box">
                       <h1>Welcome to  Kalasalingam HostelConnect 🎉</h1>
            <p>Efficient Hostel Management for Kalasalingam University Students</p>
        </div>

        <!-- Features Section -->
        <div class="features-container">
            <h2>🎓 Student Features</h2>
            <div class="features-grid">
                <div class="feature-box"><i class="fas fa-bed icon"></i><h3>Hostel Room Booking</h3><p>Choose & book rooms easily.</p></div>
                <div class="feature-box"><i class="fas fa-tools icon"></i><h3>Maintenance Requests</h3><p>Report hostel maintenance issues.</p></div>
                <div class="feature-box"><i class="fas fa-file-alt icon"></i><h3>Leave & Permission</h3><p>Apply for leave & get approval.</p></div>
                <div class="feature-box"><i class="fas fa-exclamation-circle icon"></i><h3>Complaint & Tracking</h3><p>Raise complaints & track status.</p></div>
            </div>
        </div>

        <div class="features-container">
            <h2>🛠 Admin Features</h2>
            <div class="features-grid">
                <div class="feature-box"><i class="fas fa-user-cog icon"></i><h3>Student Profile Management</h3><p>Edit student profiles.</p></div>
                <div class="feature-box"><i class="fas fa-check-circle icon"></i><h3>Approve Room Bookings</h3><p>Verify payments & allocate rooms.</p></div>
                <div class="feature-box"><i class="fas fa-file-signature icon"></i><h3>Leave Approvals</h3><p>Manage leave requests.</p></div>
            </div>
        </div>

        <div class="features-container">
            <h2>🏠 Maintenance Team Features</h2>
            <div class="features-grid">
                <div class="feature-box"><i class="fas fa-water icon"></i><h3>Water Supply Fixes</h3><p>Resolve water issues.</p></div>
                <div class="feature-box"><i class="fas fa-bolt icon"></i><h3>Electrical Repairs</h3><p>Fix power supply problems.</p></div>
                <div class="feature-box"><i class="fas fa-broom icon"></i><h3>Cleaning & Hygiene</h3><p>Ensure hostel cleanliness.</p></div>
            </div>
        </div>

        <div class="footer">© 2025 Kalasalingam University | HostelConnect</div>
    </div>
</body>
</html>