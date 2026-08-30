
# Nsential - Professional Blog CMS

A fully-featured, production-ready Blog Content Management System tailored for modern content creators and businesses.

![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)
![Docker](https://img.shields.io/badge/Docker-Ready-blue.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)
![Status](https://img.shields.io/badge/Status-Production%20Ready-brightgreen.svg)

---

## 📖 Overview

**Nsential** is a professional Blog CMS built on the robust Laravel framework, designed to provide clients with a powerful, scalable, and easy-to-manage content platform. Whether you're a blogger, a business, or an agency, Nsential offers the tools you need to publish, organize, and grow your content effortlessly.

This project was developed with a strong focus on **performance**, **security**, and **ease of deployment**—making it an ideal solution for clients who need a reliable content management system without the complexity.

---

## ✨ Key Features

### For Content Managers
- **📝 Post Management** – Create, edit, publish, and delete blog posts with ease
- **🏷️ Category System** – Organize content into categories for better navigation
- **👤 User Profiles** – Manage user accounts and roles
- **🔍 SEO-Friendly** – Clean URLs and metadata support 

### For Developers & Admins
- **🐳 Docker Ready** – Pre-configured for containerized development & production
- **⚡ Production Optimized** – Nginx configuration for high traffic performance
- **🔐 Secure** – Built with Laravel's security best practices
- **📦 Scalable** – Ready to handle growing content and traffic
- **🧩 Easy to Extend** – Clean, well-structured codebase

---

## 🛠️ Technology Stack

| Layer | Technology |
|-------|------------|
| **Framework** | Laravel 11.x |
| **Language** | PHP 8.2+ |
| **Frontend** | Blade, Tailwind CSS, Vite |
| **Database** | MySQL / PostgreSQL / SQLite |
| **Web Server** | Nginx (Production) |
| **Containerization** | Docker & Docker Compose |
| **Version Control** | Git |

---

## 🚀 Quick Start Guide

### Option 1: Docker Deployment (Recommended)

```bash
# Clone the repository
git clone https://github.com/bilal-157/Nsential.git
cd Nsential

# Set up environment
cp .env.example .env

# Start Docker containers
docker-compose up -d --build

# Install dependencies
docker-compose exec app composer install
docker-compose exec app npm install

# Generate app key & run migrations
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate --seed

# Build frontend assets
docker-compose exec app npm run build
```

The application will be available at `http://localhost:8080`

### Option 2: Manual Installation

```bash
# Clone & install dependencies
git clone https://github.com/bilal-157/Nsential.git
cd Nsential
composer install
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Configure your database in .env and run migrations
php artisan migrate --seed
npm run build

# Start the application
php artisan serve
```

---

## ⚙️ Environment Configuration

Key environment variables for client deployment:

```env
# Application Settings
APP_NAME=Nsential
APP_ENV=production        # Change to 'production' for live deployment
APP_DEBUG=false          # Always set to false in production
APP_URL=https://yourdomain.com

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog_cms
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

---

## 📁 Project Structure Highlights

```
Nsential/
├── app/               # Core application logic
├── config/            # Application configuration
├── database/          # Migrations & seeders
├── docker/            # Docker configuration files
├── public/            # Public assets & entry point
├── resources/         # Views, styles, & frontend assets
├── routes/            # Web & API routes
├── storage/           # Logs, cache, & uploads
├── .env.example       # Environment template
├── docker-compose.yml # Container orchestration
└── composer.json      # PHP dependencies
```

---

## 🔧 Maintenance & Administration

### Common Commands

```bash
# Database management
php artisan migrate:fresh --seed

# Cache clearing
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Run in Docker
docker-compose exec app php artisan <command>

# View container logs
docker-compose logs -f
```

### Backup Recommendations
- Regularly backup the database
- Backup `storage/` directory for uploaded media
- Keep `.env` configuration secure

---

## 🤝 Support & Maintenance

This project is actively maintained. For support or feature requests:

- **Issues**: Use the [GitHub Issues](https://github.com/bilal-157/Nsential/issues) tracker
- **Contact**: Reach out to the development team for urgent matters

---

## 📄 License

This project is licensed under the **MIT License** – see the [LICENSE](https://opensource.org/licenses/MIT) file for details.

---

## 🙏 Acknowledgments

- **Laravel** – The incredible PHP framework powering this CMS
- **Tailwind CSS** – For the clean, responsive UI
- **Docker** – For seamless deployment
- **Nginx** – For reliable production serving

---

<div align="center">
  <sub>Built with ❤️ for clients who value quality content management</sub>
</div>
