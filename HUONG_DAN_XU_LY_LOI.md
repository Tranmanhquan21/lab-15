# LAB 15 – Topic 3: Hướng dẫn xử lý lỗi triển khai

Khi gặp **lỗi 500 / lỗi DB / đường dẫn include / upload không được**, kiểm tra theo thứ tự sau.

## 1. Lỗi 500 (Internal Server Error)
- **Log:** Mở **storage/logs/app.log** – xem dòng cuối (lỗi DB, exception, đường dẫn).
- **Cấu hình:** Production đặt `display_errors = 0`; lỗi chỉ ghi vào log.
- **Quyền:** Thư mục **storage/logs/** phải ghi được (chmod 755/775).
- **PHP:** Hosting hỗ trợ PHP 8.x.

## 2. Lỗi kết nối cơ sở dữ liệu
- **Log:** Trong app.log tìm `[ERROR] DB connection error: ...` – nội dung sau là nguyên nhân.
- **Config:** Kiểm tra **config/config.prod.php**: db_host (thường `localhost`), db_name, db_user, db_pass khớp với DB đã tạo trên hosting.
- **DB:** Đã tạo database + user và gán quyền chưa; đã import **db.sql** chưa.

## 3. Đường dẫn include / file not found
- Ứng dụng chạy từ **public/index.php**; các đường dẫn dùng `__DIR__`, `dirname(__DIR__)`.
- Đã upload đủ **app/**, **config/**, **public/**, **storage/** chưa.
- Document Root: nếu không trỏ vào **public/** thì có thể phải chỉnh URL hoặc cấu hình host.

## 4. Upload ảnh không được / không hiển thị ảnh
- **Log:** Tìm `Upload rejected` hoặc `Upload move_uploaded_file failed` trong app.log.
- **Quyền:** **public/uploads/** phải ghi được.
- **URL ảnh:** Kiểm tra baseUrl trong view; URL dạng .../uploads/xxx.jpg.
- **PHP:** upload_max_filesize, post_max_size trên hosting >= 2MB.

**Tóm tắt:** Ưu tiên xem **storage/logs/app.log** → kiểm tra **config** (DB) và **quyền thư mục** (uploads, logs).
