<?php
require_once('../model/m_history.php');

if (isset($_GET['id'])) {
    $history_id = intval($_GET['id']);  // Dùng $_GET['id'] thay vì $_POST['id']
    $history_model = new History();
    $history_info = $history_model->get_history_by_id($history_id);
    $acc_id= $history_info['acc_id'];
    // Cập nhật trạng thái tài khoản thành "Đã thanh toán" (1)
    $update_status = $history_model->update_transaction_status($history_id, 1);
    $update_status = $history_model->update_account_status($acc_id, 1);
    if ($update_status) {
        echo "Xác nhận thanh toán thành công.";
    } else {
        echo "Có lỗi xảy ra khi xác nhận thanh toán.";
    }
} else {
    echo "ID giao dịch không hợp lệ.";
}
?>
