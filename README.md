# 🏠 HostelConnect - Kalasalingam University Hostel Management System

HostelConnect is a web-based hostel management portal tailored for **Kalasalingam University**, offering seamless interaction between **students**, **administrators**, and the **maintenance team**. The system enables efficient hostel room booking, complaint management, maintenance tracking, and leave approval — all through a **dark-themed, responsive web interface**.

---

## 🚀 Features

### 🎓 Student Portal
- 📌 **Hostel Room Booking**  
  Book rooms based on hostel type, room share, and availability.

- 🛠️ **Maintenance Requests**  
  Raise issues related to your room (fan not working, water issues, etc.).

- 📄 **Complaint Submission & Tracking**  
  Submit general hostel-related complaints and track their status.

- 📝 **Leave & Permission Requests**  
  Submit and manage leave applications with proper reason and duration.

- 🔒 **University Email Login Required**  
  Only authenticated university email holders can access.

---

### 🛡️ Admin Portal
- ✅ **Confirm Room Allocations**  
  Verify and confirm student room bookings with payment screenshot validation.

- 🚫 **Delete Student Profiles**  
  Remove students from hostel system with valid reasons.

- 📄 **Approve/Reject Leave Requests**  
  Handle permissions and ensure student tracking.

---

### 🛠️ Maintenance Team Portal
- 🗋 **View Student Maintenance Requests**  
  Track all incoming maintenance issues with room and student details.

- 🔧 **Update Request Status**  
  Change request status to: `Pending`, `In Progress`, or `Resolved`.

---

## 🤖 Technologies Used

- **Frontend**: HTML, CSS, JavaScript  
- **Backend**: PHP  
- **Database**: MySQL (via XAMPP)  
- **Server**: Apache (XAMPP)  
- **Authentication**: Session-based login system

---

## 📁 Folder Structure

```
HostelConnect/
│
├── index.html               # Main landing page
├── login.php                # Login selector page
├── student_login.php        # Student login
├── admin_login.php          # Admin login
├── maintenance_login.php    # Maintenance login
├── registration.php         # Student registration
├── requests.php             # Maintenance request interface
├── dashboard_student.php    # Student dashboard
├── dashboard_admin.php      # Admin dashboard
├── dashboard_maintenance.php# Maintenance team dashboard
├── database.php             # DB connection file
├── style.css                # Styling file (optional)
└── README.md                # This file
```

---

## 🛠️ Setup Instructions

1. **Install XAMPP**  
   [Download XAMPP](https://www.apachefriends.org/index.html) and install it on your system.

2. **Clone the Project Folder**  
   ```bash
   Place the 'HostelConnect' folder in C:\xampp\htdocs\
   ```

3. **Start Apache and MySQL via XAMPP Control Panel**

4. **Create Database in phpMyAdmin**  
   - Open `http://localhost/phpmyadmin`  
   - Create a database named: `hostelconnect`  
   - Import the provided `.sql` file (not included here)

5. **Run the Application**  
   - Open your browser and go to:  
     ```
     http://localhost/HostelConnect/
     ```

---


## ✅ Future Enhancements

- Email notifications for request updates.
- Real-time status updates using AJAX.
- Hostel occupancy analytics for admins.
- Mobile responsiveness for all portals.

---

## 🙋‍♂️ Developed By

**VENNAPUSA GIRIVARDHAN REDDY**  
`B.Tech CSE, Kalasalingam University`  
Contact: [girivennapusa8@gmail.com]  
GitHub: [https://github.com/giri521]


