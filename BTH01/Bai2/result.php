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

// Truy vấn lấy danh sách câu hỏi từ cơ sở dữ liệu
$query = "SELECT * FROM questions";
$results = $conn->query($query);

$quizData = [];
if ($results->num_rows > 0) {
    while ($row = $results->fetch_assoc()) {
        $quizData[] = [
            "question" => $row["question"],
            "options" => explode("|", $row["options"]),
            "answer" => trim($row["answer"]) // Đảm bảo đáp án được loại bỏ khoảng trắng thừa
        ];
    }
}

// Lấy các câu trả lời của người dùng từ form
$userAnswers = [];
foreach ($quizData as $index => $question) {
    $userAnswers[$index] = isset($_POST["answer_$index"]) ? trim($_POST["answer_$index"]) : ''; // Loại bỏ khoảng trắng thừa trong câu trả lời của người dùng
}

// Tính điểm
$score = 0;
foreach ($quizData as $index => $question) {
    // So sánh câu trả lời người dùng với đáp án đúng
    if ($userAnswers[$index] == $question["answer"]) {
        $score++; // Tăng điểm nếu câu trả lời đúng
    }
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết Quả Bài Thi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
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

        .question {
            margin-bottom: 20px;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .question p {
            margin: 5px 0;
        }

        .result-btn {
            display: block;
            width: 200px;
            margin: 30px auto;
            padding: 10px;
            background-color: #007bff;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }

        .result-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Kết Quả Bài Thi</h1>
        <h2>Chi Tiết Câu Trả Lời</h2>

        <?php foreach ($quizData as $index => $question): ?>
            <div class="question">
                <p><strong>Câu hỏi <?php echo ($index + 1); ?>:</strong> <?php echo $question["question"]; ?></p>
                
                <!-- Hiển thị đáp án người dùng chọn -->
                <p><strong>Đáp án bạn chọn:</strong> 
                    <?php echo isset($userAnswers[$index]) ? $userAnswers[$index] : 'Chưa chọn'; ?>
                </p>

                <!-- Hiển thị đáp án đúng -->
                <p><strong>Đáp án đúng:</strong> <?php echo $question["answer"]; ?></p>
            </div>
        <?php endforeach; ?>

        <!-- Nút làm lại bài thi -->
        <a href="index.php" class="result-btn">Làm lại bài thi</a>
    </div>
</body>

</html>
