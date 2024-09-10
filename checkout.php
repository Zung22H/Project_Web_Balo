<?php
session_start();
include 'db_connect.php';

// Kiểm tra nếu giỏ hàng không rỗng
if (empty($_SESSION['cart'])) {
    die("Giỏ hàng trống. Vui lòng thêm sản phẩm vào giỏ hàng.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán</title>
    <link rel="stylesheet" href="style/home.css">
    <style>
        /* CSS styles here */
        .error-message {
            color: red;
            display: none; /* Ẩn lỗi mặc định */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Trang Thanh Toán</h2>
        <form id="paymentForm" method="POST" action="" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="name">Tên:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại:</label>
                <input type="tel" id="phone" name="phone" required>
                <span id="phoneError" class="error-message">Số điện thoại phải từ 10 đến 11 số và không chứa chữ.</span>
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ:</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label>Hình thức thanh toán:</label>
                <div>
                    <input type="radio" id="cash" name="payment" value="cash" checked>
                    <label for="cash">Giao hàng và thanh toán tiền mặt</label>
                </div>
                <div>
                    <input type="radio" id="bank-transfer" name="payment" value="bank-transfer">
                    <label for="bank-transfer">Chuyển khoản qua ngân hàng</label>
                </div>
            </div>
            <input type="hidden" name="cart" value="<?php echo htmlspecialchars(json_encode($_SESSION['cart'])); ?>">
            <button type="submit">Xác Nhận Thanh Toán</button>
        </form>
    </div>

    <script>
        function validateForm() {
            const phoneInput = document.getElementById('phone').value;
            const phonePattern = /^[0-9]{10,11}$/; 
            const phoneError = document.getElementById('phoneError');

            if (!phonePattern.test(phoneInput)) {
                phoneError.style.display = 'block'; 
                return false; 
            } else {
                phoneError.style.display = 'none'; 
            }

            return true; 
        }
    </script>

<?php
// Xử lý khi form được gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
    $address = isset($_POST['address']) ? $_POST['address'] : null;
    $payment_method = isset($_POST['payment']) ? $_POST['payment'] : null;
    $cart = $_SESSION['cart']; // Lấy giỏ hàng từ session

    // Kiểm tra thông tin
    if ($name === null || $phone === null || $address === null || $payment_method === null || empty($cart)) {
        die("Thông tin không đầy đủ. Vui lòng kiểm tra lại.");
    }

    // Chèn thông tin vào cơ sở dữ liệu
    $stmt = $conn->prepare("INSERT INTO orders (cus_name, phone, address, payment_method) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $phone, $address, $payment_method);

    if ($stmt->execute()) {
        $order_id = $conn->insert_id; // Lấy ID của đơn hàng vừa tạo

        // Thêm sản phẩm vào bảng order_items
        foreach ($cart as $product_id => $quantity) {
            // Lấy giá sản phẩm từ cơ sở dữ liệu
            $stmt = $conn->prepare("SELECT price FROM product WHERE product_id = ?");
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $stmt->bind_result($price);
            $stmt->fetch();
            $stmt->close();

            // Thêm sản phẩm vào order_items
            $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);

            if (!$stmt->execute()) {
                echo "Có lỗi xảy ra khi lưu order items: " . $stmt->error;
                exit(); // Dừng lại nếu có lỗi
            }
            $stmt->close();
        }

        // Xóa giỏ hàng sau khi lưu
        unset($_SESSION['cart']);

        // Chuyển hướng về product_page.php
        header("Location: product_page.php");
        exit();
    } else {
        echo "<p>Có lỗi xảy ra khi tạo đơn hàng. Vui lòng thử lại.</p>";
    }

    $stmt->close();
    $conn->close();
}
?>
</body>
</html>
