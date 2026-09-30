# Placement Committee Management System (PCMS)

## Overview

The Placement Committee Management System (PCMS) is a web-based application developed to streamline and manage campus placement activities within an educational institution. The system provides dedicated portals for students, placement officers, HODs, principal/admin authorities, and recruiters, enabling efficient coordination of placement drives and student recruitment processes.

The platform centralizes student information, company details, placement drives, eligibility verification, approvals, and placement records in a single system.

---

## Features

### Student Module

* Student registration and login
* Profile management
* Placement preferences management
* View upcoming placement drives
* Apply for eligible companies
* Password recovery functionality

### Placement Officer Module

* Manage placement drives
* Add and update company information
* Track student applications
* View placement statistics
* Generate reports

### HOD Module

* Review student profiles
* Approve placement applications
* Monitor department placement activities

### Principal/Admin Module

* Institution-wide placement monitoring
* Placement analytics and reports
* User management

### Placement Drive Management

* Create placement drives
* Define eligibility criteria
* Manage company details
* Schedule recruitment activities
* Track selections

---

## Technology Stack

### Frontend

* HTML5
* CSS3
* Bootstrap
* JavaScript
* jQuery

### Backend

* PHP

### Database

* MySQL

### Server Environment

* Apache (XAMPP/WAMP/LAMP)

---

## Project Structure

```text
PCMS-main/
│
├── Homepage/
│   ├── index.php
│   ├── home.php
│
├── Profilers/
│   ├── SProfile/          # Student Portal
│   ├── PProfile/          # Placement Officer Portal
│   ├── HODProfile/        # HOD Portal
│   └── PriProfile/        # Principal/Admin Portal
│
├── Drives/
│   ├── Company Information
│   ├── Placement Drive Pages
│   └── Drive Management
│
├── Database/
│   ├── Skeleton-Database.sql
│   └── Revised.sql
│
└── Assets/
    ├── CSS
    ├── JavaScript
    └── Images
```

---

## Database Setup

1. Install XAMPP or WAMP.
2. Start Apache and MySQL services.
3. Open phpMyAdmin.
4. Create a database named:

```sql
details
```

5. Import:

```text
Database/Skeleton-Database.sql
```

or

```text
Database/Revised.sql
```

6. Verify that all required tables are created successfully.

---

## Installation

### Clone Repository

```bash
git clone https://github.com/shazeen21/PCMS-main.git
```

### Move Project

Copy the project folder to:

```text
xampp/htdocs/
```

or

```text
wamp/www/
```

### Configure Database

Update database credentials in the PHP configuration files if required:

```php
$host = "localhost";
$user = "root";
$password = "";
$database = "details";
```

### Run Application

Open your browser and visit:

```text
http://localhost/PCMS-main/Homepage/
```

---

## Core Functionalities

### Student Management

* Student profile maintenance
* Eligibility verification
* Placement application tracking

### Company Management

* Company registration
* Recruitment details
* Eligibility criteria setup

### Placement Tracking

* Drive scheduling
* Interview management
* Selection records

### Reporting

* Placement statistics
* Department-wise reports
* Student placement status

---

## Database Highlights

The system maintains information related to:

* Students
* Placement drives
* Company details
* Eligibility criteria
* Applications
* Selection records
* User accounts

Example table:

```sql
addpdrive
```

Stores company drive information including:

* Company Name
* Drive Date
* Venue
* Academic Eligibility
* Backlog Criteria
* Additional Requirements

---

## Future Enhancements

* Resume upload and verification
* Email notifications
* SMS integration
* Dashboard analytics
* Role-based access control improvements
* Modern responsive UI
* REST API support

---

## Academic Purpose

This project was developed as an academic Placement Management System to demonstrate the implementation of a multi-user web application using PHP and MySQL for managing institutional placement activities.

---

## Author

**Shazeen Marakkar**

B.Tech Artificial Intelligence & Data Science
SVKM's NMIMS School of Technology Management & Engineering

---

## License

This project is intended for educational and academic purposes.
