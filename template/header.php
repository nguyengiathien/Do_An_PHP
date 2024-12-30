<?php session_start(); ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-danger" style="background-color: #1a1a1d;">
    <style>
        .navbar {
    width: 100%;
    padding: 0;
    margin: 0;
    background-color: #C5D7F9;
    height: 130px; /* Điều chỉnh chiều cao của navbar */
    display: flex;
    justify-content: center; /* Căn giữa nội dung trong navbar */
    align-items: center; /* Căn giữa logo và các phần tử trong navbar theo chiều dọc */
        }
        .logo img {
    max-height: 100px; /* Đảm bảo chiều cao tối đa của logo */
    width: auto; /* Giữ tỷ lệ khung hình của logo */
    max-width: 100%; /* Đảm bảo logo không vượt quá chiều rộng của navbar */
    display: block; /* Đảm bảo logo không bị căn lề ngoài */
}
        .navbar-nav {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            margin-left: 20px;
        }
        .nav-link {
            color: black !important;
            font-weight: bold;
            margin: 0 10px;
        }
        .nav-link:hover {
            color: #f1c40f !important;
        }
        .nav-item {
            border-right: 1px solid #ddd;
            padding-right: 10px;
        }
        .nav-item:last-child{
            border-right: none;
        }
        .user-info {
            position: relative;
            color:  black !important;
            font-weight: bold;
        }
        .user-info .email-tooltip {
            display: none;
            position: absolute;
            top: 120%;
            left: 0;
            background-color: #333;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            white-space: nowrap;
            z-index: 10;
            font-size: 0.9em;
        }
        .user-info:hover .email-tooltip {
            display: block;
        }
        .search-container select,
        .search-container input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .search-container button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .search-container button:hover {
            background-color: #0056b3;
        }
    </style>
    <div class="navbar">
        <div class="logo">
            <a href="index.php">
                <img src="media/Uy (331 x 61 px).png" alt="Logo">
            </a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto ">
                <li class="nav-item ml-auto"><a class="nav-link" href="index.php">Home</a></li>
                <!-- <li class="nav-item"><a class="nav-link" href="model/init.php">Init</a></li> -->
                <?php if (isset($_SESSION["loginUSER"])) { ?>
                <li class="nav-item user-info">
                    <span class="nav-link">Welcome, <?php echo $_SESSION["loginUSER"]; ?></span>
                    <span class="email-tooltip">Email: <?php echo $_SESSION["emailUSER"]; ?></span>
                </li>
                <?php if(isset($_SESSION["roleUSER"]) && $_SESSION["roleUSER"] == 1) { ?>
    <form action="admin_login.php" method="POST">
        <button type="submit" class="nav-link" style="background: none; border: none;">
            Admin
        </button>
    </form>
<?php } ?>
                <li class="nav-item"><a class="nav-link" href="controller/c_cart.php">
                    <img src="media/cart.icon.jpg" alt="Cart" width="30" height="30">
                </a></li>
                <li class="nav-item"><a class="nav-link" href="history.php">Lịch sử</a></li>
                <li class="nav-item"><a class="nav-link btn btn-danger text-white" href="controller/c_signout.php">Sign Out</a></li>
                <?php } else { ?>
                    <li class="nav-item"><a class="nav-link" href="signup.php">Sign Up</a></li>
                    <li class="nav-item"><a class="nav-link" href="signin.php">Sign In</a></li>
                    <?php } ?>
                </ul>
        </div>
    </div>
</nav>

<!-- Modal Đăng Nhập Admin -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
