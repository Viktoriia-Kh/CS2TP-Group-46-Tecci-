# Tecci eCommerce Platform

A Laravel-based online marketplace with user authentication, product catalog, basket/checkout flow, order management, reviews, support chatbot, and admin dashboard.

## Project Overview

Tecci is a full-featured eCommerce application built with Laravel 10 and includes:

- Public catalog (product listing + details)
- Shopping basket with quantity updates, discount code, and delivery options
- User registration/login (email/password + Google OAuth)
- Email verification, password reset flow
- Authenticated checkout and order history
- Customer account management
- Product reviews and website reviews
- Contact form with admin reply workflow
- Chatbot FAQ categories
- Admin panel for inventory, orders, customers, contacts, returns, and settings

## Tech Tools

- PHP 8.x
- Laravel 10
- Blade templates
- MySQL (or compatible DB)
- Bootstrap + custom CSS (public assets)
- Laravel Auth + middleware for protected/admin routes
- Socialite (Google login)

## Important files & folders

- `app/Models` - Eloquent models (Product, Order, User, BasketItem, etc.)
- `app/Http/Controllers` - controllers (Basket, Checkout, Admin, Chatbot, etc.)
- `routes/web.php` - application routes
- `resources/views` - Blade views for frontend and admin pages
- `public/` - publicly served assets (CSS, JS, images)

## Setup and Installation

1. Clone repository

```bash
git clone https://github.com/<your-org>/CS2TP-Group-46-Tecci-.git
cd CS2TP-Group-46-Tecci-
```

2. Install PHP dependencies

```bash
composer install
```

3. Copy `.env` file

```bash
copy .env.example .env
```

4. Generate app key

```bash
php artisan key:generate
```

5. Configure `.env` DB settings

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tecci_db
DB_USERNAME=root
DB_PASSWORD=secret
```

6. Migrate and seed

```bash
php artisan migrate
php artisan db:seed
```

7. Serve locally

```bash
php artisan serve
```

Open http://127.0.0.1:8000

## Authentication and Admin

- `GET /login`, `GET /signup`, `POST /logout`
- OAuth: `GET /auth/google`, callback route
- Email verification routes under `/email/verify`

Admin routes require `auth` + `admin` middleware, configurable in `app/Http/Middleware`.

## Key User Flows

- Home: `/`
- Product listing: `/displayproduct`
- Product detail: `/product/{id}`
- Basket: `/basket` + add/remove/decrease
- Checkout: `/checkout`
- My orders: `/my-orders`
- Contact: `/contact-us`
- Reviews: `/products/{productId}/reviews`

## Admin Flows

- Dashboard: `/admin-dashboard`
- Orders: `/admin-orders` (create/update/status/export)
- Inventory: `/admin-inventory`
- Customers: `/admin/customers`
- Contacts: `/admin/contacts`
- Returns: `/admin/returns/{id}`
- Admin Settings: `/admin-settings`

## Development Notes

- Chatbot endpoints:
  - `/chatbot/categories`
  - `/chatbot/categories/{category}/faqs`
  - `/chatbot/faqs/{faq}`

- Basket AJAX update: `/basket/update-ajax`
- Apply discount: `/apply-discount`

## Contributing

1. Fork project
2. Create branch: `feature/your-feature`
3. Commit changes
4. Push and open PR

Please follow existing coding style and test behavior for new features.

