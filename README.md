🌿 Hướng Dẫn Cài Đặt Dự Án

🚀 Bắt Đầu

🔹 1. Clone Repository

git clone <repository-link>  
cd <project-folder>  

🔹 2. Cài Đặt Thư Viện

composer install  

🔹 3. Cấu Hình Môi Trường

📌 Đổi tên file .env.example thành .env

cp .env.example .env  

📌 Tạo khóa ứng dụng

php artisan key:generate  

🔹 4. Cấu Hình Database

📌 Mở file .env và chỉnh sửa dòng sau:

DB_DATABASE=ten_database_cua_ban  

cấu hình email để gửi mail

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME="gmail của bạn"
MAIL_PASSWORD="mật khẩu "
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="gmail của bạn"
MAIL_FROM_NAME="Flower Shop"

🔹 5. Xóa Cache Và Chạy Migration

php artisan config:clear  
php artisan cache:clear  
php artisan config:cache  
php artisan migrate  

🔹 6. Chạy Dự Án

php artisan serve  

📌 Mở trình duyệt và truy cập:🔗 http://127.0.0.1:8000