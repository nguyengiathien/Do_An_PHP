<style>
    .card.bg-info {
    background-color: aqua; /* Màu xanh thông dụng */
    color: purple;
    border-radius: 8px;
    padding: 15px;
    text-align: left;
    }
    .sidebar {
        width: 300px; /* Điều chỉnh chiều rộng sidebar */
        background-color: black; /* Màu nền sidebar */
        padding: 10px;
        height: 100vh; /* Chiều cao full màn hình */
        overflow-y: auto; /* Thêm cuộn nếu nội dung dài */
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); /* Tạo hiệu ứng đổ bóng */
    }
    .nav-link {
        color: #212529; /* Màu chữ mặc định */
        font-weight: 500;
        padding: 10px;
    }

    .nav-link:hover {
        background-color: #007bff; /* Thay đổi màu khi hover */
        color: white;
        border-radius: 5px;
}
</style>
<div class="sidebar">
    <div class="admin-info text-white text-center">
    <div class="card bg-info p-3">
        <h4>Admin</h4>
        <p><strong>Username:</strong> <?php echo $_SESSION['loginUSER']; ?></p>
        <p><strong>Email:</strong> <?php echo $_SESSION['emailUSER']; ?></p>
        <a class="nav-link" href="../index.php" id="settingsDropdown" role="button" aria-expanded="false">
        Quay lại trang chủ</a>
    </div>
</div>
    <ul class="nav flex-column">
        <li class="nav-item hover">
            <a class="nav-link" href="list_user.php" id="settingsDropdown" role="button" aria-expanded="false">
                Quản lý người dùng
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" href="list_acc.php" id="settingsDropdown" role="button" aria-expanded="false">
                Quản lý tài khoản
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" href="list_cart.php" id="settingsDropdown" role="button" aria-expanded="false">
                Quản lý giỏ hàng
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" href="list_history.php" id="settingsDropdown" role="button" aria-expanded="false">
                Quản lý lịch sử giao dịch
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="confirmLogout()">Đăng Xuất</a>
        </li>
    </ul>
</div>

<script>
    function confirmLogout() {
        const confirmAction = confirm("Bạn có chắc chắn muốn đăng xuất?");
        if (confirmAction) {
            window.location.href = "../controller/c_signout.php";  // Redirect đến trang đăng xuất
        }
    }
</script>
