<?php
require_once('../model/m_history.php'); // Kết nối model xử lý dữ liệu

if (isset($_GET['id'])) {
    $history_id = intval($_GET['id']); // Lấy ID từ GET và chuyển sang số nguyên

    $history_model = new History(); // Tạo đối tượng History

    // Lấy thông tin lịch sử để lấy acc_id
    $history_info = $history_model->get_history_by_id($history_id);
    
    if ($history_info) {
        $acc_id = $history_info['acc_id']; // Lấy acc_id từ thông tin lịch sử

        // Cập nhật trạng thái của tài khoản thành 1
        $update_status = $history_model->update_account_status($acc_id, 0); 

        if ($update_status) {
            // Xóa lịch sử
            $result = $history_model->delete_history_by_id($history_id);

            if ($result) {
                // Xóa thành công, chuyển hướng về trang danh sách lịch sử
                header('Location: list_history.php?message=History deleted successfully');
            } else {
                // Xóa thất bại
                header('Location: list_history.php?message=Error deleting history');
                exit();
            }
        } else {
            // Nếu không thể cập nhật trạng thái tài khoản
            header('Location: list_history.php?message=Error updating account status');
            exit();
        }
    } else {
        // Nếu không tìm thấy lịch sử
        header('Location: list_history.php?message=History not found');
        exit();
    }
} else {
    // Nếu không có ID, chuyển hướng về trang danh sách lịch sử
    header('Location: list_history.php');
    exit();
}
?>
