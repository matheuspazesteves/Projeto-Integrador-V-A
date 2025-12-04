
## ✅ System Requirements (Debian)

### **1. Update system**

```bash
sudo apt update && sudo apt upgrade -y
```

---

## ✅ Required Packages

### **2. PHP 8.3 + Common Extensions**

Laravel 12 requires PHP ^8.3.

Install PHP 8.3 and required extensions:

```bash
sudo apt install -y \
    php8.3 php8.3-cli php8.3-common php8.3-fpm \
    php8.3-mbstring php8.3-xml php8.3-zip php8.3-sqlite3 \
    php8.3-curl php8.3-gd php8.3-bcmath php8.3-intl \
    unzip curl git
```

### Enabled PHP extensions required by Laravel:

* `mbstring`
* `pdo` + `pdo_sqlite`
* `tokenizer`
* `xml`
* `curl`
* `openssl`
* `fileinfo`
* `sqlite3`

✔ The command above installs all of them.

---

## ✅ SQLite (Database Engine)

Laravel 12 uses SQLite in this project.

Install SQLite:

```bash
sudo apt install -y sqlite3
```

Create the application database file if not exists:

```bash
touch database/database.sqlite
```

Verify:

```bash
sqlite3 database/database.sqlite ".tables"
```

---

## ✅ Node.js / NPM (for Vite)

Laravel 12 uses **Vite** to compile frontend assets.

Install Node.js 20 (recommended):

```bash
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs
```

Check versions:

```bash
node -v
npm -v
```

---

## 🧰 Global Tools (optional but recommended)

### **Composer**

If Composer isn’t installed:

```bash
sudo apt install -y composer
```

Or manual:

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

---

# 🚀 Project Installation

Clone project:

```bash
git clone <your-repo-url>
cd <project-folder>
```

---

## 1️⃣ Install Composer Dependencies

```bash
composer install
```

---

## 2️⃣ Create the `.env` file

```bash
cp .env.example .env
```

Generate key:

```bash
php artisan key:generate
```

---

## 3️⃣ Ensure SQLite database exists

```bash
touch database/database.sqlite
```

---

## 4️⃣ Run Migrations

```bash
php artisan migrate
```

---

## 5️⃣ Install Node Dependencies

```bash
npm install
```

---

## 6️⃣ Build assets (production)

```bash
npm run build
```

or for development (hot reload):

```bash
npm run dev
```

---

# ▶️ Running the Application

Start Laravel's built-in server:

```bash
php artisan serve
```

Visit:

```
http://localhost:8000
```

---

# 🛠 Useful Composer Scripts

### **Development environment**

```bash
composer dev
```

This runs:

* Laravel server
* Queue worker
* Laravel Pail
* Vite (hot reload)

### **Setup script**

```bash
composer setup
```

Automatically:

* installs dependencies
* copies `.env`
* generates key
* migrates
* installs node deps
* builds assets

### **Run tests**

```bash
composer test
```

---

# 📁 Project Dependencies (from composer.json)

### **Production**

* `laravel/framework:^12.0`
* `laravel/tinker:^2.10.1`
* `php:^8.3`

### **Development**

* `fakerphp/faker`
* `laravel/pail`
* `laravel/pint`
* `laravel/sail`
* `mockery/mockery`
* `nunomaduro/collision`
* `phpunit/phpunit:^11.5.3`

---

# 🗃 Directory Notes

SQLite database is stored here:

```
database/database.sqlite
```

Blade views in:

```
resources/views/
```

Vite assets:

```
resources/js/
resources/css/
```