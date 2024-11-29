<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'flowers_db';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối cơ sở dữ liệu không thành công: " . $conn->connect_error);
}
?>
