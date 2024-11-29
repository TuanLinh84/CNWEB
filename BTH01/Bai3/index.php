<?php
// Cấu hình kết nối cơ sở dữ liệu
$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "csv_demo";      

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý xóa toàn bộ dữ liệu khi người dùng chọn
if (isset($_POST['delete_data'])) {
    $sql = "DELETE FROM users";
    if ($conn->query($sql) === TRUE) {
        echo "<p class='success-msg'>Dữ liệu cũ đã được xóa thành công!</p>";
    } else {
        echo "<p class='error-msg'>Lỗi khi xóa dữ liệu: " . $conn->error . "</p>";
    }
}

// Xử lý tệp CSV khi người dùng tải lên
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['csv_file'])) {
    if ($_FILES['csv_file']['error'] == 0) {
        $filename = $_FILES['csv_file']['tmp_name'];
        $file = fopen($filename, 'r');

        // Bỏ qua dòng tiêu đề
        fgetcsv($file);

        // Chèn dữ liệu vào cơ sở dữ liệu
        while (($row = fgetcsv($file)) !== false) {
            $username = $conn->real_escape_string($row[0]);
            $password = $conn->real_escape_string($row[1]);
            $lastname = $conn->real_escape_string($row[2]);
            $firstname = $conn->real_escape_string($row[3]);
            $city = $conn->real_escape_string($row[4]);
            $email = $conn->real_escape_string($row[5]);
            $courseId = $conn->real_escape_string($row[6]);

            $sql = "INSERT INTO users (username, password, lastname, firstname, city, email, courseId) 
                    VALUES ('$username', '$password', '$lastname', '$firstname', '$city', '$email', '$courseId')";
            $conn->query($sql);
        }

        fclose($file);
        echo "<p class='success-msg'>Dữ liệu từ tệp CSV đã được nhập thành công!</p>";
    } else {
        echo "<p class='error-msg'>Vui lòng tải lên tệp CSV hợp lệ.</p>";
    }
}

// Lấy dữ liệu từ cơ sở dữ liệu để hiển thị
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhập và Quản lý Dữ liệu CSV</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .container {
            padding: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        input[type="file"] {
            padding: 8px;
            margin-right: 10px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .error-msg {
            color: red;
            font-weight: bold;
        }

        .success-msg {
            color: green;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f4f4f4;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <header>
        <h1>Nhập và Quản lý Dữ liệu từ Tệp CSV</h1>
    </header>

    <div class="container">
        <!-- Form tải lên tệp CSV -->
        <form action="" method="post" enctype="multipart/form-data">
            <label for="csv_file">Chọn tệp CSV:</label>
            <input type="file" name="csv_file" id="csv_file" accept=".csv" required>
            <button type="submit">Tải lên và Nhập Dữ Liệu</button>
        </form>

        <!-- Form xóa dữ liệu -->
        <form action="" method="post">
            <button type="submit" name="delete_data" style="background-color: red;">Xóa Toàn Bộ Dữ Liệu</button>
        </form>

        <!-- Hiển thị dữ liệu từ cơ sở dữ liệu -->
        <h2>Dữ Liệu Từ Cơ Sở Dữ Liệu</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Lastname</th>
                    <th>Firstname</th>
                    <th>City</th>
                    <th>Email</th>
                    <th>CourseId</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['password']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['lastname']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['firstname']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['city']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['courseId']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Không có dữ liệu.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php
// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
