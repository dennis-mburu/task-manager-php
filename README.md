# ✅ Task Manager Web App

A lightweight PHP-based task management system designed for assigning, tracking, and updating tasks across different users with role-based access. Built using raw PHP, MySQL, and vanilla JavaScript — no frameworks.

---

## 🚀 Live Deployment

🌐 [Deployed App](https://dennis-mburu.infinityfreeapp.com/index.php)  
📁 [Project Repository](https://github.com/dennis-mburu/task-manager-php)

> ⚠️ *Note: The deployed version may have minor limitations due to free hosting restrictions.*

---

## ✨ Features

### 👩‍💼 Admin Functionalities
- Add, update, or delete users
- Assign tasks to users with deadlines
- Manage all tasks and all users
- Email notifications for task assignments (⚙️ Configurable)

### 🙋‍♂️ User Functionalities
- View only their own assigned tasks
- Update task status (Pending → In Progress → Completed)
- Edit their own profile and change password

### 📊 General
- Simple but tasteful responsive UI with Dark-Mode-ish theme
- Role-based access control
- Session-based login/logout system
- Passwords securely hashed 

---

## 🚀 Getting Started

To get the application up and running locally, follow the setup outline below:

### 🔁 1. Clone the Repository

Start by cloning the project repository to your local development environment.

### 🛠 2. Set Up Your Development Stack

Ensure that you have the following software installed and configured:

- Apache2 web server (e.g., via XAMPP, LAMP, or WAMP)
- PHP (version 8.1+ recommended)
- MySQL or MariaDB

### 🗄 3. Create the Database

Log into your local MySQL database and create a new database named: **task_manager**


Once the database is created, import the `task_manager.sql` file (sql dumpfile) provided in the root of the project. This SQL file will automatically create the necessary tables (`users`, `tasks`) and populate them with sample users and tasks for testing.

### 🔐 4. Configure Database Connection

In the file located at: `includes/db.php` update the database connection credentials (`host`, `user`, `password`, `db`) to match your local environment settings. This allows the application to communicate with your MySQL database.

### 🔑 5. Login Credentials

You have **two options** for accessing the application:

#### ✅ Option 1: Create Your Own Account

You can register a new user through the built-in **Sign Up** page:

- Go to the `/signup.php` page on your local or deployed version.
- Fill in the required details: **Username**, **Email**, **Password**, and select your **Role**.
- If you choose **Admin**, you’ll be able to assign tasks to yourself or others.
- If you choose **User**, you’ll only see and manage tasks assigned to you.

This is the recommended option if you want to simulate a fresh user flow.

---

#### 🧪 Option 2: Use the Sample Accounts from the SQL Dump

The `task_manager.sql` file includes **four sample users**:
- **2 Admins** and **2 Users**, each with sample credentials.
- You can use these to log in and test the full functionality right away.

> 🔍 Check the `task_manager.sql` file directly to find the sample **emails** and default **passwords** for login.

---


## 6. 🧪 Run the Application

With everything set up, launch your preferred browser and visit: `http://localhost/your-folder-path-being-served/index.php`. You should be greeted by the login page and be able to access the dashboard after logging in.

---

> ⚠️ Disclaimer
This app was built for educational and demonstration purposes.
Please do not use it as-is in production without adding proper validation, rate-limiting, and CSRF protection.

---
