<?php
    require_once('../model/m_user.php');
    require_once('../model/database.php');

    // Nếu không phải POST, lấy thông tin tài khoản để hiển thị form chỉnh sửa
    if (isset($_GET['id'])) {
        $user_id = intval($_GET['id']); // Lấy ID tài khoản từ GET
        $user_model = new User();
        $user_info = $user_model->get_user_by_id($user_id); // Phương thức lấy thông tin tài khoản

        if ($user_info) {
            // Hiển thị form chỉnh sửa với thông tin tài khoản
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit User</h2>
        <form action="../controller/c_edit_user.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $user_info['id']; ?>">
            
            <div class="mb-3">
                <label for="username" class="form-label">User Name</label>
                <input type="text" id="username" name="username" class="form-control" value="<?php echo $user_info['username']; ?>" >
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="text" id="password" name="password" class="form-control" value="<?php echo $user_info['password']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">email</label>
                <input type="text" id="email" name="email" class="form-control" value="<?php echo $user_info['email']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <input type="number" id="role" name="role" class="form-control" value="<?php echo $user_info['role']; ?>" min="0" max="1">
            </div>

            <button type="submit" class="btn btn-success">Sửa lại</button>
        </form>
    </div>
</body>
</html>
<?php
        } else {
            echo "Không tìm thấy sản phẩm";
        }
    } else {
        echo "Invalid request!";
    }
?>
