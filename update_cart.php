<?php
session_start();
include "./db_connect.php";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

  
    $query = "UPDATE cart SET quantity = ? WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $quantity, $product_id);

    if ($stmt->execute()) {
        header("Location: cart.php");
        exit();
    } else {
        echo "Có lỗi xảy ra.";
    }

    $stmt->close();
    $conn->close();
}
?>

