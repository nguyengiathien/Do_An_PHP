<?php
require_once("database.php");

class History extends Database {
    
    public function __construct() {
        parent::__construct(); // Gọi constructor của lớp cha (Database)
    }

    // Lấy lịch sử mua hàng theo user_id
    public function get_history_by_user_id($user_id) {
        // SQL query
        $sql = "
            SELECT h.purchase_date, h.price, a.name AS cart_name, a.password AS pass, a.status AS status, c.name AS category_name
            FROM history h
            JOIN account a ON h.acc_id = a.id
            JOIN category c ON a.category_id = c.id
            WHERE h.user_id = ? 
            ORDER BY h.purchase_date DESC
        ";

        // Thiết lập truy vấn SQL
        $stmt = $this->conn->prepare($sql); // Sử dụng phương thức từ lớp cha (Database)

        // Liên kết tham số với câu truy vấn
        $stmt->bind_param('i', $user_id); // 'i' là kiểu dữ liệu INT cho $user_id

        // Thực thi câu truy vấn
        $stmt->execute();
        
        // Lấy kết quả trả về
        $result = $stmt->get_result();
        
        // Trả về kết quả dưới dạng mảng kết hợp
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    // Thêm phương thức update_account_status trong class History
    public function update_account_status($account_id, $status) {
        $this->conn->begin_transaction();
        try {
            $sql = "UPDATE account SET status = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('ii', $status, $account_id);
            if (!$stmt->execute()) {
                throw new Exception("Error updating account status");
            }
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }
    public function update_transaction_status($history_id, $status) {
        $sql = "UPDATE history SET currentstatus = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ii', $status, $history_id); 
        return $stmt->execute();
    }    
    public function list_all_history() {
        $sql = "SELECT h.id, u.username AS username, h.purchase_date, h.acc_id, a.type AS type, a.name AS account_name, a.price AS price, 
        a.status AS status, a.password
                FROM history h
                JOIN user u ON h.user_id = u.id
                JOIN account a ON h.acc_id = a.id
                ORDER BY h.purchase_date DESC";
        $this->set_query($sql);
        $result = $this->execute_query();
        $list_history = array();
        if($result->num_rows >0){
            while ($row = $result->fetch_assoc()){
                $list_history [] =$row;
            }
        }
        return $list_history;
    }
    public function delete_history_by_id($history_id) {
        // SQL query để xóa thông tin lịch sử
        $sql = "DELETE FROM history WHERE id = ?";
        
        // Thiết lập truy vấn SQL
        $stmt = $this->conn->prepare($sql);
        
        // Liên kết tham số với câu truy vấn
        $stmt->bind_param('i', $history_id); // 'i' là kiểu dữ liệu INT cho $history_id
    
        // Thực thi câu truy vấn
        return $stmt->execute();
    }
    
    // Phương thức lấy thông tin lịch sử theo ID để lấy acc_id
    public function get_history_by_id($history_id) {
        // SQL query
        $sql = "SELECT acc_id FROM history WHERE id = ?";
        
        // Thiết lập truy vấn SQL
        $stmt = $this->conn->prepare($sql);
        
        // Liên kết tham số với câu truy vấn
        $stmt->bind_param('i', $history_id); // 'i' là kiểu dữ liệu INT cho $history_id
    
        // Thực thi câu truy vấn
        $stmt->execute();
        
        // Lấy kết quả trả về
        $result = $stmt->get_result();
        
        // Trả về kết quả dưới dạng mảng kết hợp
        return $result->fetch_assoc();
    }
    public function get_account_by_id($account_id) {
        $sql = "SELECT * FROM account WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $account_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function search_history($searchTerm) {
    $sql = "SELECT h.id, u.username AS username, h.purchase_date, h.acc_id, a.type AS type, 
                   a.name AS account_name, a.price AS price, a.status AS status, a.password
            FROM history h
            JOIN user u ON h.user_id = u.id
            JOIN account a ON h.acc_id = a.id
            WHERE u.username LIKE ? OR a.name LIKE ? OR a.type LIKE ?
            ORDER BY h.purchase_date DESC";

    $stmt = $this->conn->prepare($sql);
    $keyword = "%".$searchTerm . "%";
    $stmt->bind_param('sss', $keyword, $keyword, $keyword);
    $stmt->execute();
    $result = $stmt->get_result();

    $list_history = [];
    while ($row = $result->fetch_assoc()) {
        $list_history[] = $row;
    }
    return $list_history;
}  
}
?>