<?php

    require_once("database.php");


    class Account extends Database{

        public function create_1_acc($name, $password, $rank, $skins,$champions, $price, $category_id, $avatar_path, $type)
        {
          
            $sql = "INSERT INTO account (name, password, rank, skins, champions, price, category_id, avatar, type)
            VALUES ('$name', '$password', '$rank','$skins','$champions', '$price', '$category_id', '$avatar_path', '$type')";

            $this->set_query($sql);
            $this->execute_query();
            $this->close();
        }
        public function list_all_account($searchTerm = '') {
            $sql = "SELECT account.*, category.name AS category_name 
                    FROM account 
                    LEFT JOIN category ON account.category_id = category.id";
            if ($searchTerm) {
                $sql .= " WHERE account.name LIKE ?";
                $this->set_query($sql);
                $stmt = $this->conn->prepare($sql);
                $searchTerm = "%$searchTerm%";
                $stmt->bind_param("s", $searchTerm);
                $stmt->execute();
                $result = $stmt->get_result();
                } else {
                    $this->set_query($sql);
                    $result = $this->execute_query();
                }
                return $result->fetch_all(MYSQLI_ASSOC);
            }

        public function delete_account_by_id($id) {
            $sql = "DELETE FROM account WHERE id = ?";
            $stmt = $this->conn->prepare($sql); 
            $stmt->bind_param("i", $id); 
            $result = $stmt->execute(); 
            $stmt->close(); 
            return $result;
        }
        public function get_account_by_id($id) {
            // Kiểm tra kết nối trước khi thực hiện truy vấn
            if ($this->conn) {
                $sql = "SELECT * FROM account WHERE id = ?";
                $stmt = $this->conn->prepare($sql); 
                
                if ($stmt === false) {
                    die('Prepare statement failed: ' . $this->conn->error);  // Nếu có lỗi khi chuẩn bị câu lệnh
                }
                
                $stmt->bind_param("i", $id); 
                $stmt->execute();
                
                // Kiểm tra kết quả
                $result = $stmt->get_result(); 
                $account = $result->fetch_assoc();
                
                $stmt->close();
                return $account; // Trả về dữ liệu tài khoản
            } else {
                die('Database connection failed');
            }
        }
        public function update_account($id, $name, $password, $rank, $skins, $champions, $price, $type, $avatar_path = null) {
            $sql = "UPDATE account 
                    SET name = ?, password = ?, rank = ?, skins = ?, champions = ?, price = ?, type = ?" 
                    . ($avatar_path ? ", avatar = ?" : "") . 
                    " WHERE id = ?";
            
            $stmt = $this->conn->prepare($sql);
            
            if ($avatar_path) {
                $stmt->bind_param("sssiiissi", $name, $password, $rank, $skins, $champions, $price, $type, $avatar_path, $id);
            } else {
                $stmt->bind_param("sssiiisi", $name, $password, $rank, $skins, $champions, $price, $type, $id);
            }
        
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }        
    }
?>