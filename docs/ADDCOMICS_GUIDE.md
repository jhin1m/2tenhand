# Hướng dẫn sử dụng lệnh AddComics

## Tổng quan

Lệnh `comics:add` được sử dụng để tự động thêm nhiều comic từ queue scraper vào database.

## Cú pháp

```bash
php artisan comics:add [options]
```

## Options (Tùy chọn)

### 1. `--all` hoặc `-A`
Tự động thêm TẤT CẢ comic trong queue mà không hỏi số lượng.

```bash
php artisan comics:add --all
# Hoặc viết tắt
php artisan comics:add -A
```

### 2. `--start=N`
Bỏ qua N comic đầu tiên trong queue (mặc định: 0).

```bash
# Bỏ qua 10 comic đầu tiên
php artisan comics:add --start=10

# Bỏ qua 50 comic đầu tiên và thêm tất cả còn lại
php artisan comics:add --all --start=50
```

### 3. `--number=N`
Thêm chính xác N comic (không hỏi số lượng).

```bash
# Thêm chính xác 20 comic
php artisan comics:add --number=20

# Bỏ qua 10 comic đầu, thêm 15 comic tiếp theo
php artisan comics:add --start=10 --number=15
```

### 4. `--failed` hoặc `-F`
Bao gồm cả comic đã failed trước đó để thử lại.

```bash
# Thêm comic và retry những cái đã failed
php artisan comics:add --failed -A

# Hoặc viết tắt
php artisan comics:add -F -A
```

## Ví dụ sử dụng

### Ví dụ 1: Chạy interactive mode (hỏi số lượng)
```bash
php artisan comics:add
```
- Hệ thống sẽ hiển thị số comic có sẵn
- Hỏi bạn muốn thêm bao nhiêu comic
- Bạn nhập số và Enter

### Ví dụ 2: Thêm tất cả comic trong queue
```bash
php artisan comics:add --all
```

### Ví dụ 3: Thêm chính xác 50 comic
```bash
php artisan comics:add --number=50
```

### Ví dụ 4: Thêm 30 comic, bỏ qua 20 cái đầu
```bash
php artisan comics:add --start=20 --number=30
```

### Ví dụ 5: Retry tất cả comic đã failed
```bash
php artisan comics:add --failed --all
```

### Ví dụ 6: Kết hợp nhiều options
```bash
# Bỏ qua 100 comic đầu, thêm 50 comic, bao gồm cả failed
php artisan comics:add --start=100 --number=50 --failed
```

## Cách hoạt động

1. **Đọc config scrapers**: Lệnh đọc danh sách scrapers từ `config/site.php` (biến `SITE_SCRAPERS`)

2. **Chạy từng scraper**: Với mỗi scraper trong config, lệnh sẽ:
   - Kích hoạt scraper đó
   - Tìm các comic trong queue (table `scraper`) với status `pending` (và `failed` nếu có option `-F`)
   - Gọi `comic:add` cho từng comic

3. **Progress bar**: Hiển thị tiến trình xử lý

4. **Auto proxy rotation**: Tự động thay đổi proxy sau mỗi 3 comic hoặc khi có lỗi

5. **Error handling**: Log lỗi và tiếp tục với comic tiếp theo nếu có lỗi

## Cấu hình Scrapers

Để sử dụng scraper nào, cấu hình trong file `.env`:

```env
# Single scraper
SITE_SCRAPERS=nhentaicom

# Multiple scrapers (phân cách bằng dấu phẩy)
SITE_SCRAPERS=nhentaicom,hentaihand,hitomi
```

## Lưu ý quan trọng

⚠️ **Trước khi chạy `comics:add`, bạn cần:**

1. **Đã chạy index/scrape trước đó** để có comic trong queue
2. **Kiểm tra queue** có comic chưa:
   ```sql
   SELECT COUNT(*) FROM scraper WHERE status = 'pending' AND type = 'index';
   ```

3. **Đảm bảo có proxy** (nếu cần) trong `config/proxies.json`

4. **Cấu hình storage mode** trong `.env`:
   ```env
   IMAGE_STORAGE_MODE=hotlink  # hoặc local, public, s3
   ```

## Troubleshooting

### Lỗi: "0 comics indexed and ready to be added"
**Nguyên nhân**: Chưa có comic trong queue

**Giải pháp**: 
- Chạy lệnh index trước (nếu có)
- Hoặc thêm comic thủ công bằng `php artisan comic:add [URL]`

### Lỗi: "Failed to add..."
**Nguyên nhân**: 
- Website nguồn bị block
- Proxy không hoạt động
- Lỗi scraper

**Giải pháp**:
- Kiểm tra proxy
- Kiểm tra scraper có hoạt động không
- Xem log chi tiết trong `storage/logs/laravel.log`
- Retry với option `--failed`

### Comic bị duplicate
**Nguyên nhân**: Comic đã tồn tại trong database

**Giải pháp**: Hệ thống tự động skip, không thêm duplicate

## Workflow đề xuất

### Workflow 1: Thêm comic mới đầy đủ
```bash
# Bước 1: Chạy index (nếu scraper hỗ trợ)
# php artisan scraper:index [scraper]

# Bước 2: Kiểm tra số lượng trong queue
# SELECT COUNT(*) FROM scraper WHERE status = 'pending';

# Bước 3: Thêm tất cả comic
php artisan comics:add --all
```

### Workflow 2: Thêm từng batch nhỏ
```bash
# Lần 1: Thêm 20 comic đầu
php artisan comics:add --number=20

# Lần 2: Bỏ qua 20, thêm 20 tiếp
php artisan comics:add --start=20 --number=20

# Lần 3: Bỏ qua 40, thêm 20 tiếp
php artisan comics:add --start=40 --number=20
```

### Workflow 3: Retry failed comics
```bash
# Bước 1: Thử thêm tất cả
php artisan comics:add --all

# Bước 2: Sau đó retry những cái failed
php artisan comics:add --failed --all
```

## Hiệu suất

- **Tốc độ**: Phụ thuộc vào:
  - Tốc độ website nguồn
  - Số lượng ảnh mỗi comic
  - Storage mode (hotlink nhanh nhất)
  - Proxy speed
  
- **Ước tính thời gian**:
  - Hotlink mode: ~5-10 giây/comic
  - Download mode: ~30-60 giây/comic (tùy số ảnh)
  - S3 mode: ~60-120 giây/comic

## Xem thêm

- [Image Storage Configuration](IMAGE_STORAGE.md) - Hướng dẫn cấu hình lưu trữ ảnh
- `php artisan comic:add --help` - Xem help cho lệnh thêm 1 comic
