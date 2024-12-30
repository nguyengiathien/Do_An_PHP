<?php
require_once('../model/m_account.php');
require_once('../model/database.php');

// Lấy dữ liệu từ form
$acc_id = $_POST['id'];
$name = $_POST['name'];
$password = $_POST['password'];
$rank = $_POST['rank'];
$skins = $_POST['skins'];
$champions = $_POST['champions'];
$price = $_POST['price'];
$type = $_POST['type'];
$avatar_path = NULL;

// Xử lý upload ảnh
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
    $avatar_tmp = $_FILES['avatar']['tmp_name'];
    $avatar_name = basename($_FILES['avatar']['name']);
    $avatar_path = "../uploads/" . $avatar_name;

    if (!move_uploaded_file($avatar_tmp, $avatar_path)) {
        die("Error uploading avatar.");
    }
}

// Cập nhật dữ liệu trong cơ sở dữ liệu
$db = new Database();
$sql = "UPDATE account SET 
        name = '$name',
        password = '$password',
        rank = '$rank',
        skins = $skins,
        champions = $champions,
        price = $price,
        type = '$type'";

if ($avatar_path) {
    $sql .= ", avatar = '$avatar_path'";
}

$sql .= " WHERE id = $acc_id";

$db->set_query($sql);
$db->execute_query();

header('Location: ../admin/list_acc.php');
?>