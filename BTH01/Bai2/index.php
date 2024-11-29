<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiz_app";

// Kết nối với cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

// Truy vấn lấy câu hỏi từ cơ sở dữ liệu
$query = "SELECT * FROM questions";
$results = $conn->query($query);

$quizData = [];
if ($results->num_rows > 0) {
    while ($row = $results->fetch_assoc()) {
        $quizData[] = [
            "question" => $row["question"],
            "options" => explode("|", $row["options"]),
            "answer" => $row["answer"]
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Examination</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 60%;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .question {
            margin-bottom: 20px;
        }

        .options {
            margin-left: 20px;
        }

        label {
            display: block;
            margin: 8px 0;
            font-size: 16px;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #5cb85c;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 20px;
        }

        button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Trắc nghiệm</h1>
        <form method="post" action="result.php">
            <?php foreach ($quizData as $index => $question): ?>
                <div class="question">
                    <p><strong>Câu <?php echo ($index + 1); ?>: <?php echo $question["question"]; ?></strong></p>
                    <div class="options">
                        <?php foreach ($question["options"] as $option): ?>
                            <label>
                                <input type="radio" name="answer_<?php echo $index; ?>" value="<?php echo $option; ?>">
                                <?php echo $option; ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <button type="submit">Gửi bài</button>
        </form>
    </div>
</body>

</html>
