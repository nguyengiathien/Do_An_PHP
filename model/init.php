<?php

require_once("database.php");
class initDatabase extends Database {
    public function create_structure()
    {
        // Tạo bảng USER
        $sql = "CREATE TABLE IF NOT EXISTS user (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            email VARCHAR(50) NOT NULL ,
            password VARCHAR(255) NOT NULL, 
            role INT(1) NOT NULL DEFAULT 0, 
            create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );";
        $this->set_query($sql);
        $this->execute_query();
        // Tạo bảng CATEGORY
        $sql = "CREATE TABLE IF NOT EXISTS category (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL UNIQUE,
            description TEXT
        );";
        $this->set_query($sql);
        $this->execute_query();

        // Tạo bảng ACCOUNT
        $sql = "CREATE TABLE IF NOT EXISTS account (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL,
            password VARCHAR(255) NOT NULL,
            rank VARCHAR(20), 
            skins INT(3) UNSIGNED DEFAULT 0,
            champions INT(3) UNSIGNED DEFAULT 0,
            avatar VARCHAR(500), 
            price DECIMAL(10, 2) NOT NULL,
            type VARCHAR(50),
            category_id INT(6) UNSIGNED NULL,
            status TINYINT(1) DEFAULT 0,
            create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (category_id) REFERENCES category(id) ON DELETE SET NULL
        );";
        $this->set_query($sql);
        $this->execute_query();
        // Tạo bảng CART (Giỏ hàng)
        $sql = "CREATE TABLE IF NOT EXISTS cart (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT(6) UNSIGNED,
            totalprice DECIMAL(10, 2) DEFAULT 0.00,
            create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
        );";
        $this->set_query($sql);
        $this->execute_query();

        // Tạo bảng CART_DETAIL (Chi tiết giỏ hàng)
        $sql = "CREATE TABLE IF NOT EXISTS cart_detail (
            cart_id INT(6) UNSIGNED,
            account_id INT(6) UNSIGNED,
            cart_name VARCHAR(50) NOT NULL,
            cart_pass VARCHAR(50) NOT NULL,
            type VARCHAR(50),
            status TINYINT(1) DEFAULT 0,
            price DECIMAL(10, 2) NOT NULL,
            PRIMARY KEY (cart_id, account_id),
            FOREIGN KEY (cart_id) REFERENCES cart(id) ON DELETE CASCADE,
            FOREIGN KEY (account_id) REFERENCES account(id) ON DELETE CASCADE
        );";
        $this->set_query($sql);
        $this->execute_query();

        // Tạo bảng HISTORY (Lịch sử mua hàng + hiện trạng mua hànghàng)
        $sql = "CREATE TABLE IF NOT EXISTS history (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT(6) UNSIGNED,
            acc_id INT(6) UNSIGNED,
            purchase_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            price DECIMAL(10, 2) NOT NULL,
            currentstatus TINYINT(1) DEFAULT 0,
            FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
            FOREIGN KEY (acc_id) REFERENCES account(id) ON DELETE CASCADE
        );
        ";
        $this->set_query($sql);
        $this->execute_query();
        echo "INIT COMPLETE";
    }
}
try {
    $myinit = new initDatabase();
    $myinit->create_structure();

    // Chèn user nếu chưa tồn tại
    $sql = "INSERT INTO user (username, email, password, role)
            SELECT * FROM (SELECT 'dat', 'tranthanhdatsr11@gmail.com', '12345', 1) AS tmp
            WHERE NOT EXISTS (
                SELECT username FROM user WHERE username = 'dat'
            ) LIMIT 1;";
    echo "Admin 'dat' đã được thêm vào";
    $myinit->set_query($sql);
    $myinit->execute_query();
    $sql = "INSERT INTO user (username, email, password, role)
            SELECT * FROM (SELECT 'ta', 'dat', '12345', 1) AS tmp
            WHERE NOT EXISTS (
                SELECT username FROM user WHERE username = 'ta'
            ) LIMIT 1;";
    $myinit->set_query($sql);
    $myinit->execute_query();

    echo "Admin 'ta' đã được thêm vàovào!";
} catch (Exception $e) {
    echo "Khởi tạo thất bại: " . $e->getMessage();
}

?>
