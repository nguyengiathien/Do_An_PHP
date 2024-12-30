<?php
session_start();

// Kiểm tra nếu người dùng có quyền admin
if (isset($_SESSION["roleUSER"]) && $_SESSION["roleUSER"] == 1 ) {
    $_SESSION['admin_logged_in'] = true;
    header("Location: admin/list_user.php"); // Chuyển hướng đến trang danh sách người dùng
    exit();
} else {
    // Nếu không có quyền admin, có thể chuyển hướng về trang khác hoặc thông báo lỗi
    header("Location: index.php"); // Ví dụ chuyển hướng về trang chủ
    exit();
}
?>
