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
        
        <form method="POST" action="controller/c_signup.php">
            <h2 class="text-center" >Đăng kí tài khoản</h2>
            <div class="form-group ">
                <label for="email">Email Address</label>
                <input type="text" id="email" name="email" class="form-control"required>
            </div>
            <div class="form-group ">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="form-group ">
                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="firstname" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="lastname">Last Name</label>
                <input type="text" id="lastname" name="lastname" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Đăng kí</button>
            <p class="mt-3 text-center">Bạn đã có tài khoản? <a href="signin.php">Đăng nhập</a>
    </p>
        </form>
    </div>


<?php include('template/footer.php') ?>

