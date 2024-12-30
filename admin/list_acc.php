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
        .header {
            height: 80px;
            background-color: #007bff;
            color: white;
            text-align: center;
            padding-top: 10px;
        }
        .content {
            margin-left: 250px;
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
            <!-- Add your content here -->

            <div class="row">

                <div class="col-md-12">
                    <a href="add_acc.php">
                        <button class="btn btn-primary"> + Add acc </button>
                    </a>
                </div>
                <div class="container mt-4">
                    <!-- Thêm Search Bar -->
                     <form method="GET" action="">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search by Account Name" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </form>
                    <div class="col-md-12">
                
                    <?php 
                        require('../controller/c_list_acc.php');
                        $c_account = new C_acc();
                        $list_account= $c_account->list_all_account();
                    ?>

                    <table class="table table-striped">
                        <thead>
                        <tr>
                                <th>Image</th>
                                <th>Acc Name</th>
                                <th>Price</th>
                                <th>Loại</th>
                                <th>Danh mục</th>
                                <th>Trạng Thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list_account as $account): ?>
                                <tr>

                                <td> <img style="height:75px;" src="<?php echo "{$account['avatar']}"; ?> "> </td>
                                <td> <?php  echo "{$account['name']}"; ?>  </td>
                                <td> <?php  echo "{$account['price']}"; ?> </td>
                                
                                <td> <?php  echo "{$account['type']}"; ?></td> 
                                <td> <?php  echo "{$account['category_name']}";?></td>
                                <td><?php 
                            switch ($account['status']){
                                case 0: echo "Chưa Thanh toán ";
                                break;
                                case 1: echo"Đã thanh toán ";
                                break;
                                case 2: echo"Đang chờ xác nhận đơn hàng";
                                break;
                                case 3: echo"Đang nằm trong một giỏ hàng khác";
                            }
                                ?>
                                </td>
                                <td>
                                    <a href="edit_acc.php?id=<?php echo $account['id'];?>" class="btn btn-primary btn-sm">EDIT</a>
                                    <button
                                    class="btn btn-danger btn-sm"
                                    onclick="confirmDelete(<?php echo $account['id']; ?>, '<?php echo $account['name']; ?>')">
                                    Delete</button>
                                </td>
                                
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete(acc_id, acc_name) {
            const confirmAction = confirm(`Bạn có muốn xóa account "${acc_name}" không?`);
            if (confirmAction) {
                fetch(`delete_acc.php?id=${acc_id}`)
                .then(response => response.text())
                .then(response => {
                        alert(`Account "${acc_name}" đã được xóa thành công.`);
                        location.reload();
                    })
                    .catch(error => {
                        alert(`Có lỗi không xác định xảy ra: ${error}`);
                        console.error('Error:', error);
                    });
            }
        }
    </script>
</body>
</html>
