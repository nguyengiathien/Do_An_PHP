<?php
require('../model/m_user.php');
session_start();

if (isset($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $new_user = new User();
    $this_user = $new_user->signin_user($email, $password, $role);
    
    if ($this_user !== null) { // Kiểm tra nếu người dùng tồn tại
        $_SESSION['user_id'] = $this_user['id']; // Lưu ID người dùng vào session
        $_SESSION['loginUSER'] = $this_user['username']; // Lưu username vào session
        $_SESSION['emailUSER'] = $this_user['email'];
        $_SESSION['roleUSER'] = $this_user['role']; // Lưu vai trò vào session
        header('Location: ../index.php'); // Chuyển hướng đến file admin/list_acc.php
        exit();
    } else {
        $error = 'Sai mật khẩu hoặc tài khoản';
        header("Location: ../signin.php?valid=$error");
        exit;
    }
}
?>
