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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $file = $_FILES["file"]["tmp_name"];
    $file_name = basename($_FILES["file"]["name"]);
    $content = file_get_contents($file);
    $questions = preg_split("/\n\s*\n/", trim($content));

    // Xóa câu hỏi và file cũ
    $conn->query("DELETE FROM questions");
    $conn->query("DELETE FROM uploaded_files");

    // Lưu câu hỏi mới vào bảng `questions`
    foreach ($questions as $question) {
        $lines = explode("\n", $question);
        $question_text = trim($lines[0]);
        $options = [];
        $answer = "";

        foreach ($lines as $line) {
            if (preg_match("/^[A-D]\./", $line)) {
                $options[] = trim($line);
            } elseif (preg_match("/^ANSWER:\s*([\w,\s]+)/", $line, $match)) {
                $answer = implode(",", array_map('trim', explode(",", $match[1])));
            }
        }

        $options_str = implode("|", $options);
        $stmt = $conn->prepare("INSERT INTO questions (question, options, answer) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $question_text, $options_str, $answer);
        $stmt->execute();
    }

    // Lưu thông tin file mới vào bảng `uploaded_files`
    $stmt = $conn->prepare("INSERT INTO uploaded_files (file_name) VALUES (?)");
    $stmt->bind_param("s", $file_name);
    $stmt->execute();

    // Chuyển hướng về trang chủ
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File Trắc Nghiệm</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 60%;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 16px;
            font-weight: bold;
        }

        input[type="file"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            text-decoration: none;
            color: #007bff;
            font-size: 16px;
        }

        .back-link a:hover {
            color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Upload File Trắc Nghiệm</h1>
        <form method="post" enctype="multipart/form-data">
            <label for="file">Chọn file TXT chứa câu hỏi trắc nghiệm:</label>
            <input type="file" name="file" id="file" accept=".txt" required>
            <button type="submit">Tải lên</button>
        </form>
        <div class="back-link">
            <a href="home.php">Quay lại trang chủ</a>
        </div>
    </div>
</body>

</html>
