<?php
require('../model/database.php');
$db = new Database();

// Kiểm tra xem đã nhận được cả cart_id và account_id hay chưa
if (isset($_GET['cart_id']) && isset($_GET['account_id'])) {
    $cart_id = $_GET['cart_id'];
    $account_id = $_GET['account_id'];

    // Kiểm tra kết nối với cơ sở dữ liệu
    if ($db->conn) {
        // Xóa chi tiết sản phẩm trong giỏ hàng
        $sql = "DELETE FROM cart_detail WHERE cart_id = ? AND account_id = ?";
        $stmt = $db->conn->prepare($sql);

        if ($stmt === false) {
            // Nếu không thể chuẩn bị câu lệnh SQL
            echo "Lỗi khi chuẩn bị câu lệnh: " . $db->conn->error;
            exit;
        }

        $stmt->bind_param("ii", $cart_id, $account_id);

        if ($stmt->execute()) {
            // Kiểm tra số dòng bị ảnh hưởng để chắc chắn rằng xóa thành công
            if ($stmt->affected_rows > 0) {
                header("Location: list_cart.php?message=Đã xóa tài khoản khỏi đơn hàng thành công");
                $sql="UPDATE account SET status = 0 WHERE id= $account_id ";
                $db->set_query($sql);
                $db->execute_query();
            } else {
                header("Location: list_cart.php?message=Không tìm thấy sản phẩm");
            }
        } else {
            header("Location: list_cart.php?message=Xảy ra lỗi khi xóa sản phẩm");
        }

        $stmt->close();
    } else {
        header("Location: list_cart.php?message=Không thể kết nối với database");
    }
} else {
    header("Location: list_cart.php?message=Thiếu thông tin giỏ hàng hoặc tài khoản");
}
?>
<body>
    <div class="container mt-5">
        <a href="list_cart.php" class="btn btn-primary">Quay về danh sách giỏ hàng</a>
    </div>
</body>

