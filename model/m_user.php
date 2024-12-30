<?php

    require_once("database.php");


    class User extends Database{

        public function create_1_user( $email, $password, $username, $role )
        {
            $check_sql = "SELECT * FROM user WHERE username = ? OR email = ?";
            $stmt = $this->conn->prepare($check_sql);
            $stmt->bind_param("ss", $username, $email);
            $stmt->execute();
            $result = $stmt->get_result();
        
            $stmt->close();
            $sql = "INSERT INTO user (username, email, password, role)
            VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sssi", $username, $email, $password, $role);
            $stmt->execute();
            $stmt->close();
        }

        public function signin_user($email, $password, $role)
        {
            $sql = "SELECT * FROM user WHERE email = ? AND password = ? AND role = ? LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssi", $email, $password, $role);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            } 
            return null;
        }

        public function list_all_user($search = null) {

            $sql = "SELECT  * 
            FROM user";
            if ($search){
                $sql .= " WHERE username LIKE ? OR email LIKE ?";
            }
            $stmt = $this->conn->prepare($sql);
    if ($search) {
        $search_param = "%" . $search . "%";
        $stmt->bind_param("ss", $search_param, $search_param);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $list_user = array();
    while ($row = $result->fetch_assoc()) {
        $list_user[] = $row;
    }

    $stmt->close();
    return $list_user;
        }
        public function get_user_by_id($id) {
            // Kiểm tra kết nối trước khi thực hiện truy vấn
            if ($this->conn) {
                $sql = "SELECT * FROM user WHERE id = ?";
                $stmt = $this->conn->prepare($sql); 
                
                if ($stmt === false) {
                    die('Prepare statement failed: ' . $this->conn->error);  // Nếu có lỗi khi chuẩn bị câu lệnh
                }
                
                $stmt->bind_param("i", $id); 
                $stmt->execute();
                
                // Kiểm tra kết quả
                $result = $stmt->get_result(); 
                $user = $result->fetch_assoc();
                
                $stmt->close();
                return $user; // Trả về dữ liệu tài khoản
            } else {
                die('Database connection failed');
            }
        }


        public function delete_user_by_id($id) {
            $sql = "DELETE FROM user WHERE id = ?";
            $stmt = $this->conn->prepare($sql); 
            $stmt->bind_param("i", $id); 
            $result = $stmt->execute(); 
            $stmt->close(); 
            return $result;
        }
    }


?>