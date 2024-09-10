<?php
include "./db_connect.php";

// Lấy ID sản phẩm từ URL
$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;

// Truy vấn thông tin sản phẩm
$query = "SELECT * FROM product WHERE product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

// Kiểm tra kết quả
if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    die("Không tìm thấy sản phẩm.");
}

// Đóng kết nối
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['product_name']); ?></title>
    <link rel="stylesheet" href="style/home.css">
    <link rel="stylesheet" href="style/pro-detail.css"> 
    <style>
        /* CSS cho slider sản phẩm mới nhất */
.product-slider {
    position: relative;
    overflow: hidden;
    width: 100%;
    height: 500px; /* Chiều cao của slider */
}
.product-slider .slides {
    display: flex;
    transition: transform 0.5s ease;
    width: 100%; /* 4 sản phẩm hiển thị đồng thời */
}
.product-slider .slide {
    min-width: 25%; /* Mỗi slide chiếm 25% chiều rộng */
    box-sizing: border-box;
    padding: 10px;
}
.product-slider .slide img {
    max-width: 100%; 
    height: 80%; 
    border-radius: 5px; 
}
.product-slider .prev, .product-slider .next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(79, 35, 4, 0.741); 
    border: none;
    cursor: pointer;
    padding: 10px;
    z-index: 10;
    border-radius: 5px; 
    box-shadow: 0 2px 5px rgb(105, 26, 26); 
    color: white; 
    font-size: 18px; 
}
.product-slider .prev {
    left: 10px;
}
.product-slider .next {
    right: 10px;
}
.product-slider .prev:hover, .product-slider .next:hover {
    background-color: rgb(105, 26, 26);     
}

h3{
    margin-top:30px;
    text-align:center;
    
}
.slide p {
    font-size: 1.5em;
    color: red;
    margin: 0;
    text-align: center;
}

h2{
    text-align:center;
}
.add-to-cart{
    display: inline-block; 
  padding: 20px 20px; 
  font-size: 16px; 
  color: #fff; 
  background-color: rgba(47, 30, 18, 0.741); 
  border: none; 
  border-radius: 5px; 
  text-align: center; 
  text-decoration: none; 
  cursor: pointer; 
  transition: background-color 0.3s; 
  margin-right: 20px;
  margin-top:20px;
}

    </style>
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

<!-------------------------Product Detail---------------------------->
<section class="product-detail">
    <div class="container-pro-detail">
        <div class="product-content">
            <div class="product-content-left">
                <img src="<?php echo htmlspecialchars($product['product_img']); ?>">
            </div>

            <div class="product-content-right">
                <div class="product-content-right-product-name">
                    <h1><?php echo htmlspecialchars($product['product_name']); ?></h1>
                </div>

                <div class="product-content-right-product-price">
                    <p><?php echo number_format($product['price'], 0, ',', '.') . ' VNĐ'; ?></p>
                </div>

                <div class="product-content-right-infomation">
                    <div class="description">
                    <p><?php echo (htmlspecialchars($product['product_detail'])); ?></p>
                </div>
                

                <form action="add_to_cart.php" method="POST" onsubmit="return redirectToCart();">
                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>"> 
                    <button type="submit" class="add-to-cart">THÊM VÀO GIỎ HÀNG</button>
                </form>
                <script>
                    function redirectToCart() {
                    // Thực hiện thêm sản phẩm vào giỏ hàng
                    setTimeout(function() {
                        window.location.href = 'cart.php'; // Chuyển đến giỏ hàng sau 1 giây
                    }, 1000); // Thời gian chờ 1 giây
                return true; // Cho phép form được gửi
                    }
                </script>
                <div class="shipping-info">
                    <p>FREE SHIPPING FOR ADICLUB MEMBERS!</p>
                    <p>HOÀN TRẢ DỄ DÀNG</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-------------------------Footer------------------------------>

<footer>
<?php
include "./db_connect.php";

// Truy vấn sản phẩm mới nhất
$sql = "SELECT * FROM product ORDER BY product_id DESC LIMIT 6";
$result = $conn->query($sql);
?>

<h3>Sản phẩm mới nhất</h3>
<div class="product-slider">
    <div class="slides">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Lấy trạng thái sản phẩm
                $status = $row['product_act'];
                // Thiết lập thông báo trạng thái
                $status_message = ($status == 0) ? "Còn hàng" : "Hết hàng";
        
                echo "<div class='slide'>
                        <a href='product_detail.php?product_id=" . $row['product_id'] . "'>
                            <img src='" . $row['product_img'] . "' alt='" . $row['product_name'] . "'>
                            <h3>" . $row['product_name'] . "</h3>
                            <p>" . number_format($row['price'], 0, ',', '.') . " VNĐ</p>
                            <h2>$status_message</h2> 
                        </a>
                      </div>";
            }
        } else {
            echo "<div class='slide'>Không có sản phẩm nào.</div>";
        }
        
        ?>
    </div>
    <button class="prev" onclick="changeProductSlide(-1)">&#10094;</button>
    <button class="next" onclick="changeProductSlide(1)">&#10095;</button>
</div>

<?php
$conn->close();
?>

        
    </div>
    <div class="footer-top">
        <li><a href="">Liên hệ</a></li>
        <li><a href="">Giới thiệu</a></li>
    </div>
    <div class="footer-middle">
        <p>Đây là website chuyên cung cấp các mẫu mã Balo <br> 
    Do hai sinh viên Hồ Chí Dũng và Phạm Tân Tiến 
        thuộc trường Đại học Giao thông Vận tải TP.HCM thực hiện <br>
    Mọi thắc mác xin liên hệ qua email:<b>2251120408@ut.edu.vn </b>  </p>

    </div>

    <div class="footer-bottom">
        BestBag All rights reserved
    </div>
</footer>

<script>
    const productSlides = document.querySelectorAll(".product-slider .slide");
    const productSliderContainer = document.querySelector(".product-slider .slides");
    const productCount = productSlides.length;
    let productIndex = 0;

    // Hiển thị slide đầu tiên
    function showProductSlide(index) {
        productSliderContainer.style.transform = "translateX(-" + index * 25 + "%)";
    }

    function changeProductSlide(direction) {
        productIndex += direction;

        // Nếu sản phẩm chỉ số >= 2 (tức là đã nhảy 2 slide), quay về sản phẩm đầu tiên
        if (productIndex >= 3) {
            productIndex = 0; // Quay về đầu
        } else if (productIndex < 0) {
            productIndex = Math.max(productCount - 4, 0); // Quay về 4 sản phẩm trước
        }

        showProductSlide(productIndex);
    }

    // Chuyển slide tự động mỗi 3 giây
    setInterval(() => {
        changeProductSlide(1);
    }, 5000);
</script>

<script src="cart.js"></script>
</body>
</html>
