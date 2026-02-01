# LAB 14 & LAB 15 – Gộp chung theo yêu cầu

Dự án CRUD quản lý sản phẩm đáp ứng **đủ yêu cầu Lab 14** (3 topic) và **Lab 15** (3 topic).

---

## LAB 14 – 3 Topic

### Topic 1 – Phân trang (Pagination)
- Mỗi trang **5** bản ghi; thanh điều hướng **First / Prev / số trang / Next / Last**.
- Hiển thị **Trang X/Y – Tổng Z bản ghi**; giữ `?page=` khi xem/sửa/xóa.
- Model: `countAll()`, `getPage($limit, $offset)` với LIMIT/OFFSET.
- Ràng buộc: page < 1 → 1; page > tổng trang → trang cuối.

### Topic 2 – Upload ảnh
- Form Add/Edit: chọn ảnh, lưu vào `public/uploads/`, lưu đường dẫn vào DB.
- Edit: thay ảnh mới thì xóa ảnh cũ. Danh sách: thumbnail; chi tiết: ảnh lớn hơn.
- **An toàn:** whitelist jpg, jpeg, png, webp; tối đa 2MB; đổi tên `uniqid().ext`; chặn file nguy hiểm.

### Topic 3 – Flash message + PRG
- Thông báo **1 lần** (success/error) sau Add/Edit/Delete rồi tự mất.
- Dùng `$_SESSION`; **Post-Redirect-Get** tránh submit lại khi F5.
- Helper: `set_flash($key, $msg)` và `get_flash($key)` (lấy xong unset).

---

## LAB 15 – 3 Topic

### Topic 1 – Đóng gói + cấu hình
- Cấu trúc: **app/** (MVC), **public/** (index.php, assets, uploads), **config/**, **storage/logs/**.
- Tách cấu hình: **config.local.php** / **config.prod.php**; không hard-code thông tin production.

### Topic 2 – Deploy + Checklist
- File **db.sql** để import trên hosting.
- File **CHECKLIST_TRIEN_KHAI.md**: chuẩn bị, tạo DB, import, upload code, cấu hình, test, backup.

### Topic 3 – Log + xử lý lỗi
- Ghi log ra **storage/logs/app.log**: lỗi kết nối DB, lỗi upload (đuôi/dung lượng), exception.
- Production: `display_errors = 0`, vẫn ghi log.
- File **HUONG_DAN_XU_LY_LOI.md**: khi gặp lỗi 500/DB/đường dẫn/upload thì kiểm tra gì (log + config).

---

## Cấu trúc thư mục

```
LAB 14 & LAB 15/
├── app/
│   ├── Product.php
│   ├── ProductController.php
│   ├── helpers.php
│   └── views/       (list, show, create, edit)
├── config/
│   ├── config.php
│   ├── config.local.php
│   └── config.prod.php
├── public/
│   ├── index.php
│   ├── uploads/
│   └── .htaccess
├── storage/
│   └── logs/        (app.log)
├── db.sql
├── README.md
├── CHECKLIST_TRIEN_KHAI.md
└── HUONG_DAN_XU_LY_LOI.md
```

---

## Chạy (localhost)

1. Tạo database **lab14_15**, import **db.sql** (phpMyAdmin).
2. Sửa **config/config.local.php** nếu cần (user/pass MySQL).
3. Mở: `http://localhost/LAB%2014%20%26%20LAB%2015/public/index.php`

## Deploy (Lab 15)

- Cập nhật **config/config.prod.php** với thông tin DB trên hosting.
- Làm theo **CHECKLIST_TRIEN_KHAI.md**; khi lỗi xem **HUONG_DAN_XU_LY_LOI.md** và **storage/logs/app.log**.
