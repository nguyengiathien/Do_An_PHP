<?php
    require_once('../model/m_account.php');
    require_once('../model/database.php');

    // Nếu không phải POST, lấy thông tin tài khoản để hiển thị form chỉnh sửa
    if (isset($_GET['id'])) {
        $account_id = intval($_GET['id']); // Lấy ID tài khoản từ GET

        $account_model = new Account();
        $account_info = $account_model->get_account_by_id($account_id); // Phương thức lấy thông tin tài khoản

        if ($account_info) {
            // Hiển thị form chỉnh sửa với thông tin tài khoản
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Account</h2>
        <form action="../controller/c_edit_acc.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $account_info['id']; ?>">
            
            <div class="mb-3">
                <label for="name" class="form-label">Acc Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo $account_info['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="text" id="password" name="password" class="form-control" value="<?php echo $account_info['password']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="rank" class="form-label">Rank</label>
                <input type="text" id="rank" name="rank" class="form-control" value="<?php echo $account_info['rank']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="skins" class="form-label">Số lượng skin</label>
                <input type="number" id="skins" name="skins" class="form-control" value="<?php echo $account_info['skins']; ?>">
            </div>
            <div class="mb-3">
                <label for="champions" class="form-label">Số lượng Champion</label>
                <input type="number" id="champions" name="champions" class="form-control" value="<?php echo $account_info['champions']; ?>">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" id="price" name="price" class="form-control" value="<?php echo $account_info['price']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <input type="text" id="type" name="type" class="form-control" value="<?php echo $account_info['type']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="avatar" class="form-label">Acc Image</label>
                <input type="file" id="avatar" name="avatar" class="form-control">
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
