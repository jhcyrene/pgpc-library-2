# Padre Garcia Polytechnic College (PGPC) Library System

🚧 **Status: Under Development** 🚧

> **Note:** This project is currently in active development. Features, database schemas, and UI components are subject to change. It is not yet ready for production deployment.

## Overview
A web-based Integrated Library Management System designed specifically for Padre Garcia Polytechnic College. This system aims to streamline library operations by providing digital tools for cataloging, circulation management, and an Online Public Access Catalog (OPAC) for students and staff.

## Tech Stack
* **Backend:** Laravel (PHP)
* **Frontend:** Laravel Blade, Tailwind CSS v4, DaisyUI
* **Database:** MySQL/ PostgreSql (Supabase)

## Core Modules (Planned/In Progress)
* **OPAC (Online Public Access Catalog):** Allows students to search the library's collection by title, author, or ISBN.
* **Cataloging:** Tools for librarians to add, edit, and manage book records and inventory.
* **Circulation:** Management of borrowing, returning, and tracking overdue materials.
* **Notifications:** In-app system alerts for due dates and account statuses (Note: SMS and Email notifications are excluded from this project scope).

##Database Installation
composer require laravel/breeze --dev
php artisan breeze:install

## Getting Started (For Developers)

If you are pulling this project locally to contribute, follow these steps:

1. **Clone the repository**
   ```bash
   git clone "https://github.com/yourusername/pgpc-library-system.git"
