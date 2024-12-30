<?php
session_start();
require_once("../model/database.php");

if (!isset($_SESSION['user_id'])) {
    header('Location: ../signin.php?valid=Bạn cần đăng nhập để thanh toán.');
    exit;
}

$user_id = $_SESSION['user_id'];
$db = new Database();

// Lấy thông tin giỏ hàng từ database
$sql = "SELECT c.id AS cart_id, cd.account_id, cd.cart_name, c.create_time, cd.price 
        FROM cart c
        INNER JOIN cart_detail cd ON c.id = cd.cart_id
        WHERE c.user_id = $user_id";
$db->set_query($sql);
$cart_items = $db->load_all_rows();

if (empty($cart_items)) {
    echo "<p>Giỏ hàng của bạn trống. <a href='../index.php'>Thêm sản phẩm</a></p>";
    exit;
}

$total = array_sum(array_column($cart_items, 'price')); // Tính tổng giá trị giỏ hàng

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($cart_items as $item) {
        $account_id = $item['account_id'];
        $price = $item['price'];
        // Lưu thông tin vào bảng history
        $sql = "INSERT INTO history (user_id, acc_id, purchase_date, price, currentstatus)
                VALUES ($user_id, $account_id, NOW(), $price, 2)";
        $db->set_query($sql);
        $db->execute_query();

        // Cập nhật trạng thái tài khoản
        $sql = "UPDATE account SET status = 2 WHERE id = $account_id";
        $db->set_query($sql);
        $db->execute_query();
    }

    // Xóa giỏ hàng sau khi thanh toán
    $sql = "DELETE FROM cart WHERE user_id = $user_id";
    $db->set_query($sql);
    $db->execute_query();

    echo "Xác nhận thanh toán sản phẩm thành công, Vui lòng chờ để được xử lý <br><a href='../index.php'><button>Quay lại trang chủ</button></a>";
    unset($_SESSION['cart']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán</title>
</head>
<body>
    <h1>Thông tin thanh toán</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Tên người dùng</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Ngày mua hàng</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cart_items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['account_id'])?></td>
                    <td><?php echo htmlspecialchars($item['cart_name']); ?></td>
                    <td><?php echo number_format($item['price'], 0, ',', '.'); ?> đ</td>
                    <td><?php echo htmlspecialchars($item['create_time']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Tổng cộng: <?php echo number_format($total, 0, ',', '.'); ?> đ</h3>

    <form method="POST" action="">
        <button type="submit">Xác nhận thanh toán</button>
    </form>

    <a href="c_cart.php">Quay lại</a>
</body>
</html>
