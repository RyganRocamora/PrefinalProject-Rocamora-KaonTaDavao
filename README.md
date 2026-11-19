# Kaon Ta! Davao Rocamora's Food Guide

**Student Name:** Rygan Rocamora  
**Course:** 4-334 CS Elective 2 — Full-Stack Development (Laravel)  
**Project:** Prefinal Milestone Project (Laravel 12, SQLite, Tailwind CSS via Vite)

---

## Setup Instructions

Run the following commands on a fresh clone to install dependencies, migrate and seed the SQLite database, build frontend assets, and start the local server[cite: 7]:

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate:fresh --seed
npm install
npm run build
php artisan serve