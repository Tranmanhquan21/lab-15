# LAB 15 – Topic 2: Checklist triển khai (Deploy)

## 1. Chuẩn bị
- [ ] Tài khoản hosting PHP + MySQL (cPanel/DirectAdmin)
- [ ] FileZilla hoặc File Manager
- [ ] phpMyAdmin trên hosting
- [ ] Đã test chạy ổn trên local

## 2. Xuất CSDL
- [ ] Dùng file **db.sql** trong project (hoặc Export từ phpMyAdmin local)

## 3. Tạo database trên hosting
- [ ] Tạo database mới
- [ ] Tạo user MySQL, gán quyền
- [ ] Ghi lại: tên DB, user, mật khẩu

## 4. Import db.sql
- [ ] phpMyAdmin → chọn database → Import → chọn db.sql → Execute
- [ ] Kiểm tra bảng `products` đã có

## 5. Cập nhật cấu hình
- [ ] Sửa **config/config.prod.php**: db_host, db_name, db_user, db_pass
- [ ] Đảm bảo `display_errors => 0`
- [ ] Không commit mật khẩu thật lên repo

## 6. Upload source
- [ ] Upload vào public_html (hoặc thư mục web root)
- [ ] Document Root trỏ vào thư mục **public/** (nếu được) hoặc truy cập .../public/index.php

## 7. Phân quyền
- [ ] **public/uploads/** – quyền ghi (755 hoặc 775)
- [ ] **storage/logs/** – quyền ghi

## 8. Kiểm thử
- [ ] Danh sách + phân trang (First/Prev/Next/Last, Trang X/Y)
- [ ] Thêm sản phẩm (có upload ảnh)
- [ ] Sửa (thay ảnh, xóa ảnh cũ)
- [ ] Xóa
- [ ] Flash message (1 lần, F5 không gửi lại)
- [ ] Ảnh hiển thị đúng (thumbnail + chi tiết)

## 9. Backup
- [ ] Backup database (export db.sql)
- [ ] Backup source và uploads nếu cần

Khi lỗi: xem **HUONG_DAN_XU_LY_LOI.md** và **storage/logs/app.log**.
