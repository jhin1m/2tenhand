# Site Configuration Migration

## ✅ Đã hoàn thành

Đã chuyển đổi cấu hình site từ static file (`site.json`) sang dynamic config từ backend (`config/site.php`).

## 📝 Các thay đổi

### 1. **resources/views/index.blade.php**
- Thêm `site: @json(config('site'))` vào biến global `app`
- Tất cả cấu hình từ `config/site.php` giờ được truyền sang frontend

### 2. **resources/js/globals.js**
- Thay đổi `Vue.prototype.$site` để ưu tiên sử dụng `app.site` từ backend
- Giữ `site.json` làm fallback cho môi trường development

## 🎯 Cách sử dụng

### Cấu hình trong `.env`:

```env
# Website config
SITE=mangareader
SITE_NAME=mangareader
SITE_LETTER=M
SITE_SCRAPERS=hentaihand
SITE_FEATURES=artists,tags,groups,categories,relationships,parodies,characters,languages,dmca
SITE_SOCIAL=http://localhost
SITE_UA=UA-XXXXXXX-X
```

### Các giá trị có sẵn trong Vue components:

```javascript
// Trong bất kỳ Vue component nào:
this.$site.id          // 'mangareader'
this.$site.name        // 'mangareader'
this.$site.letter      // 'M'
this.$site.features    // ['artists', 'tags', ...]
this.$site.social      // ['http://localhost']
this.$site.scrapers    // ['hentaihand']
this.$site.ua          // 'UA-XXXXXXX-X'
this.$site.captcha     // { key: '...', secret: '...' }
```

## 🔍 Ví dụ sử dụng trong Comic.vue

```vue
<!-- Dòng 12 -->
<div class="comic-sauce" v-if="$site.id === 'mangareader'">
    <span>Sauce <strong>{{ comic.id }}</strong></span>
</div>

<!-- Dòng 157 -->
<div v-if="!$app.is_mobile || $site.id === 'eroxhentai'">
    <!-- Chapters/Gallery content -->
</div>
```

## ⚠️ Lưu ý quan trọng

1. **Sau khi thay đổi `.env`**, cần:
   - Xóa cache config: `php artisan config:clear`
   - Reload trang web để nhận cấu hình mới

2. **File `site.json` vẫn được giữ lại** làm fallback, nhưng giá trị từ backend sẽ được ưu tiên.

3. **Để thay đổi cấu hình site**, chỉ cần:
   - Sửa file `.env`
   - Chạy `php artisan config:clear`
   - Reload trang

## 🧪 Kiểm tra cấu hình

Mở browser console và chạy:

```javascript
// Kiểm tra cấu hình từ backend
console.log(app.site);

// Kiểm tra trong Vue DevTools
// Chọn bất kỳ component nào và kiểm tra:
$vm0.$site
```

## 📊 So sánh trước và sau

### Trước:
- ❌ Cấu hình hardcoded trong `site.json`
- ❌ Phải rebuild frontend khi thay đổi config
- ❌ Không đồng bộ với backend config

### Sau:
- ✅ Cấu hình tập trung tại `.env`
- ✅ Không cần rebuild frontend
- ✅ Đồng bộ hoàn toàn với backend
- ✅ Dễ dàng thay đổi cho từng môi trường (dev, staging, production)

## 🚀 Next Steps

Nếu muốn cập nhật cấu hình cho site hiện tại, hãy sửa `.env`:

```env
# Ví dụ cho EroxHentai
SITE=eroxhentai
SITE_NAME=EroxHentai
SITE_LETTER=E
SITE_FEATURES=artists,tags,groups,categories,relationships,parodies,characters,languages,dmca
SITE_SOCIAL=https://eroxhentai.com
```

Sau đó chạy:
```bash
php artisan config:clear
```
