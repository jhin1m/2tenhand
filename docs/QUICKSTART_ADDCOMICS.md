# Quick Start Guide - AddComics Command

## Bắt đầu nhanh

### Kiểm tra queue hiện tại
```bash
# Vào terminal MySQL/SQLite và chạy:
SELECT COUNT(*) as total, status 
FROM scraper 
WHERE type = 'index' 
GROUP BY status;
```

### Các lệnh cơ bản nhất

#### 1. Thêm 1 comic đơn lẻ (để test)
```bash
# Ví dụ với Nhentai
php artisan comic:add https://nhentai.net/g/123456

# Ví dụ với HentaiHand
php artisan comic:add https://hentaihand.com/en/12345
```

#### 2. Thêm nhiều comic từ queue
```bash
# Mode interactive - hệ thống sẽ hỏi bạn muốn thêm bao nhiêu
php artisan comics:add

# Hoặc tự động thêm tất cả
php artisan comics:add --all
```

### Test ngay với HentaiHand

```bash
# Bước 1: Thêm scraper HentaiHand vào config
# Sửa file .env:
SITE_SCRAPERS=hentaihand

# Bước 2: Thêm 1 comic để test (mode hotlink)
php artisan comic:add https://hentaihand.com/en/123

# Bước 3: Nếu cần thêm nhiều, tạo index queue trước (hoặc thủ công insert vào DB)
```

### Tạo test data trong queue (Thủ công)

Nếu muốn test ngay mà chưa có scraper index, bạn có thể insert thủ công:

```sql
-- Thêm vào queue để test
INSERT INTO scraper (link, scraper, type, status) VALUES 
('https://hentaihand.com/en/123', 'hentaihand', 'index', 'pending'),
('https://hentaihand.com/en/456', 'hentaihand', 'index', 'pending'),
('https://hentaihand.com/en/789', 'hentaihand', 'index', 'pending');

-- Sau đó chạy:
-- php artisan comics:add --number=3
```

### Các lỗi thường gặp và cách fix

#### ❌ "0 comics indexed and ready to be added"
```bash
# FIX: Thêm comic thủ công vào queue
# Hoặc chạy lệnh thêm đơn lẻ:
php artisan comic:add [URL]
```

#### ❌ "Class 'App\Scrapers\Hentaihand' not found"
```bash
# FIX: Scraper chưa tồn tại hoặc tên sai
# Kiểm tra file scraper có tồn tại không:
ls app/Scrapers/HentaiHand.php

# Kiểm tra tên class trong file phải khớp với tên file
```

#### ❌ "Column 'images' cannot be null"
```bash
# FIX: Scraper không trả về images
# Kiểm tra lại scraper code, đảm bảo $comic['images'] không null
```

### Monitoring Progress

```bash
# Terminal 1: Chạy lệnh add
php artisan comics:add --number=10

# Terminal 2: Monitor database
watch -n 2 'mysql -e "SELECT COUNT(*) FROM comics"'

# Hoặc xem queue còn lại
watch -n 2 'mysql -e "SELECT COUNT(*) FROM scraper WHERE status=\"pending\""'
```

### Best Practices

1. **Test với 1-2 comic trước**
   ```bash
   php artisan comics:add --number=2
   ```

2. **Kiểm tra kết quả trong DB**
   ```sql
   SELECT id, title, slug, created_at FROM comics ORDER BY id DESC LIMIT 5;
   ```

3. **Nếu OK, chạy batch lớn hơn**
   ```bash
   php artisan comics:add --number=50
   ```

4. **Nếu có lỗi, check logs**
   ```bash
   tail -f storage/logs/laravel.log
   ```

### Tips

- Dùng `--start` để resume nếu bị gián đoạn
- Dùng `--failed` để retry những comic lỗi
- Với hotlink mode, quá trình rất nhanh (vài giây/comic)
- Với download mode, có thể mất vài phút/comic tùy số ảnh
