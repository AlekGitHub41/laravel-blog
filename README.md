# Laravel Blog
## Команды для запуска
#### 1. Создайте базу данных "Laravel" используя систему MySQL
#### 2. Установите необходимые зависимости
```bash
composer install
npm install
```
#### 3. Переименуйте .env.example в .env
#### 4. Выполните следующие команды
```bash
php artisan migrate
php artisan view:clear
php artisan cache:clear
php artisan storage:link
npm run dev
php artisan serve
```