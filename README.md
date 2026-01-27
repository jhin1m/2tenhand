# Manga-Web

Website đọc và quản lý truyện tranh với đầy đủ tính năng cho người dùng và quản trị viên.

## Công nghệ

- **Backend:** Laravel 7.x + Laravel Passport
- **Frontend:** Vue.js 2.x + Vue Router + Vuex
- **Database:** MySQL/PostgreSQL
- **Storage:** S3-compatible storage

## Cài đặt

```bash
# Clone repository
git clone https://github.com/jhin1m/2tenhand
cd 2tenhand

# Cài đặt dependencies
composer install
npm install

# Cấu hình môi trường
cp .env.example .env
php artisan key:generate

# Cấu hình passport
php artisan passport:install

# Chạy migrations
php artisan migrate

# Link storage
php artisan storage:link
```

## Chạy ứng dụng

```bash
# Development server
php artisan serve

# Compile assets (terminal khác)
npm run watch

# Build assets

npm run build
```

## Tính năng chính

- Đọc truyện tranh online
- Tìm kiếm và lọc theo thể loại
- Bình luận và đánh giá
- Quản lý truyện cho admin
- Scraper tự động từ các nguồn
- API RESTful với authentication

## License

MIT
