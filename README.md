# BusLive – Smart Bus Ticket Booking System 🚌

![PHP](https://img.shields.io/badge/PHP-8.0-blue?logo=php) ![Laravel](https://img.shields.io/badge/Laravel-9.x-red?logo=laravel) ![Vue.js](https://img.shields.io/badge/Vue.js-3.x-green?logo=vue.js) ![License](https://img.shields.io/badge/License-MIT-green)

Welcome to **BusLive**! 🚀 This is a modern web application built to make booking inter-provincial bus tickets in Vietnam a breeze. Think of it as a full-stack app for both passengers (finding trips, picking seats, paying online) and bus operators (managing routes, buses, and tickets). Built with **Laravel** and **Vue.js**, it’s like a well-optimized e-commerce platform, but for bus travel.

## 📋 Project Overview
As a web dev, imagine building a ticketing system like Booking.com but for Vietnam’s bus network. BusLive answers questions like:
- 🛤️ Which routes are available from Hanoi to Ho Chi Minh City?
- 🛏️ Which seats are free on a specific trip?
- 💸 How much revenue did a bus operator make this month?
- ⚠️ Are there any booking conflicts or data issues?

The app provides an interactive UI for passengers and a robust dashboard for bus operators and admins, all powered by a scalable Laravel backend and a snappy Vue.js frontend.

## 🗃️ Database
The system uses **MySQL** to store data, with key tables like:
- **Trips**: Stores trip details (like `orders` in an e-commerce DB). Columns: `id`, `bus_id`, `route_id`, `departure_time`, `status`.
- **Buses**: Bus info (like `products`). Columns: `id`, `operator_id`, `name`, `seat_layout`, `capacity`.
- **Routes**: Route details (like `categories`). Columns: `id`, `start_location`, `end_location`, `distance`.
- **Bookings**: Ticket bookings (like `order_items`). Columns: `id`, `trip_id`, `customer_id`, `seat_number`, `price`.
- **Users**: Customers and operators (like `users`). Columns: `id`, `name`, `email`, `role`.

📂 Database migrations and seeders are in `database/migrations/` and `database/seeders/`.

## 🛠️ Environment Requirements
To run BusLive, you need:
- **PHP**: 8.0 or higher (Laravel 9.x requires it) 🐘
- **Node.js**: 16.x or higher (for Vue.js and frontend assets) 🌐
- **MySQL**: 5.7 or higher (or any Laravel-supported DB) 🗄️
- **Redis**: For session and cache management (like Varnish for web apps) 🚀
- **Composer**: For PHP dependencies (like npm) 📦
- **System**: Linux, macOS, or Windows (WSL is solid) 💻
- **Dependencies** (in `composer.json` and `package.json`):
  - `laravel/framework`: Core backend, like Express.js for PHP.
  - `vue`: Frontend framework, like React but lighter.
  - `axios`: For API calls, like Fetch API.
  - `spatie/laravel-permission`: Role-based access, like JWT middleware.
  - Payment gateways (e.g., VNPay, Momo) for online payments.

## ⚙️ Setup Instructions
Follow these steps to get BusLive running, like spinning up a Laravel + Vue app:

1. **Clone the Repository** 📥:
   ```bash
   git clone https://github.com/binhchay1/buslive.git
   cd buslive
   ```

2. **Install Backend Dependencies** 📦:
   Ensure [Composer](https://getcomposer.org/) is installed, then run:
   ```bash
   composer install
   ```

3. **Install Frontend Dependencies** 🌐:
   Ensure [Node.js](https://nodejs.org/) is installed, then run:
   ```bash
   npm install
   ```

4. **Configure the Environment** 🛠️:
   - Copy `.env.example` to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Update `.env` with your database, Redis, and payment gateway credentials:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=buslive
     DB_USERNAME=your_username
     DB_PASSWORD=your_password

     REDIS_HOST=127.0.0.1
     REDIS_PASSWORD=null
     REDIS_PORT=6379

     VNPAY_TMN_CODE=your_vnpay_code
     VNPAY_HASH_SECRET=your_vnpay_secret
     ```

5. **Generate Application Key** 🔑:
   ```bash
   php artisan key:generate
   ```

6. **Run Migrations and Seeders** 🗄️:
   Set up the database schema and seed initial data:
   ```bash
   php artisan migrate --seed
   ```

7. **Compile Frontend Assets** 🎨:
   Build Vue.js assets:
   ```bash
   npm run dev
   ```

8. **Start the Application** 🚀:
   Run the Laravel dev server:
   ```bash
   php artisan serve
   ```
   Access the app at `http://localhost:8000`.

## 🚀 How to Run
1. **Start the Server** 🌐:
   Ensure Apache/Nginx is configured or use `php artisan serve` for development.

2. **Test the Application** ▶️:
   - Visit `http://localhost:8000` for the passenger booking interface.
   - Access the admin dashboard at `http://localhost:8000/admin` (login required).
   - Use seeded credentials (e.g., `admin@buslive.com` / `password`) to test.

3. **Stop the Server** 🛑:
   Ctrl+C to stop `php artisan serve` or stop your web server.

## 📁 Project Structure
Like a typical Laravel + Vue app, here’s the layout:
```
buslive/
├── app/                  # Backend logic, like src/ in a Node.js app 🛠️
│   └── Http/Controllers/
├── database/             # Migrations and seeders, like Django migrations 🗄️
│   ├── migrations/
│   └── seeders/
├── resources/            # Frontend assets, like src/ in a React app 🎨
│   ├── js/
│   └── views/
├── public/               # Public directory, like dist/ after a build 🌐
│   └── index.php
├── routes/               # API and web routes, like Express routes 🚏
├── storage/              # Logs and cache, like node_modules/ 🚫
├── vendor/               # Composer dependencies 📦
├── .env.example          # Environment config template 📋
├── .gitignore            # Excludes storage/, vendor/, etc. 🚫
├── composer.json         # Backend dependencies 📋
├── package.json          # Frontend dependencies 📋
├── README.md             # You're reading it! 📖
└── LICENSE               # MIT License 📜
```

## 📈 Key Features
- **Trip Search**: Filter trips by location, date, and operator (like a search API) 🛤️
- **Interactive Seat Selection**: Real-time seat map with Vue.js (like a dynamic form) 🛏️
- **Online Payments**: Integrated with VNPay, Momo, etc. (like Stripe) 💸
- **Operator Dashboard**: Manage buses, routes, and tickets (like an admin panel) 📊
- **Admin Analytics**: Revenue, bookings, and seat availability reports (like Google Analytics) 📈

## 💡 Recommendations
Like optimizing a web app based on analytics:
- **Performance**: Use Laravel’s caching with Redis for faster trip searches 🚀
- **UI/UX**: Enhance seat selection with drag-and-drop (like Trello’s UI) 🎨
- **SEO**: Optimize public trip pages for Google (use meta tags, sitemap) 🌐
- **Notifications**: Send booking confirmations via email/SMS (use Laravel Mail) 📧
- **Scalability**: Deploy with Docker for high traffic (like Kubernetes for web apps) 🐳

## 🛠️ Troubleshooting
- **Error: `Class not found`** ⚠️: Run `composer install` or `composer dump-autoload`.
- **Database Connection Failed** 🚫: Check `.env` credentials and ensure MySQL is running.
- **Frontend Assets Not Loading** 🌐: Run `npm run dev` or `npm run build`.
- **Redis Connection Issues** 🔒: Verify Redis server is running (`redis-server`) and `.env` settings.
- **Payment Gateway Errors** 💸: Double-check VNPay/Momo API keys in `.env`.

## 🤝 Contributing
Feel free to fork, submit PRs, or open issues! Treat it like contributing to an open-source Laravel package. 🌟

## 📜 License
MIT License (see `LICENSE`).

## 📞 Contact
Got questions? Reach out via [GitHub Issues](https://github.com/binhchay1/buslive/issues) or email (set up in `.env` for admin contact).
