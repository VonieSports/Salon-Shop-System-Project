# Salon-Shop-System-Project

A multi-tenant web application for managing salon and shop operations built with Laravel and Livewire. https://www.youtube.com/watch?v=8Tv1wNJg2vg&t=1s

## Features

- **Multi-tenant Architecture** - Support for multiple independent salons/shops
- **Appointment Management** - Schedule and manage customer appointments
- **Service Management** - Define services and service categories
- **Product Catalog** - Manage inventory and products with variants
- **Employee Management** - Track employees, schedules, and performance
- **Customer Management** - Maintain customer profiles and history
- **Order & Payment Processing** - Handle orders and payment methods
- **Real-time Updates** - Livewire components for dynamic UI
- **Permission Management** - Role-based access control

## Tech Stack

- **Backend**: Laravel 13.12
- **Frontend**: Livewire, Blade, Vite
- **Database**: MySQL
- **PHP**: 8.5+

## Installation

1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd web-access-multi-tenant-salon-shop
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Setup environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Database setup:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. Build assets:
   ```bash
   npm run build
   ```

## Development

Run the development server:

```bash
php artisan serve
npm run dev
```

## Testing

Run tests:
```bash
php artisan test
```

## License

This project is licensed under the MIT License - see the LICENSE file for details.
