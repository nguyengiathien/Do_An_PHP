<?php
require_once('../model/m_account.php'); // Kết nối với model xử lý dữ liệu
require_once('../model/database.php'); // Kết nối với cơ sở dữ liệu

if (isset($_GET['id'])) {
    $acc_id = intval($_GET['id']); // Lấy ID từ GET và chuyển sang số nguyên

    // Tạo đối tượng Account và lấy thông tin tài khoản
    $acc_model = new Account();
    $account = $acc_model->get_account_by_id($acc_id); // Giả sử có phương thức này trong Account model

    if ($account) {
        $category_id = $account['category_id']; // Lấy category_id của tài khoản

        // Xóa tài khoản
        $result_account = $acc_model->delete_account_by_id($acc_id);

        // Nếu xóa tài khoản thành công, xóa category
        if ($result_account) {
            $db = new Database();
            $sql_check_category = "SELECT * FROM account WHERE category_id = '$category_id'"; 
            $db->set_query($sql_check_category);
            $result_check = $db->execute_query();

            // Nếu không còn account nào sử dụng category này, xóa category
            if ($result_check->num_rows == 0) {
                $sql_delete_category = "DELETE FROM category WHERE id = '$category_id'";
                $db->set_query($sql_delete_category);
                $db->execute_query();
            }
            
            header('Location: list_acc.php?message=Tài khoản đã xóa thành côngcông');
            exit();
        } else {
            header('Location: list_acc.php?message=Xóa sản phẩm không thành công');
            exit();
        }
    } else {
        header('Location: list_acc.php?message=Không tìm thấy sản phẩm');
        exit();
    }
} else {
    echo "Invalid request.";
}
?>
