<?php
    
    include "./db_connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best Bag</title>
    <link rel="stylesheet" href="style/home.css">
</head>
<body>
<!-----------------------Header----------------------->
<header>
    <div class="logo">
        <a href="home.php"><img src="img/logo.jpg" width="80px" height="80px"></a>
    </div>
    <div class="menu">
        <li><a href="product_page.php">Sản Phẩm</a></li>
        <li><a href="pro-sport.php">Thể thao</a></li>
        <li><a href="pro-laptop.php">Balo Laptop</a></li>
        <li><a href="pro-travel.php">Túi du lịch</a></li>
               
    </div>
    <div class="others">
        <li class="searching">
            <input type="text" id="searchinput" placeholder="Search......">
            <button class="search-btn" onclick="searchfunction()">Tìm Kiếm</button>
            <div id="searchresults"></div>
        </li>
        <li>
            <a href="cart.php"><button class="cart-btn" onclick="goToCart()">Giỏ hàng</button></a>
        </li>
        <li><a href="form_register.html"><button class="acct-btn">Tài khoản</button></a></li>
    </div>
</header> 

<!-------------------------Product---------------------------->


<?php

// Truy vấn sản phẩm từ cơ sở dữ liệu
$query = "SELECT * FROM product WHERE cartegory_id = 3"; // Thay đổi tên bảng nếu cần
$result = mysqli_query($conn, $query);

// Kiểm tra kết quả
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Hiển thị sản phẩm
echo '<div id="product-container">'; // Khởi tạo container

while ($product = mysqli_fetch_assoc($result)) {
    $product_id = htmlspecialchars($product['product_id'], ENT_QUOTES);
    $product_name = htmlspecialchars($product['product_name'], ENT_QUOTES);
    $product_img = htmlspecialchars($product['product_img'], ENT_QUOTES);
    $price = number_format($product['price'], 0, ',', '.') . 'VNĐ'; // Định dạng giá
    $status = $product['product_act'];
    
    $status_message = ($status == 0) ? "Còn hàng" : "Hết hàng";
    echo "
        <div class='product'>
            <a href='product_detail.php?product_id=$product_id'>
                <img src='$product_img' alt='$product_name'>
            </a>
            <h3>$product_name</h3>
            <div class='price'>$price</div>
            <div class='status'>$status_message</div>
            
        </div>
    ";
}

echo '</div>'; // Đóng container

// Đóng kết nối
mysqli_close($conn);
?>
<!-------------------------Footer------------------------------>

<footer>
    <div class="footer-top">
        <li><a href="">Liên hệ</a></li>
        <li><a href="">Giới thiệu</a></li>
    </div>
    <div class="footer-middle">
        <p>Đây là website chuyên cung cấp các mẫu mã Balo <br> 
        Do hai sinh viên Hồ Chí Dũng và Phạm Tân Tiến 
        thuộc trường Đại học Giao thông Vận tải TP.HCM thực hiện <br>
        Mọi thắc mác xin liên hệ qua email:<b>2251120408@ut.edu.vn </b></p>
    </div>
    <div class="footer-bottom">
        BestBag All rights reserved
    </div>
</footer>

<script src="cart.js"></script>
</body>

</html>
