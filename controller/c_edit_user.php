<?php
require_once('../model/m_user.php');
require_once('../model/database.php');

// Lấy dữ liệu từ form
$user_id = $_POST['id'];
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$role = $_POST['role'];
// Cập nhật dữ liệu trong cơ sở dữ liệu
$db = new Database();
$sql = "UPDATE user SET 
        username = '$username',
        password = '$password',
        role = '$role'";
$sql .= " WHERE id = $user_id";

$db->set_query($sql);
$db->execute_query();
header('Location: ../admin/list_user.php');
?>