<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiz_app";

// Kết nối cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Không thể kết nối: " . $conn->connect_error);
}

// Truy vấn để lấy thông tin file hiện tại
$query = "SELECT * FROM uploaded_files LIMIT 1";
$results = $conn->query($query);

// Kiểm tra kết quả truy vấn
if (!$results) {
    die("Lỗi truy vấn: " . $conn->error);
}

$fileInfo = $results->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chính</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        .navigation {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .navigation a {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .navigation a:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        .no-file-message {
            text-align: center;
            font-size: 18px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Trang Chính</h1>

        <div class="navigation">
            <a href="upload.php">Tải Lên File Mới</a>
            <a href="index.php">Làm Bài Trắc Nghiệm</a>
        </div>

        <h2>Thông Tin File Đang Tải Lên</h2>

        <?php if ($fileInfo): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên File</th>
                        <th>Ngày Tải Lên</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $fileInfo['id']; ?></td>
                        <td><?php echo $fileInfo['file_name']; ?></td>
                        <td><?php echo $fileInfo['uploaded_at']; ?></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-file-message">Hiện tại chưa có file nào được tải lên.</p>
        <?php endif; ?>
    </div>
</body>

</html>
