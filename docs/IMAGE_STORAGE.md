# Image Storage Configuration

## Chế độ lưu trữ ảnh (Image Storage Mode)

Hệ thống hỗ trợ 4 chế độ lưu trữ ảnh cho manga/comic:

### 1. Hotlink (Mặc định)
```env
IMAGE_STORAGE_MODE=hotlink
```
- **Mô tả**: Sử dụng URL gốc của ảnh, không tải xuống
- **Ưu điểm**: 
  - Nhanh nhất
  - Không tốn dung lượng lưu trữ
  - Không tốn băng thông
- **Nhược điểm**:
  - Phụ thuộc vào nguồn gốc
  - Ảnh có thể bị mất nếu nguồn xóa
  - Có thể chậm nếu nguồn chậm
- **Khuyến nghị**: Phù hợp cho testing hoặc khi muốn tiết kiệm tài nguyên

### 2. Local Storage
```env
IMAGE_STORAGE_MODE=local
```
- **Mô tả**: Tải xuống và lưu trữ trong `storage/app/comics/`
- **Ưu điểm**:
  - Độc lập với nguồn gốc
  - Tốc độ truy cập nhanh
  - Kiểm soát hoàn toàn
- **Nhược điểm**:
  - Tốn dung lượng ổ đĩa
  - Cần cấu hình symlink để truy cập public
- **Khuyến nghị**: Phù hợp cho môi trường development

### 3. Public Storage
```env
IMAGE_STORAGE_MODE=public
```
- **Mô tả**: Tải xuống và lưu trữ trong `public/comics/`
- **Ưu điểm**:
  - Truy cập trực tiếp qua web
  - Không cần symlink
  - Tốc độ nhanh
- **Nhược điểm**:
  - Tốn dung lượng ổ đĩa
  - Có thể bị truy cập trực tiếp
- **Khuyến nghị**: Phù hợp cho production với server riêng

### 4. S3 Storage
```env
IMAGE_STORAGE_MODE=s3
```
- **Mô tả**: Tải xuống và upload lên S3-compatible storage (AWS S3, DigitalOcean Spaces, Ceph, etc.)
- **Ưu điểm**:
  - Scalable
  - CDN tích hợp
  - Backup tự động
  - Không giới hạn dung lượng
- **Nhược điểm**:
  - Tốn chi phí storage
  - Phụ thuộc vào dịch vụ bên thứ 3
- **Yêu cầu**: Cấu hình thông tin S3 trong `config/filesystems.php`
- **Khuyến nghị**: Phù hợp cho production với lưu lượng lớn

## Cấu hình S3

Nếu sử dụng chế độ S3, cần cấu hình trong `.env`:

```env
AWS_ACCESS_KEY_ID=your-access-key
AWS_SECRET_ACCESS_KEY=your-secret-key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket-name
AWS_URL=https://your-bucket.s3.amazonaws.com
```

## Thay đổi chế độ lưu trữ

1. Chỉnh sửa file `.env`:
   ```env
   IMAGE_STORAGE_MODE=hotlink  # hoặc local, public, s3
   ```

2. Không cần restart server, cấu hình được đọc mỗi lần chạy scraper

3. Chạy scraper:
   ```bash
   php artisan comic:add [URL]
   ```

## Lưu ý

- Chế độ lưu trữ chỉ áp dụng cho comic/chapter mới được thêm vào
- Comic cũ sẽ giữ nguyên cách lưu trữ ban đầu
- Với chế độ `hotlink`, không có file nào được lưu trên server
- Với các chế độ khác, file sẽ được tải xuống và lưu trữ theo cấu hình
