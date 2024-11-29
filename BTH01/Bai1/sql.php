<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'flowers_db';

$conn = new mysqli($host, $username, $password);

if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

$sqlCreateDB = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sqlCreateDB) === TRUE) {
    echo "Cơ sở dữ liệu '$dbname' đã được tạo hoặc đã tồn tại.<br>";
} else {
    die("Lỗi khi tạo cơ sở dữ liệu: " . $conn->error);
}

$conn->select_db($dbname);

$sqlCreateTable = "
CREATE TABLE IF NOT EXISTS flowers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) NOT NULL
)";
if ($conn->query($sqlCreateTable) === TRUE) {
    echo "Bảng 'flowers' đã được tạo hoặc đã tồn tại.<br>";
} else {
    die("Lỗi khi tạo bảng: " . $conn->error);
}

$sqlCheckData = "SELECT COUNT(*) AS count FROM flowers";
$result = $conn->query($sqlCheckData);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sqlInsertData = "
    INSERT INTO flowers (name, description, image) VALUES
    ('Đỗ Quyên', 'Hoa đỗ được trồng phổ biến và được nhiều người yêu mến.', 'images/doquyen.jpg'),
    ('Hải Đường', 'Hoa Hải Đường là tượng trưng cho sự giàu sang, phú quý.', 'images/haiduong.jpg'),
    ('Hoa Mai', 'Hoa Mai vàng là dấu hiệu của mùa xuân đẹp đẽ tại Việt Nam.', 'images/mai.jpg'),
    ('Hoa Tường Vy', 'Hoa Tường Vy màu sắc rất là đẹp và hương thơm thanh tao', 'images/tuongvy.jpg')
    ";

    if ($conn->query($sqlInsertData) === TRUE) {
        echo "Dữ liệu mẫu đã được thêm vào bảng 'flowers'.<br>";
    } else {
        echo "Lỗi khi thêm dữ liệu mẫu: " . $conn->error;
    }
} else {
    echo "Bảng 'flowers' đã có dữ liệu.<br>";
}

$conn->close();
?>
