sau khi clone về

sửa file .env.example -> .env 
đổi tên database

chạy lần lược 
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan migrate

chạy chương trình
php artisan serve