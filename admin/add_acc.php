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
            padding: 20px;
        }
        .header {
            height: 60px;
            background-color: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
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
        <h2>Welcome to the Admin Dashboard!</h2>
        <p>This is your central hub for managing the application.</p>

        <?php
            require ('../controller/c_list_user.php');
            $c_user = new C_user();
            $list_user = $c_user->list_all_user();
        ?>

        <div class="container">
        <div class="container">
                <h2>Thêm Acc</h2>
                
                <form action="../controller/c_add_acc.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Acc Name</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" id="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="rank" class="form-label">Rank</label>
                        <select name="rank" id="rank" class="form-control">
                        <option value="" disabled selected>-- Chọn bậc Rank --</option>
                        <option value="Un rank"> Không xếp hạng </option>
                        <option value="Bronze">Đồng</option>
                        <option value="Silver">Bạc</option>
                        <option value="Gold">Vàng</option>
                        <option value="Diamond">Kim cương </option>
                        <option value="Master">Cao thủ</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="skins" class="form-label"> Số lượng skin trang phục</label>
                        <input type="number" id="skins" name="skins" class="form-control" min="1" max="1000">
                    </div>
                    <div class="mb-3">
                        <label for="champions" class="form-label"> Số lượng Tướng</label>
                        <input type="number" id="champions" name="champions" class="form-control" min="1" max="300">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Đơn giá</label>
                        <input type="number" id="price" name="price" class="form-control" min="1">
                    </div>
                    <div class="mb-3">
                        <label for="category_name" class="form-label">Tên danh mục</label>
                        <input type="text" id="category_name" name="category_name" class="form-control" require>
                    </div>
                    <div
                     class="mb-3">
                        <label for="category_description" class="form-label">Mô tả</label>
                        <textarea id="category_description" name="category_description" class="form-control" row="3"required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Loại</label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="" disabled selected>-- Select Type --</option>
                            <option value="Normal">Normal</option>
                            <option value="PremiumPremium">Premium</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Ảnh nền sản phẩm</label>
                        <input type="file" id="avatar" name="avatar" class="form-control" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                </form>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
