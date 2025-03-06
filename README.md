# Project Setup
composer update
# Project Setup .env
cp .env.example .env
# Project Setup Key
php artisan key:generate
# Project Setup migrate
php artisan migrate
# Create Permission
php artisan db:seed --class=PermissionTableSeeder
# Admin Create
php artisan db:seed --class=CreateAdminUserSeeder