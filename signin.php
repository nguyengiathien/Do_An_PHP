<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Định dạng form */
        form {
            max-width: 400px;
            margin: 50px auto; /* Căn giữa theo chiều ngang và tạo khoảng cách trên */
            padding: 20px;
            background: #f8f9fa; /* Màu nền nhẹ nhàng */
            border-radius: 10px; /* Góc bo tròn */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Hiệu ứng đổ bóng */
        }

        /* Định dạng nhóm form */
        .form-group {
            margin-bottom: 15px;
        }

        /* Nhãn đồng bộ */
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        /* Định dạng ô nhập liệu */
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Nút bấm */
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Định dạng footer */
        footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }
    </style>
<?php include('template/head.php') ?>

<?php include('template/header.php') ?>

    <div class="container">
        
        <form method="POST" action="controller/c_signin.php">
            <h2>Đăng Nhập</h2>
            <div class="form-group">
                <label for="email">Địa chỉ email</label>
                <input type="text" id="email" name="email" class="form-control"required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="role">Chọn vai trò</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="0">0 - Người dùng</option>
                    <option value="1">1 - Quản trị viên</option>
                </select>
            </div>
            <label style="color:red">
            <?php
            
                if (isset($_GET['valid']))
                {
                    echo " {$_GET['valid']} <br>";
                }
            ?>
        
            </label> <br>


            <button type="submit" class="btn btn-primary">Đăng nhập</button>
            <p class="message">Bạn chưa có tài khoản ? <a href="signup.php">Đăng kí</a></p>
    </div>
        </form>


<?php include('template/footer.php') ?>

