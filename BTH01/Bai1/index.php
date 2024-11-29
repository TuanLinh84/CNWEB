<?php
include 'db.php';

$sql = "SELECT * FROM flowers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách các loài hoa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .flower-item {
            margin-bottom: 30px;
        }
        .flower-card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
            transition: transform 0.3s;
        }
        .flower-card:hover {
            transform: translateY(-5px);
        }
        .flower-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .flower-name {
            font-size: 1.3rem;
            font-weight: bold;
            text-align: center;
        }
        .flower-description {
            font-size: 1.1rem;
            color: #555;
            text-align: justify;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Các Loài Hoa Đẹp Việt Nam</h1>
        <div class="row">
            <?php while ($flower = $result->fetch_assoc()): ?>
                <div class="col-md-4 flower-item">
                    <div class="card flower-card">
                        <img src="<?php echo $flower['image']; ?>" class="flower-img" alt="<?php echo $flower['name']; ?>">
                        <div class="card-body">
                            <h5 class="flower-name"><?php echo $flower['name']; ?></h5>
                            <p class="flower-description"><?php echo $flower['description']; ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
