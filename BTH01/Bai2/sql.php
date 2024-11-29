<?php
$servername = "localhost";
$username = "root"; 
$password = "";     

$conn = new mysqli($servername, $username, $password);


if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}


$sql_create_db = "CREATE DATABASE IF NOT EXISTS quiz_app";
if ($conn->query($sql_create_db) === TRUE) {
    echo "Tạo cơ sở dữ liệu 'quiz_app' thành công.<br>";
} else {
    die("Lỗi khi tạo cơ sở dữ liệu: " . $conn->error);
}

$conn->select_db("quiz_app");


$sql_create_table = "
CREATE TABLE IF NOT EXISTS questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    options TEXT NOT NULL,
    answer TEXT NOT NULL
)";
if ($conn->query($sql_create_table) === TRUE) {
    echo "Tạo bảng 'questions' thành công.<br>";
} else {
    die("Lỗi khi tạo bảng: " . $conn->error);
}

$sql = "
CREATE TABLE IF NOT EXISTS uploaded_files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    file_name VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Bảng 'uploaded_files' đã được tạo thành công (hoặc đã tồn tại).";
} else {
    echo "Lỗi tạo bảng: " . $conn->error;
}

$conn->close();
?>
