<?php
session_start();
require_once('../model/database.php');

if (!isset($_SESSION['user_id'])) {
    echo "Session no here";
    var_dump($_SESSION);
    header('Location: ../signin.php?valid=Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.');
    exit;
}

$user_id = $_SESSION['user_id'];
$db = new Database();

if (isset($_GET['id'])) {
    $account_id = intval($_GET['id']); // Chuyển ID sang số nguyên

    // Lấy thông tin sản phẩm từ cơ sở dữ liệu
    $sql = "SELECT * FROM account WHERE id = $account_id";
    $db->set_query($sql);
    $result = $db->execute_query();

    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();

        // Kiểm tra giỏ hàng của người dùng
        $sql = "SELECT id FROM cart WHERE user_id = $user_id";
        $db->set_query($sql);
        $cart_result = $db->execute_query();

        if ($cart_result->num_rows > 0) {
            $cart = $cart_result->fetch_assoc();
            $cart_id = $cart['id'];
        } else {
            $sql = "INSERT INTO cart (user_id, totalprice) VALUES ($user_id, 0.00)";
            $db->set_query($sql);
            $db->execute_query();
            $cart_id = $db->conn->insert_id;
        }
        // Kiểm tra xem sản phẩm đã tồn tại trong chi tiết giỏ hàng chưa
        $sql = "SELECT * FROM cart_detail WHERE cart_id = $cart_id AND account_id = $account_id";
        $db->set_query($sql);
        $detail_result = $db->execute_query();
        // Kiểm tra xem sản phẩm đã tồn tại trong chi tiết giỏ hàng chưa
        if ($detail_result && $detail_result->num_rows > 0) {
            // Sản phẩm đã tồn tại trong giỏ hàng
            header('Location: c_cart.php?valid=Sản phẩm đã tồn tại trong giỏ hàng.');
        } else {
            // Thêm sản phẩm vào chi tiết giỏ hàng status=3 là sản phẩm đang trong giỏ hàng của một người khác
            $sql = "INSERT INTO cart_detail (cart_id, account_id, cart_name, cart_pass, type, status, price)
                    VALUES ($cart_id, $account_id, '{$product['name']}', '{$product['password']}', '{$product['type']}', 3, {$product['price']})";
            $db->set_query($sql);
            $db->execute_query();
            $update_sql = "UPDATE account SET status = 3  WHERE id =$account_id";
            $db->set_query($update_sql);
            $db->execute_query();
        }
    } else {
        header('Location: ../index.php?valid=Sản phẩm không tồn tại.');
        exit;
    }
}

header('Location: c_cart.php'); // Điều hướng đến trang giỏ hàng
exit;
?>
