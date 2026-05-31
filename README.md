# Task Management System

A simple Task Management System built using Laravel.

---

## Setup Instructions

### 1. Install Dependencies
```
composer install
```

### 2. Copy Environment File
```
copy .env.example .env
```

### 3. Generate Application Key
```
php artisan key:generate
```

### 4. Configure Database

Update the following in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo_sys
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run Migrations
```
php artisan migrate
```

### 6. Seed the Database
```
php artisan db:seed
```

### 7. Start the Application
```
php artisan serve
```

### 8. Open Browser
```
http://127.0.0.1:8000
```

---

## Environment Configuration Checklist

Before running the project, verify that the following are correctly configured in `.env`:

- DB_CONNECTION
- DB_HOST
- DB_PORT
- DB_DATABASE
- DB_USERNAME
- DB_PASSWORD

---

## Database Summary

This project uses two related tables: **tasks** and **categories**.

**`categories` table**
- Stores task categories (e.g. Elective, Core, etc.)
- Each category has an `id` and a `name`

**`tasks` table**
- Stores individual tasks with the following columns:
  - `id` — primary key
  - `title` — name of the task
  - `description` — details about the task
  - `category_id` — foreign key referencing `categories.id`
  - `due_date` — deadline for the task
  - `status` — either `pending` or `completed`
  - `created_at` / `updated_at` — timestamps

**Relationship**
The `tasks.category_id` column is a foreign key that points to the `id` column of the `categories` table. This creates a **one-to-many** relationship — one category can have many tasks, but each task belongs to only one category. For example, a task titled *"Elective - Final Task"* has a `category_id` of `3`, meaning it is grouped under whichever category has `id = 3` in the `categories` table.