# Portfolio

A personal portfolio web app built with **Laravel**, **Inertia.js**, and **React**, designed to showcase your projects and skills.

## 🚀 Tech Stack

- **Backend**: Laravel 12  
- **Frontend**: React (via Inertia.js)  
- **Routing**: Laravel + Inertia  
- **Database**: PostgreSQL  
- **Authentication**: Laravel Breeze (Inertia + React)  
- **Styling**: Tailwind CSS  

## 📦 Requirements

- PHP >= 8.2  
- Composer  
- Node.js + npm  
- PostgreSQL  
- Git  

## 🛠️ Installation

```bash
git clone https://github.com/wikukarno/portfolio.git
cd portfolio

composer install
npm install && npm run dev

cp .env.example .env
php artisan key:generate
```

```env
APP_NAME=Portfolio
APP_ENV=local
APP_KEY=base64:your-app-key
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your-database-name
DB_USERNAME=your-database-username
DB_PASSWORD=your-database-password
```

## 🧪 Migrate & Seed

```bash
php artisan migrate --seed
```

## 🧑‍💻 Dummy User Login

```text
Email: admin@mail.com  
Password: password
```

## 🚴 Running the App

```bash
php artisan serve

# or

composer run dev
```

Visit: [http://localhost:8000](http://localhost:8000)

## ✅ Features

- 🔐 User authentication  
- ⚛️ Laravel Inertia + React SPA setup  
- 🗂️ Category Project CRUD  
- 📁 Project CRUD  
- 🧱 Tech Stack CRUD  
- 🎨 Tailwind CSS UI  
- 👤 Dummy user seeder  
- 🚧 More features coming soon...

## 📄 License

This project is open-source and available under the [MIT License](LICENSE).
