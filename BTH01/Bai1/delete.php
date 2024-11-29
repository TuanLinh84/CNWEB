<?php
include 'db.php';

$id = $_GET['id'];
$sql = "DELETE FROM flowers WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    header('Location: admin.php');
} else {
    echo "Lỗi: " . $conn->error;
}
?>
