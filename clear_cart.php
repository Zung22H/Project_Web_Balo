<?php
session_start();
include "./db_connect.php";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $query = "DELETE FROM cart"; // Xóa tất cả sản phẩm trong giỏ hàng
    $stmt = $conn->prepare($query);

    if ($stmt->execute()) {
        header("Location: cart.php"); // Chuyển hướng đến trang giỏ hàng
        exit();
    } else {
        echo "Có lỗi xảy ra.";
    }

    $stmt->close();
    $conn->close();
}
?>
