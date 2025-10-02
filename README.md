# Kaiyun Sports WordPress Theme

## Mô tả
Theme WordPress được thiết kế dựa trên giao diện của website Kaiyun Sports, phù hợp cho các trang web cá cược thể thao và giải trí.

## Tính năng chính

### 🎨 Giao diện hiện đại
- Thiết kế responsive, tương thích mọi thiết bị
- Gradient backgrounds đẹp mắt
- Hover effects mượt mà
- Icon CSS thay vì hình ảnh

### 🧭 Hệ thống menu WordPress
- **Top Navigation**: Menu phía trên cùng
- **Main Navigation**: Menu chính với logo
- **Utility Navigation**: Menu tiện ích (客服, 合营, 赞助, 优惠, APP)
- **Footer Menu**: Menu chân trang

### 👤 Phần tài khoản người dùng
- Hiển thị avatar người dùng
- Thông tin VIP level
- Các nút chức năng: 存款, 转账, 取款
- Tự động chuyển đổi giữa đăng nhập/đăng ký

### 📱 Responsive Design
- Tối ưu cho desktop, tablet và mobile
- Menu collapse trên mobile
- Layout linh hoạt

## Cài đặt

1. **Upload theme**:
   - Copy thư mục `kaiyun-sports` vào `wp-content/themes/`
   - Hoặc upload qua WordPress Admin

2. **Kích hoạt theme**:
   - Vào WordPress Admin → Appearance → Themes
   - Chọn "Kaiyun Sports" và click "Activate"

3. **Cấu hình menu**:
   - Vào Appearance → Menus
   - Tạo menu mới cho từng vị trí:
     - Top Navigation
     - Main Navigation  
     - Utility Navigation
     - Footer Menu

## Cấu hình Menu

### Main Navigation (Menu chính)
Tạo menu với các items:
- 首页 (Trang chủ)
- 体育 (Thể thao)
- 真人 (Casino trực tiếp)
- 棋牌 (Cờ bạc)
- 电竞 (Thể thao điện tử)
- 彩票 (Xổ số)
- 电子 (Điện tử)
- 娱乐 (Giải trí)

### Utility Navigation (Menu tiện ích)
- 客服 (Dịch vụ khách hàng)
- 合营 (Đối tác)
- 赞助 (Tài trợ)
- 优惠 (Khuyến mãi)
- APP (Ứng dụng)

## Tùy chỉnh

### Customizer
Vào Appearance → Customize để tùy chỉnh:
- Hero Section: Tiêu đề, phụ đề, nút bấm
- Màu sắc và typography
- Logo và favicon

### Custom Post Types
Theme hỗ trợ:
- **Sports Events**: Sự kiện thể thao
- **Games**: Game và trò chơi

### Widget Areas
- Sidebar
- Footer Widgets

## Cấu trúc file

```
kaiyun-sports/
├── style.css              # CSS chính
├── index.php              # Trang chủ
├── header.php             # Header
├── footer.php             # Footer
├── functions.php          # Functions và hooks
├── single.php             # Trang chi tiết bài viết
├── page.php               # Trang tĩnh
├── archive.php            # Trang danh sách
├── search.php             # Trang tìm kiếm
├── css/
│   └── icons.css          # CSS cho icons
├── js/
│   └── main.js            # JavaScript
└── images/                # Thư mục hình ảnh
```

## Hỗ trợ

Theme được thiết kế tương thích với:
- WordPress 5.0+
- PHP 7.4+
- Tất cả trình duyệt hiện đại

## Chú ý

- Theme sử dụng CSS icons thay vì hình ảnh để tối ưu tốc độ
- Cần cấu hình menu để hiển thị đúng giao diện
- Responsive design tự động điều chỉnh trên mobile

## Phiên bản

- **Version**: 1.0
- **Author**: Your Name
- **License**: GPL v2 or later

