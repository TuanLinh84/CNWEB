<?php
// Thông tin kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = ""; // Mật khẩu MySQL của bạn, nếu có
$dbname = "csv_demo"; // Tên cơ sở dữ liệu

// Kết nối đến MySQL
$conn = new mysqli($servername, $username, $password);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Tạo cơ sở dữ liệu
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Cơ sở dữ liệu '$dbname' đã được tạo thành công.<br>";
} else {
    echo "Lỗi khi tạo cơ sở dữ liệu: " . $conn->error . "<br>";
}

// Chọn cơ sở dữ liệu
$conn->select_db($dbname);

// Tạo bảng users
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    city VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    courseId VARCHAR(50) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Bảng 'users' đã được tạo thành công.<br>";
} else {
    echo "Lỗi khi tạo bảng: " . $conn->error . "<br>";
}

// Đóng kết nối
$conn->close();
?>
