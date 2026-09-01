# 💍 Sainmatrimony.in - Dynamic Matrimonial Portal & Admin Control Panel

A modern, responsive, 100% dynamic **Matrimonial Web Application** built with **PHP 8**, **MySQL**, **CSS3**, and **JavaScript**. Designed for community matchmaking with a dedicated Admin Panel, Candidate Directory Search with Multi-field Filtering, Mobile Native App Layout, Success Stories Showcase, and Free Registration Request Management.

---

## ✨ Features Overview

### 🌐 Public Website (`Sainmatrimony.in`)
- **Dynamic Hero Banner & Quick Search Box**: Filter candidates by Gender, Age Range, Religion, and Caste dynamically populated from database records.
- **Featured & Premium Candidate Cards**: Dynamic 10-profile homepage display with real-time badges (`PREMIUM`, `Verified`).
- **2-Column Mobile Portrait Cards**: Responsive mobile card grid (`repeat(2, 1fr)`) showing full-face candidate portraits without cropping or zooming.
- **Search Profiles Page (`search.php`)**: Multi-field search filters (Gender, Age, Religion, Caste, Location, Profile ID) + dynamic sorting (Featured first, Age ascending, Age descending) + active filter reset + pagination.
- **Detailed Profile View (`profile.php`)**: Full candidate details view with Express Interest submission.
- **Success Stories Showcase (`stories.php`)**: Dedicated married couples testimonial showcase.
- **Free Profile Registration (`register.php`)**: Free registration request form with input validation and instant administrative inquiry recording.
- **Simple Mobile Navigation Menu**: Modern hamburger menu collapse for mobile viewports.

### 🛡️ Admin Control Panel (`/admin/`)
- **Secure Authentication System**: Password hashing (`password_hash`), session security (`session_regenerate_id`), and cookie destruction on logout.
- **Collapsible Sidebar Toggle**: Smooth hide/show sidebar toggle button (`#sidebarToggle`) with `localStorage` state persistence.
- **Manage Candidate Profiles (`admin/profiles.php`)**:
  - Add, Edit, Delete candidate profiles.
  - 1-click status toggles for `Active/Inactive` and `Premium/Regular`.
  - Pagination (`5 items per page`) and search filter bar.
- **Separate Add Candidate Profile (`admin/add-profile.php`)**: Full form for adding new candidate photos and details.
- **Separate Add Success Story (`admin/add-story.php`)**: Dedicated form for uploading couple photos, wedding dates, and testimonials.
- **Manage Success Stories (`admin/stories.php`)**: Full-width list table with instant deletion.
- **User Registration Inquiries (`admin/inquiries.php`)**: Track and delete user registration requests.
- **Account & Password Settings (`admin/settings.php`)**: Security form allowing administrators to update login username and password with current password verification.

---

## 🛠️ Tech Stack & Requirements

- **PHP**: PHP 7.4+ or PHP 8.x
- **Database**: MySQL 5.7+ or MariaDB 10.4+
- **Web Server**: Apache / Nginx (XAMPP, WAMP, MAMP, or LAMP)
- **Frontend**: HTML5, CSS3 (CSS Grid & Flexbox), Vanilla JS
- **Icon Library**: FontAwesome 6.4

---

## 🚀 Local Installation & Setup Instructions

### 1. Clone or Download Repository
```bash
git clone https://github.com/your-username/matrimony.git
```
Or place the extracted folder into your local web server root (e.g. `C:\xampp\htdocs\matrimony`).

### 2. Import Database
1. Open **phpMyAdmin** (`http://localhost/phpmyadmin/`).
2. Create a new database named `manglik_matrimony_db`.
3. Select the created database and click **Import**.
4. Choose the `database.sql` file from the project root and click **Go**.

### 3. Configure Database Connection (`config.php`)
Open `config.php` and verify database credentials:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'manglik_matrimony_db');
define('BASE_URL', 'http://localhost/matrimony/');
```

### 4. Launch Application
- **Main Website**: `http://localhost/matrimony/`
- **Admin Control Panel**: `http://localhost/matrimony/admin/`

---

## 🔑 Default Admin Access

| Parameter | Default Credential |
|---|---|
| **Admin Login URL** | `http://localhost/matrimony/admin/` |
| **Username** | `admin` |
| **Password** | `password123` |

*(Note: Admin password can be changed anytime via Admin Panel -> Account Settings)*

---

## 📂 Project Directory Structure

```
matrimony/
├── admin/
│   ├── add-profile.php     # Form to add new candidate profile
│   ├── add-story.php       # Form to add new success story
│   ├── edit-profile.php    # Form to edit profile details
│   ├── footer.php          # Admin layout footer & JS sidebar script
│   ├── header.php          # Admin layout header, sidebar & top bar
│   ├── index.php           # Admin analytics dashboard
│   ├── inquiries.php       # User registration requests table
│   ├── login.php           # Secure admin login form
│   ├── logout.php          # Admin session destruction script
│   ├── profiles.php       # Candidate management table with pagination
│   ├── settings.php       # Admin account username & password change page
│   └── stories.php        # Success stories list table
├── css/
│   └── style.css          # Main stylesheet with mobile responsive rules
├── images/                 # Profile photos, hero background & story images
├── config.php              # Global configuration & PDO database connection
├── footer.php              # Public site footer & mobile navigation JS
├── header.php              # Public site top bar & main header navigation
├── index.php               # Homepage with 10 dynamic profile cards
├── profile.php             # Candidate full profile view page
├── register.php            # Free profile registration request form
├── search.php             # Profile search directory with filters & pagination
├── stories.php            # Public success stories page
├── database.sql            # Full MySQL database export with 15 profiles
├── .gitignore              # Git ignore configuration
└── README.md               # Documentation & setup guide
```

---

## 📜 License
This project is open-source and available under the [MIT License](LICENSE).
