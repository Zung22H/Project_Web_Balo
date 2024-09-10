<?php
$servername = "localhost"; // Thay đổi nếu cần
$username = "root"; // Tên người dùng của bạn
$password = ""; // Mật khẩu của bạn
$dbname = "website_bestbag"; // Tên cơ sở dữ liệu của bạn

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
