```
composer install
npm install
cp .env.example .env
php artisan key:generate
```
(update your database settings in `.env`)
```
php artisan migrate:fresh
npm run dev
php artisan serve
```