<?php
include 'db.php';

$id = $_GET['id']; // Lấy ID từ URL
$sql = "SELECT * FROM flowers WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Không tìm thấy hoa với ID này.");
}

$flower = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];

    // Nếu người dùng không upload ảnh mới, giữ nguyên ảnh cũ
    if (!empty($_FILES['image']['name'])) {
        $image = 'images/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    } else {
        $image = $flower['image'];
    }

    $sqlUpdate = "UPDATE flowers SET 
                    name = '$name', 
                    description = '$description', 
                    image = '$image' 
                  WHERE id = $id";

    if ($conn->query($sqlUpdate) === TRUE) {
        header('Location: admin.php');
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa hoa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Sửa thông tin hoa</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Tên hoa</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo $flower['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea id="description" name="description" class="form-control" required><?php echo $flower['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh</label>
                <input type="file" id="image" name="image" class="form-control">
                <p class="mt-2">Hình ảnh hiện tại:</p>
                <img src="<?php echo $flower['image']; ?>" width="150" alt="<?php echo $flower['name']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        </form>
    </div>
</body>
</html>
