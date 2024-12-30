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
            <h2>Chào mừng đến với khu vực quản lý của quản trị viên!</h2>
            <p> Đây là trung tâm quản lý ứng dụng của chúng tôi.</p>
            <form method="GET" action="list_user.php" class="mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Tìm kiếm người dùng..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                    <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                </div>
            </form>
            <?php
                require ('../controller/c_list_user.php');

                $c_user = new C_user();
                $search = isset($_GET['search']) ? $_GET['search'] : null;
                $list_user = $c_user->list_all_user($search);
                $currentAdmin = $_SESSION['loginUSER'];
            ?>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tên người dùng</th>
                                <th>Địa chỉ Email</th>
                                <th>Ngày khởi tạo</th>
                                <th>Vai trò</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($list_user) > 0): ?>
                                <?php foreach ($list_user as $user): ?>
                                    <?php if ($user['username'] ==$currentAdmin ) continue; // Nếu là admin, bỏ qua hiển thị ?>
                                    <tr>
                                        <td><?php echo "{$user['username']}"; ?></td>
                                        <td><?php echo "{$user['email']}"; ?></td>
                                        <td><?php echo "{$user['create_time']}"; ?></td>
                                        <td><?php 
                                        if($user['role']==1)
                                        echo "Quản trị viên";
                                    else echo"Người dùng";
                                    ?></td>
                                        <td>
                                        <a href="edit_user.php?id=<?php echo $user['id'];?>" class="btn btn-primary btn-sm">EDIT</a>
                                            <button 
                                            class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete(<?php echo $user['id']; ?>, '<?php echo $user['username']; ?>')">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Không tìm thấy kết quả phù hợp.</td>
                                    </tr>
                                    <?php endif; ?>
                        </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete(userId, username) {
            const confirmAction = confirm(`Bạn có muốn xóa người dùng "${username}" không?`);
            if (confirmAction) {
                fetch(`delete_user.php?id=${userId}`)
                    .then(response => response.text())
                    .then(() => {
                        alert(`Người dùng "${username}" đã được xóa thành công.`);
                        location.reload(); // Tải lại trang
                    })
                    .catch(error => {
                        alert(`Có lỗi xảy ra khi xóa người dùng "${username}".`);
                        console.error('Error:', error);
                    });
            }
        }
    </script>
</body>
</html>
