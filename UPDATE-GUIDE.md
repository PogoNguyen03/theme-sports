# Hướng dẫn cập nhật theme Kaiyun Sports

## Các thay đổi đã thực hiện:

### 1. Cập nhật Header Structure
- Đã cập nhật `header.php` để sử dụng cấu trúc HTML từ file `index.html` gốc
- Thêm các class CSS mới: `header-container`, `header-top`, `header-main`, `header-left`, `header-right`
- Tích hợp WordPress menu system với custom walkers

### 2. Tạo CSS mới
- `css/header-new.css`: CSS cho header mới
- `css/main.css`: CSS cho nội dung chính
- `css/icons.css`: CSS cho các icon

### 3. Custom Menu Walkers
- `inc/class-kaiyun-menu-walker.php`: Walker cho main navigation
- `inc/class-kaiyun-utility-menu-walker.php`: Walker cho utility navigation

### 4. Cập nhật functions.php
- Enqueue các CSS file mới
- Load custom walker classes

## Cách sử dụng:

### 1. Kích hoạt theme
- Upload folder `kaiyun-sports` vào `wp-content/themes/`
- Vào WordPress Admin > Appearance > Themes
- Kích hoạt theme "Kaiyun Sports"

### 2. Cấu hình menu
- Vào Appearance > Menus
- Tạo menu mới cho "Main Navigation" với các item:
  - 首页 (Homepage)
  - 体育 (Sports) 
  - 真人 (Live Casino)
  - 棋牌 (Chess & Card)
  - 电竞 (Esports)
  - 彩票 (Lottery)
  - 电子 (Electronic Games)
  - 娱乐 (Entertainment)

- Tạo menu cho "Utility Navigation" với các item:
  - 客服 (Customer Service)
  - 合营 (Partnership)
  - 赞助 (Sponsorship)
  - 优惠 (Promotions)
  - APP (Application)

### 3. Cấu hình logo
- Vào Appearance > Customize > Site Identity
- Upload logo của bạn
- Hoặc sử dụng logo mặc định đã được tích hợp

## Lưu ý:
- Theme đã được tối ưu cho responsive design
- Sử dụng CSS Grid và Flexbox cho layout
- Tích hợp đầy đủ WordPress menu system
- Hỗ trợ custom post types cho sports events và games

## Troubleshooting:
- Nếu menu không hiển thị, kiểm tra xem đã assign menu đúng location chưa
- Nếu CSS không load, kiểm tra file permissions
- Nếu có lỗi PHP, kiểm tra PHP version (cần >= 7.4)