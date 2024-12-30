<?php
session_start();
require_once("../model/database.php");

if (!isset($_SESSION['user_id'])) {
    header('Location: ../signin.php?valid=Bạn cần đăng nhập để xem giỏ hàng.');
    exit;
}

$user_id = $_SESSION['user_id'];
$db = new Database();

// Lấy giỏ hàng từ cơ sở dữ liệu
$sql = "SELECT cd.cart_id, cd.cart_name, cd.cart_pass, cd.type, cd.status, cd.price, 
               a.rank, a.skins, a.champions, a.password
        FROM cart c
        INNER JOIN cart_detail cd ON c.id = cd.cart_id
        INNER JOIN account a ON cd.account_id = a.id
        WHERE c.user_id = $user_id";

$db->set_query($sql);
$cart_items = $db->load_all_rows();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
</head>
<body>
    <h1>Giỏ hàng của bạn</h1>

    <?php if (empty($cart_items)): ?>
        <p>Giỏ hàng của bạn trống. <a href="../index.php">Thêm sản phẩm</a></p>
    <?php else: ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Mật khẩu</th>
                    <th>Rank</th>
                    <th>Số Skin</th>
                    <th>Số Champion</th>
                    <th>Loại</th>
                    <th>Giá</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $total = 0; // Tổng tiền
            //var_dump($cart_items);
            foreach ($cart_items as $item):
                $total += $item['price'];
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['cart_name']); ?></td>
                    <td><?php echo htmlspecialchars($item['password']); ?></td>
                    <td><?php echo htmlspecialchars($item['rank'])?></td>
                    <td><?php echo htmlspecialchars($item['skins'])?></td>
                    <td><?php echo htmlspecialchars($item['champions'])?></td>
                    <td><?php echo htmlspecialchars($item['type']); ?></td>
                    <td><?php echo number_format($item['price'], 0, ',', '.'); ?> đ</td>
                    <td>
                        <a href="c_delete_acc_on_cart.php?id=<?php echo $item['cart_id']; ?>">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <br>
        <a href="../index.php"><button>Thêm sản phẩm</button></a>
        <br>
        <h3>Tổng cộng: <?php echo number_format($total, 0, ',', '.'); ?> đ</h3>
        <a href="c_checkout.php"><button>Thực hiện thanh toán</button></a>
    <?php endif; ?>
</body>
</html>
