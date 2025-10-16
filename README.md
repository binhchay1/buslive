# BusLive – Hệ thống Đặt Vé Xe Khách Thông Minh

BusLive là ứng dụng web hiện đại giúp hành khách dễ dàng tìm kiếm, đặt vé và chọn ghế cho các chuyến xe khách liên tỉnh tại Việt Nam. Đồng thời, hệ thống cũng hỗ trợ các nhà xe quản lý thông tin xe, tuyến đường và địa điểm một cách trực quan và hiệu quả.

## 🔑 Tính Năng Chính

### 🚍 Đối với Hành Khách

- **Tìm kiếm chuyến xe theo điểm đi/đến, ngày giờ**: Hỗ trợ lọc nhanh theo tỉnh thành, thời gian và hãng xe.
- **Chọn ghế trực quan**: Giao diện đặt ghế tương tác, hiển thị sơ đồ ghế theo từng xe.
- **Thanh toán trực tuyến**: Hỗ trợ nhiều phương thức thanh toán phổ biến tại Việt Nam.
- **Lịch sử đặt vé**: Quản lý lịch sử đặt vé và thông tin hành trình.

### 🏢 Đối với Nhà Xe

- **Quản lý thông tin nhà xe**: Thêm, sửa, xóa thông tin nhà xe, bao gồm tên, logo, mô tả.
- **Quản lý xe và tuyến đường**: Thêm, sửa, xóa xe, tuyến đường, điểm dừng, thời gian khởi hành.
- **Quản lý ghế và giá vé**: Đặt cấu hình ghế ngồi, giá vé theo loại ghế và thời gian.

### 🛠️ Quản Trị Hệ Thống

- **Quản lý người dùng**: Phân quyền cho hành khách, nhà xe và quản trị viên.
- **Quản lý địa điểm**: Thêm, sửa, xóa các tỉnh thành và điểm dừng.
- **Báo cáo và thống kê**: Xem thống kê doanh thu, số lượng vé đã bán, số lượng ghế còn trống.

## 🧱 Kiến Trúc Hệ Thống

- **Backend**: PHP (Laravel)
- **Frontend**: HTML, CSS, JavaScript (Vue.js)
- **Cơ sở dữ liệu**: MySQL
- **Quản lý phiên làm việc**: Redis
- **Thanh toán trực tuyến**: Tích hợp với các cổng thanh toán phổ biến tại Việt Nam.

## 🚀 Hướng Dẫn Cài Đặt

### 1. Clone Repository

```bash
git clone https://github.com/binhchay1/buslive.git
cd buslive
```

### 2. Cài Đặt Phụ Thuộc

```bash
composer install
npm install
```

### 3. Cấu Hình Môi Trường

- Tạo file `.env` từ file mẫu:

  ```bash
  cp .env.example .env
  ```

- Cập nhật thông tin cấu hình trong `.env`, bao gồm:
  - Thông tin cơ sở dữ liệu
  - Thông tin cổng thanh toán
  - Thông tin email và SMS

### 4. Chạy Migrations và Seeders

```bash
php artisan migrate --seed
```

### 5. Chạy Ứng Dụng

```bash
php artisan serve
```

Truy cập ứng dụng tại `http://localhost:8000`.

## 📄 Giấy Phép và Quyền Sở Hữu

Dự án này được phát hành theo [Giấy phép MIT](LICENSE).

## 📞 Liên Hệ

- Email: [email@example.com](mailto:email@example.com)
- Website: [https://buslive.vn](https://buslive.vn)

