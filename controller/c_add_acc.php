<?php
    require_once('../model/m_account.php');
    require_once('../model/database.php');
    session_start();
    var_dump($_POST);
    $name = $_POST['name'];
    $password = $_POST['password'];
    $rank = $_POST['rank'];
    $skins=$_POST['skins'];
    $champions=$_POST['champions'];
    $price = $_POST['price'];
    $category_name = $_POST['category_name'];
    $category_description = $_POST['category_description'];
    $avatar_path = NULL;
    $type= $_POST['type'];
    // Xử lý ảnh đại diện
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $avatar_tmp = $_FILES['avatar']['tmp_name'];
        $avatar_name = basename($_FILES['avatar']['name']);
        $avatar_path = "../uploads/" . $avatar_name;

        // Di chuyển tệp ảnh vào thư mục uploads
        if (!file_exists('../uploads')) {
            mkdir('../uploads', 0777, true);
        }
        if (!move_uploaded_file($avatar_tmp, $avatar_path)) {
            die("Error uploading avatar");// Nếu không tải lên được, set giá trị NULL
        }
    } else {
        $avatar_path = NULL;
    }
    $sql = "SELECT id FROM category WHERE name = '$category_name'";
    $db= new Database();
    $db->set_query($sql);
    $result = $db->execute_query();
    if ($result && $result->num_rows >0){
        $row = $result->fetch_assoc();
        $category_id= $row['id'];
    }
    else {
        $sql_isert_category ="INSERT INTO category (name, description) VALUES('$category_name', '$category_description')";
        $db->set_query($sql_isert_category);
        $db->execute_query();
        $category_id = $db->conn->insert_id;
    }
    $new_acc = new Account();
    $new_acc->create_1_acc($name, $password, $rank, $skins,$champions, $price, $category_id, $avatar_path, $type);
    header('Location: ../admin/list_acc.php');
?>

