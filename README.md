![Uploading 3.png…]()
![2](https://github.com/user-attachments/assets/f294121f-064f-4faf-b727-7e46e2604285)
![1](https://github.com/user-attachments/assets/31ef0a1c-c84d-4028-8ca4-41abd7e5c91d)


📦 Courier-X
Courier-X is a full-featured PHP web application for managing shipping and delivery logistics. It includes secure admin access, real-time shipment tracking, CRUD operations, session handling, activity logging, and responsive dashboard components—all integrated with AJAX for a seamless user experience.

✨ Features
🔐 Admin Login with Session Timeout and Auto-Logout

📄 Create, View, Edit, and Delete Shipping Records

🔍 Search & Filter Shipments

📃 Paginated Shipment Lists

📝 Edit Shipments via Modal Pop-up (AJAX)

❌ Delete Shipments Instantly (AJAX)

📡 Real-Time Activity Log Panel

📊 Dashboard UI with Bootstrap Icons, AdminLTE, ApexCharts & OverlayScrollbars

🛡️ Input Sanitization & Prepared SQL Statements (PDO)

📁 Project Structure
plaintext
Copy
Edit
├── dashboard/
│   ├── create.php
│   ├── view.php
│   ├── edit.php
│   ├── delete.php
│   ├── history.php
│   ├── update_shipment.php
│   └── logs_fetch.php
├── db.php
├── admin_log.php
├── logout.php
├── js/
│   ├── heartbeat.js
│   └── inactivity.js
├── dash/
│   ├── css/
│   │   └── adminlte.css
│   └── js/
│       └── adminlte.js
└── assets/
    └── img/
🧰 Tech Stack
PHP (7+) – Server-side scripting

MySQL – Database

HTML5 / CSS3 / JavaScript

AdminLTE 3 – Dashboard Template

Bootstrap 5 – Frontend Framework

PDO – Secure database access

AJAX – Real-time interactivity

OverlayScrollbars, ApexCharts, jsVectorMap, Bootstrap Icons – UI Enhancements

🔧 Installation
Clone this repository:

bash
Copy
Edit
git clone https://github.com/OsabuohienAisosaJonathan/Parcel-Tracking-App.git
cd courier-x
Set up your database:

Create a MySQL database and import the schema:

sql
Copy
Edit
CREATE TABLE `shipments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tracking_code` varchar(50),
  `shipper_name` varchar(100),
  `receiver_name` varchar(100),
  `destination` varchar(100),
  `status` varchar(50),
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

CREATE TABLE `activity_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `admin_id` int,
  `action` text,
  `timestamp` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);
Update db.php:

php
Copy
Edit
<?php
$pdo = new PDO('mysql:host=localhost;dbname=your_db_name', 'your_username', 'your_password');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
Run the app:

Start your local server and navigate to:

arduino
Copy
Edit
http://localhost/courier-x/dashboard/
🔒 Admin Access
You’ll need to implement your own admin_log.php login mechanism and store admin sessions like:

php
Copy
Edit
$_SESSION['admin_logged_in'] = true;
$_SESSION['admin_id'] = 1; // or dynamically assigned
📌 TODOs
Add user roles and permissions

Implement bulk import/export

Add email notifications

Enable file uploads for proof of delivery

📄 License & Access
This project is open-source for educational and demonstration purposes under the MIT License.

⚠️ Need full database access?
The database file (including structure and sample records) is available upon request.
To obtain it, please contact me directly at 📞 +234 815 688 5306 for pricing and access details.

📄 License
This project is open-source and free to use under the MIT License.

