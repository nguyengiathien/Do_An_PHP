<?php
session_start();
require_once("../model/database.php");

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header('Location: ../signin.php?valid=Bạn cần đăng nhập để xóa sản phẩm.');
    exit;
}

$user_id = $_SESSION['user_id'];
$cart_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$cart_id) {
    header('Location: ../cart.php?valid=Không có sản phẩm để xóa.');
    exit;
}

// Kết nối đến cơ sở dữ liệu
$db = new Database();

// Kiểm tra xem sản phẩm trong giỏ hàng có thuộc về người dùng hiện tại không
$sql = "SELECT * FROM cart_detail WHERE cart_id = $cart_id AND cart_id IN (SELECT id FROM cart WHERE user_id = $user_id)";
$db->set_query($sql);
$cart_item = $db->load_all_rows();

if (empty($cart_item)) {
    header('Location: ../cart.php?valid=Không tìm thấy sản phẩm trong giỏ hàng của bạn.');
    exit;
}
$account_id = $cart_item[0]['account_id'];
$sql_update_status = "UPDATE account SET status = 0 WHERE id = $account_id";
$db->set_query($sql_update_status);
$db->execute_query();

// Xóa sản phẩm khỏi giỏ hàng (chỉ xóa chi tiết giỏ hàng của sản phẩm này)
$sql_delete = "DELETE FROM cart_detail WHERE cart_id = $cart_id AND account_id = $account_id";
$db->set_query($sql_delete);
$result = $db->execute_query();


if ($result) {
    // Nếu xóa thành công, quay lại trang giỏ hàng
    header('Location: c_cart.php?valid=Xóa sản phẩm thành công.');
} else {
    // Nếu có lỗi xảy ra
    header('Location: c_cart.php?valid=Không thể xóa sản phẩm, vui lòng thử lại.');
}
exit;
?>
