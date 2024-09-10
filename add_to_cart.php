<?php
session_start();
include "./db_connect.php"; // Kết nối đến cơ sở dữ liệu

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = 1; // Số lượng mặc định là 1

    // Kiểm tra xem giỏ hàng đã được khởi tạo trong session chưa
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = []; // Khởi tạo giỏ hàng nếu chưa có
    }

    // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng lên
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        // Nếu chưa có, thêm sản phẩm vào giỏ hàng
        $_SESSION['cart'][$product_id] = $quantity;
    }

    // Lưu giỏ hàng vào cơ sở dữ liệu
    $stmt = $conn->prepare("INSERT INTO cart (product_id, quantity) VALUES (?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + ?");
    $stmt->bind_param("iii", $product_id, $quantity, $quantity);

    if ($stmt->execute()) {
        // Chuyển hướng về trang giỏ hàng
        header("Location: cart.php"); // Chuyển đến trang giỏ hàng
        exit();
    } else {
        echo "Có lỗi xảy ra khi lưu giỏ hàng.";
    }
}
?>

