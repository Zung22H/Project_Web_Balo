<?php
session_start();
include "./db_connect.php";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];

    
    $query = "DELETE FROM cart WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);

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
