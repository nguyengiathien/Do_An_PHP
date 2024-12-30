<?php
require_once('model/m_history.php');
session_start();

if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    
    // Khởi tạo đối tượng History để lấy dữ liệu lịch sử
    $history_model = new History();
    $history = $history_model->get_history_by_user_id($user_id);
} else {
    // Nếu người dùng chưa đăng nhập, chuyển hướng về trang đăng nhập
    header("Location: signin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lịch Sử Mua Hàng</title>
    <link rel="stylesheet" href="path/to/bootstrap.css"> <!-- Thêm liên kết tới Bootstrap (nếu cần) -->
</head>
<body>
    <div class="container">
        <h2>Lịch Sử Mua Hàng</h2>
        <?php if ($history): ?>
            <table class="table table-bordered" border ='1'>
                <thead>
                    <tr>
                        <th>Ngày Mua</th>
                        <th>Tên Tài Khoản</th>
                        <th>Password</th>
                        <th>Loại Tài Khoản</th>
                        <th>Trạng thái</th>
                        <th>Giá</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($history as $item): ?>
                        <tr>
                            <td><?php echo $item['purchase_date']; ?></td>
                            <td><?php echo $item['cart_name']; ?></td>
                            <td><?php echo $item['pass']?></td>
                            <td><?php echo $item['category_name']; ?></td>
                            <td><?php switch ($item['status']){
                                case 0:
                                    echo "Chưa thanh toán";
                                    break;
                                case 1:
                                    echo"Đã thanh toántoán";
                                    break;
                                case 2:
                                    echo"Đang chờ xác nhận đơn hàng";
                                    break;
                            }
                            ?></td>
                            <td><?php echo number_format($item['price'], 2, ',', '.'); ?> VND</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Không có lịch sử mua hàng nào.</p>
        <?php endif; ?>
    </div>
</body>
</html>
