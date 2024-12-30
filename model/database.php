<?php

class Database
{
    public $CONFIG_servername = "localhost";
    public $CONFIG_username = "root";
    public $CONFIG_password = "";
    public $CONFIG_dbname = "shop_acc";

    public $conn;

    public $query = null;

    public function __construct()
    {
        // Kết nối đến cơ sở dữ liệu
        $this->conn = new mysqli($this->CONFIG_servername, $this->CONFIG_username, $this->CONFIG_password, $this->CONFIG_dbname);
    
        // Kiểm tra kết nối
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Thiết lập truy vấn
    public function set_query($sql)
    {
        $this->query = $sql;
    }

    // Thực thi truy vấn
    public function execute_query()
    {
        $result = $this->conn->query($this->query);
        return $result;
    }

    // Đóng kết nối
    public function close()
    {
        $this->conn->close();
    }

    // Lấy tất cả dữ liệu dưới dạng mảng kết hợp
    public function load_all_rows()
    {
        $result = $this->conn->query($this->query); // Thực thi truy vấn SQL
        if ($result === false) {
            die("Error executing query: " . $this->conn->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC); // Trả về mảng kết hợp chứa tất cả kết quả
    }
}

?>
