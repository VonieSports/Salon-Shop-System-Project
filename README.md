# Salon Shop System

[![Laravel](https://img.shields.io/badge/Laravel-13.12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-8.5%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![Livewire](https://img.shields.io/badge/Livewire-4%2B-FB70A9?style=for-the-badge&logo=livewire&logoColor=white)](https://livewire.laravel.com/)
[![MySQL](https://img.shields.io/badge/MySQL-8%2B-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Vite](https://img.shields.io/badge/Vite-6%2B-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev/)
[![License](https://img.shields.io/badge/License-MIT-yellow?style=for-the-badge)](LICENSE)

> **A modern multi-tenant salon and shop management system built with Laravel and Livewire.**

---

## 📋 Overview

**Salon Shop System** is a multi-tenant web application designed to help salons and beauty shops efficiently manage their daily operations from a centralized platform.

The system provides tools for managing **appointments, services, products, employees, customers, orders, payments, and permissions**, while maintaining separation between individual salon/shop tenants.

### 🎯 Project Goals

- 🏢 Support multiple independent salons and shops
- 📅 Simplify appointment scheduling
- 💇 Manage salon services and service categories
- 📦 Track products, inventory, and product variants
- 👥 Manage employees and customers
- 💳 Process orders and payments
- ⚡ Provide responsive, real-time interfaces
- 🔐 Implement secure role-based permissions
- 📊 Centralize salon/shop operational data

---

## ✨ Features

| Feature | Description |
|---|---|
| 🏢 **Multi-Tenant Architecture** | Support multiple independent salons/shops within one application |
| 📅 **Appointment Management** | Schedule, update, and manage customer appointments |
| 💇 **Service Management** | Create and organize salon services and categories |
| 🛍️ **Product Catalog** | Manage products, inventory, and product variants |
| 👨‍💼 **Employee Management** | Manage employees, schedules, and performance information |
| 👤 **Customer Management** | Maintain customer profiles, records, and service history |
| 🧾 **Order Management** | Create and manage customer orders |
| 💳 **Payment Processing** | Handle payments and supported payment methods |
| ⚡ **Real-Time Updates** | Dynamic interfaces powered by Livewire |
| 🔐 **Role-Based Access Control** | Manage system access using roles and permissions |
| 🏪 **Tenant Isolation** | Keep salon/shop data logically separated |
| 📱 **Responsive Interface** | Designed for desktop and mobile-friendly usage |

---

## 🏗️ System Architecture

The application follows a modern Laravel-based architecture:

```text
┌─────────────────────────────────────────────┐
│                 Web Browser                 │
└──────────────────────┬──────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────┐
│              Blade + Livewire               │
│             Dynamic User Interface          │
└──────────────────────┬──────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────┐
│               Laravel 13.12                 │
│                                             │
│  ┌────────────┐ ┌────────────┐ ┌─────────┐ │
│  │ Multi-Tenant│ │ Business   │ │  Auth & │ │
│  │ Management  │ │ Logic      │ │  RBAC   │ │
│  └────────────┘ └────────────┘ └─────────┘ │
└──────────────────────┬──────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────┐
│                    MySQL                    │
│              Relational Database            │
└─────────────────────────────────────────────┘
```

---

## 🧰 Tech Stack

### Backend

[![Laravel](https://img.shields.io/badge/Laravel-13.12-FF2D20?logo=laravel&logoColor=white)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-8.5%2B-777BB4?logo=php&logoColor=white)](https://www.php.net/)

- **Laravel 13.12**
- **PHP 8.5+**
- Laravel Eloquent ORM
- Laravel Authentication
- Laravel Middleware
- Laravel Validation

### Frontend

[![Livewire](https://img.shields.io/badge/Livewire-3%2B-FB70A9?logo=livewire&logoColor=white)](https://livewire.laravel.com/)
[![Vite](https://img.shields.io/badge/Vite-6%2B-646CFF?logo=vite&logoColor=white)](https://vitejs.dev/)

- **Livewire**
- **Blade**
- **Vite**
- JavaScript
- CSS

### Database

[![MySQL](https://img.shields.io/badge/MySQL-8%2B-4479A1?logo=mysql&logoColor=white)](https://www.mysql.com/)

- **MySQL**
- Relational database design
- Foreign key relationships
- Database migrations
- Eloquent relationships

---

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/Salon-Shop-System-Project.git

cd Salon-Shop-System-Project
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Frontend Dependencies

```bash
npm install
```

### 4. Configure Environment

Copy the example environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure your database inside `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=salon_shop
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run Database Migrations

```bash
php artisan migrate
```

If the project includes seeders:

```bash
php artisan db:seed
```

### 6. Build Frontend Assets

For development:

```bash
npm run dev
```

For production:

```bash
npm run build
```

### 7. Start Laravel

```bash
php artisan serve
```

The application will be available at:

```text
http://127.0.0.1:8000
```

---

## 🧪 Development

Run the Laravel development environment:

```bash
php artisan serve
```

Run Vite:

```bash
npm run dev
```

You can also use Laravel's combined development command if configured in `composer.json`:

```bash
composer run dev
```

---

## 🔐 Security & Access Control

The system is designed around role-based access control (RBAC).

Example access structure:

```text
System
│
├── Super Administrator
│   └── Manage the entire platform
│
├── Salon/Shop Administrator
│   └── Manage tenant operations
│
├── Employee
│   └── Manage assigned operational tasks
│
└── Customer
    └── Manage appointments and personal information
```

Tenant-aware access ensures that users interact only with the salon/shop data they are authorized to access.

---

## 🗃️ Database

The application uses **MySQL** as its relational database.

The database contains entities supporting:

- Tenants
- Users
- Customers
- Employees
- Services
- Service Categories
- Products
- Product Variants
- Inventory
- Appointments
- Orders
- Order Items
- Payments
- Roles and Permissions

Relationships are implemented using **primary keys and foreign keys** following relational database design principles.

---

## 📸 Screenshots

> Add screenshots of the system interface here.

Example:

```markdown
![Dashboard](screenshots/dashboard.png)

![Appointments](screenshots/appointments.png)

![Products](screenshots/products.png)

![Customers](screenshots/customers.png)
```

---

## 🛣️ Future Improvements

Potential improvements for future versions include:

- [ ] Online customer booking
- [ ] SMS/email appointment notifications
- [ ] Advanced sales reports
- [ ] Inventory alerts
- [ ] Employee attendance tracking
- [ ] Customer loyalty system
- [ ] Automated appointment reminders
- [ ] Advanced analytics dashboard
- [ ] Online payment integration
- [ ] Mobile application
- [ ] API integration
- [ ] Audit logging

---

## 🤝 Contributing

Contributions are welcome.

1. Fork the repository
2. Create a feature branch

```bash
git checkout -b feature/new-feature
```

3. Commit your changes

```bash
git commit -m "Add new feature"
```

4. Push the branch

```bash
git push origin feature/new-feature
```

5. Open a Pull Request

---

## 📄 License

This project is licensed under the **MIT License**.

See the [LICENSE](LICENSE) file for more information.

---

## 👨‍💻 Project

**Salon Shop System**

Built with ❤️ using:

[![Laravel](https://img.shields.io/badge/Laravel-13.12-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com/)
[![Livewire](https://img.shields.io/badge/Livewire-FB70A9?style=flat-square&logo=livewire&logoColor=white)](https://livewire.laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-8.5%2B-777BB4?style=flat-square&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://www.mysql.com/)

---

<p align="center">
  <strong>💇 Salon Shop System</strong><br>
  Multi-Tenant Salon & Shop Management Platform
</p>

<p align="center">
  ⭐ Star this repository if you find it useful!
</p>