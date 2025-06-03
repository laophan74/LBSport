# LBSport: A Sports E-commerce Site

A sports e-commerce site using **HTML/CSS/JS** (frontend) and **PHP** (backend).

---

## 🌐 Live Site Access

**URL:**  
[student.cdms.westernsydney.edu.au/~22121468/LBSport/index.php](http://student.cdms.westernsydney.edu.au/~22121468/LBSport/index.php)

### 🔐 Admin Login
- **Email:** admin@gmail.com  
- **Password:** 1

### 👤 User Login
- **Email:** bobtest@gmail.com  
- **Password:** bob

---

## 💻 Installation Guide

To install the **LBSport** website on another computer:

### 📋 Requirements

- XAMPP (or any Apache, MySQL, PHP stack)
- PHP 7.x or above
- MySQL 5.x or above

### 🛠️ Steps

1. **Unzip the project** into the `htdocs` directory (for XAMPP), for example:  
   `C:\xampp\htdocs\LBSport\`

2. **Create the database:**
   - Open **phpMyAdmin**
   - Create a new database named `lbsport_db`  
     *(Note: the actual current name is `db_22121468`, and the password is `Laobob123`)*

3. **Import the SQL file:**
   - Go to the **Import** tab
   - Choose the file:  
     `backend/database/databaseSetting.sql`
   - Click **Go**

4. **Configure the database connection:**
   - File: `backend/includes/db_connect.php`
   - Edit MySQL username/password if needed:  
     ```php
     $conn = new mysqli("localhost", "root", "", "lbsport_db");
     ```

5. **Access the site** via:  
   `http://localhost/LBSport/index.php`
