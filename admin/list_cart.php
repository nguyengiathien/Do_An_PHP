<?php
session_start();
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !==true){
    header("index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            background-color: #343a40;
        }
        .sidebar a {
            color: #ffffff;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 250px;
        }
        .header {
            height: 80px;
            background-color: #007bff;
            color: white;
            text-align: center;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <?php 
        require ('../template/admin_header.php');
    ?>

    <div class="content">
        <div class="header">
            <h1>Dashboard</h1>
        </div>
        <div class="container mt-4">
            <h2>Danh sách giỏ hàng của toàn bộ người dùng</h2>
            <p>Thông tin chi tiết các giỏ hàng hiện có trong hệ thống.</p>
            <form method="GET" action="" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên sản phẩm, người dùng..." 
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                    <?php 
                        require('../model/database.php');
                        $db = new Database();
                        $search = isset($_GET['search']) ? $_GET['search'] : '';
                        // Lấy danh sách giỏ hàng của tất cả người dùng
                        $sql = "SELECT c.user_id, cd.cart_id, cd.cart_name, cd.cart_pass, cd.type, cd.status, cd.price, 
                                       a.rank, a.skins, a.champions, a.password, u.username, cd.account_id
                                FROM cart c
                                INNER JOIN cart_detail cd ON c.id = cd.cart_id
                                INNER JOIN account a ON cd.account_id = a.id
                                INNER JOIN user u ON c.user_id = u.id
                                WHERE cd.cart_name LIKE '%$search%' 
                                    OR u.username LIKE '%$search%'"; // Giả sử có bảng `users` chứa thông tin người dùng
                        $db->set_query($sql);
                        $cart_items = $db->load_all_rows();
                    ?>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tên người dùng</th>
                                <th>Tên sản phẩm</th>
                                <th>Mật khẩu</th>
                                <th>Rank</th>
                                <th>Số lượng trang phục</th>
                                <th>Số lượng tướng</th>
                                <th>Phân loại</th>
                                <th>Đơn giá</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart_items as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['username']); ?></td>
                                    <td><?php echo htmlspecialchars($item['cart_name']); ?></td>
                                    <td><?php echo htmlspecialchars($item['cart_pass']); ?></td>
                                    <td><?php echo htmlspecialchars($item['rank']); ?></td>
                                    <td><?php echo htmlspecialchars($item['skins']); ?></td>
                                    <td><?php echo htmlspecialchars($item['champions']); ?></td>
                                    <td><?php echo htmlspecialchars($item['type']); ?></td>
                                    <td><?php echo number_format($item['price'], 0, ',', '.'); ?> đ</td>
                                    <td>
                                        <?php 
                                        switch ($item['status']) {
                                            case 0: echo "Chưa thanh toán"; break;
                                            case 1: echo "Đã thanh toán"; break;
                                            case 2: echo "Đang chờ xác nhận thanh toán"; break;
                                            case 3: echo "Hiện đang ở trong giỏ hàng"; break;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="delete_on_cart.php?cart_id=<?php echo $item['cart_id']; ?>&account_id=<?php echo $item['account_id']; ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Bạn có muốn xóa sản phẩm này khỏi giỏ hàng không?')">
                                            Xóa
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
