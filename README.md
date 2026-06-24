# 🚀 GadgetBI — Laravel Sales Analytics Dashboard

A full-stack Laravel web application with:

- ✅ **Interactive BI Dashboard** answering 11 business intelligence questions
- ✅ **Complete CRUD** for all 8 entities (Customers, Products, Orders, Employees, Offices, ProductLines, Payments, Users)
- ✅ **Role-Based Access Control** (Admin, Manager, Analyst, Staff)
- ✅ **Chart.js visualizations** (bar, line, pie, doughnut, multi-axis)
- ✅ **Bootstrap 5** responsive design with custom sidebar

---

## 📋 Requirements

| Tool     | Version |
| -------- | ------- |
| PHP      | 8.1+    |
| Composer | 2.x     |
| MySQL    | 8.0+    |
| Node.js  | 16+     |
| Laravel  | 10.x    |

---

## ⚙️ Setup Instructions

### Step 1 — Clone / Extract project

```bash
# Extract the ZIP and enter the folder
cd gadget-dashboard
```

### Step 2 — Install PHP dependencies

```bash
composer install
```

### Step 3 — Create environment file

```bash
cp .env.example .env
php artisan key:generate
```

### Step 4 — Configure `.env` database settings

Open `.env` and set:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gadget_store
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Step 5 — Import the database

```bash
# Create the database first:
mysql -u root -p -e "CREATE DATABASE gadget_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Import the full schema + data:
mysql -u root -p gadget_store < database/gadget_store.sql
```

### Step 6 — Run the application

```bash
php artisan serve
```

Open: **http://localhost:8000**

---

## 🔐 Default Login Credentials

All accounts use password: **`password`**

| Role    | Email                   | Access Level                       |
| ------- | ----------------------- | ---------------------------------- |
| Admin   | admin@gadgetstore.com   | Full access + User/Role Management |
| Manager | manager@gadgetstore.com | All data, manage orders/customers  |
| Analyst | analyst@gadgetstore.com | Read-only dashboard & reports      |
| Staff   | staff@gadgetstore.com   | Manage orders and customers only   |

---

## 📊 Dashboard — 11 Business Intelligence Questions

| #   | Question                                           | Chart Type      |
| --- | -------------------------------------------------- | --------------- |
| Q1  | Which city is the best market for sales?           | Bar + Table     |
| Q2  | Which product has the highest sales?               | Horizontal Bar  |
| Q3  | Which office provides the best sales support?      | Doughnut        |
| Q4  | Which product line generates the most revenue?     | Pie             |
| Q5  | Which office manages the highest-revenue products? | Table           |
| Q6  | Which products have the most delayed shipments?    | Table w/ badges |
| Q7  | Which country contributes the most total orders?   | Horizontal Bar  |
| Q8  | How do sales trend month-over-month?               | Dual-axis Line  |
| Q9  | Which employee has the best revenue-per-customer?  | Bar + Table     |
| Q10 | Which month/year had the highest sales overall?    | Ranked Table    |

---

## 🗂️ Project Structure

```
gadget-dashboard/
├── app/
│   └── Http/
│       ├── Controllers/
│       │   ├── Auth/LoginController.php
│       │   ├── DashboardController.php    ← All 11 BI queries
│       │   ├── CustomerController.php
│       │   ├── ProductController.php
│       │   ├── OrderController.php
│       │   ├── EmployeeController.php
│       │   ├── OfficeController.php
│       │   ├── ProductLineController.php
│       │   ├── PaymentController.php
│       │   ├── UserController.php         ← Admin only
│       │   └── RoleController.php         ← Admin only
│       ├── Kernel.php
│       └── Middleware/
│           ├── AuthMiddleware.php
│           └── RoleMiddleware.php
├── database/
│   └── gadget_store.sql                  ← Complete DB dump
├── resources/views/
│   ├── layouts/app.blade.php             ← Master layout w/ sidebar
│   ├── auth/login.blade.php
│   ├── dashboard/index.blade.php         ← Main BI dashboard
│   ├── customers/    (index, create, edit, show)
│   ├── products/     (index, create, edit, show)
│   ├── orders/       (index, create, edit, show)
│   ├── employees/    (index, create, edit, show)
│   ├── offices/      (index, create, edit, show)
│   ├── productlines/ (index, create, edit, show)
│   ├── payments/     (index, create, edit)
│   ├── users/        (index, create, edit, show) ← Admin only
│   └── roles/        (index, create, edit, show) ← Admin only
└── routes/web.php
```

---

## 🗄️ Database Schema

```
offices         → employees → customers → orders → orderdetails → products → productlines
                                       ↘ payments
users → roles
```

---

## 🔒 Role Permissions Matrix

| Feature          | Admin | Manager | Analyst | Staff |
| ---------------- | ----- | ------- | ------- | ----- |
| Dashboard        | ✅    | ✅      | ✅      | ✅    |
| View all data    | ✅    | ✅      | ✅      | ✅    |
| Create/Edit CRUD | ✅    | ✅      | ❌      | ✅\*  |
| Delete records   | ✅    | ✅      | ❌      | ❌    |
| User Management  | ✅    | ❌      | ❌      | ❌    |
| Role Management  | ✅    | ❌      | ❌      | ❌    |

\*Staff can manage orders and customers.

---

## 🎨 Tech Stack

- **Backend**: Laravel 10 (PHP 8.1+)
- **Frontend**: Bootstrap 5.3 + Bootstrap Icons
- **Charts**: Chart.js 4.4
- **Database**: MySQL 8.0
- **Auth**: Custom session-based authentication
- **Fonts**: Google Fonts — Inter

---

## 📝 Notes

- The `database/gadget_store.sql` file contains complete schema + sample data
- All passwords are hashed using Laravel's `Hash::make()` (bcrypt)
- The dashboard queries exclude `Cancelled` orders for accurate revenue figures
- Late shipments are detected by `shippedDate > requiredDate`
