<?php
require_once('../model/m_user.php'); // Kết nối model xử lý dữ liệu

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']); // Lấy ID từ GET và chuyển sang số nguyên

    $user_model = new User(); // Tạo đối tượng User
    $result = $user_model->delete_user_by_id($user_id); // Gọi phương thức xóa người dùng

    if ($result) {
        // Xóa thành công, chuyển hướng về trang danh sách
        header('Location: list_user.php?message=User deleted successfully');
    } else {
        // Xóa thất bại
        header('Location: list_user.php?message=Error deleting user');
        exit();
    }
} else {
    // Nếu không có ID, chuyển hướng về trang danh sách
    header('Location: list_user.php');
    exit();
}
?>
