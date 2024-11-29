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
    <title>Quản lý danh sách hoa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .flower-table {
            margin-top: 30px;
        }
        .flower-table th, .flower-table td {
            text-align: center;
        }
        .flower-table img {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }
        .action-btn {
            display: flex;
            justify-content: space-around;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5 mb-4">Quản lý danh sách hoa</h1>
        <div class="mb-4 text-center">
            <a href="add.php" class="btn btn-success btn-lg">Thêm hoa mới</a>
        </div>
        <table class="table table-bordered flower-table">
            <thead class="table-dark">
                <tr>
                    <th>Tên hoa</th>
                    <th>Mô tả</th>
                    <th>Hình ảnh</th>
                    <th colspan="2">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($flower = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($flower['name']); ?></td>
                        <td><?php echo htmlspecialchars($flower['description']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($flower['image']); ?>" alt="Hình ảnh của <?php echo htmlspecialchars($flower['name']); ?>"></td>
                        <td class="action-btn">
                            <a href="edit.php?id=<?php echo $flower['id']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="delete.php?id=<?php echo $flower['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
