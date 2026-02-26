# Project Management App

A comprehensive Project Management System built with **Laravel 10**, **Inertia.js**, **Vue 3**, and **PostgreSQL**. This application allows users to manage projects and tasks efficiently with role-based features and real-time feel.

---

## 🚀 Key Features

- **Authentication**: Secure login and registration with Laravel Breeze.
- **Projects Management**: Create, update, and delete projects.
- **Tasks Management**: Manage tasks within projects with status tracking (`Pending`, `InProgress`, `Completed`).
- **User Dashboard**: Overview of projects and task statistics.
- **Responsive UI**: Modern interface built with Tailwind CSS and Vue 3.
- **Profile Management**: Update user information and manage account security.

---

## 🛠️ Technology Stack

- **Backend**: [Laravel 10](https://laravel.com/)
- **Frontend**: [Vue 3](https://vuejs.org/) with [Inertia.js](https://inertiajs.com/)
- **Styling**: [Tailwind CSS](https://tailwindcss.com/)
- **Database**: [PostgreSQL](https://www.postgresql.org/)
- **Build Tool**: [Vite](https://vitejs.dev/)

---

## 📦 Installation Guide

Follow these steps to set up the project locally.

### 1. Prerequisites
Ensure you have the following installed:
- PHP >= 8.1
- Composer
- Node.js & NPM
- PostgreSQL

### 2. Clone the Repository
```bash
git clone <repository-url>
cd project-management-app
```

### 3. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Javascript dependencies
npm install
```

### 4. Environment Setup
Copy the `.env.example` file to `.env` and configure your database settings.
```bash
cp .env.example .env
```
Open `.env` and update the database configuration:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Run Migrations & Seeders
```bash
php artisan migrate --seed
```

### 7. Compile Assets
```bash
# For development
npm run dev

# For production
npm run build
```

### 8. Start the Server
```bash
php artisan serve
```
Access the application at `http://localhost:8000`.

---

## 📁 Project Structure (Key Folders)

- `app/Models`: Database models (User, Project, Task).
- `app/Http/Controllers`: Backend logic for handling requests.
- `resources/js/Pages`: Vue components for the frontend.
- `routes/web.php`: Web routes configuration.
- `database/migrations`: Database schema definitions.

---

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
