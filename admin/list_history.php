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
        .table-container {
    width: 100%;
    overflow-x: auto; /* Cho phép cuộn ngang */
}

.table {
    width: 100%; /* Đặt chiều rộng bảng là 100% container */
    max-width: none; /* Loại bỏ giới hạn chiều rộng */
    table-layout: auto; /* Điều chỉnh chiều rộng cột dựa trên nội dung */
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
            <!-- Add your content here -->
            <form method="GET" action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" placeholder="Search by username, account name, or type" 
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
            <div class="row">

                <div class="col-md-12">
                </div>

                <div class="col-md-12">
                    <?php 
                        require('../controller/c_list_history.php'); 
                        $History = new C_History();
                        $list_history =[];
                        if (isset($_GET['search']) && !empty($_GET['search'])){
                            $search= $_GET['search'];
                            $list_history = $History->search_history($search);
                        } else{
                            $list_history = $History->list_all_history();
                        }
                    ?>

                    <table class="table table-striped">
                        <thead>
                        <tr>
                                <th>History</th>
                                <th>Name User</th>
                                <th>Name Account</th>
                                <th>Password</th>
                                <th>TYPE</th>
                                <th>Trạng Thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($list_history as $his): ?>
                                <tr>
                                    <td> <?php echo "{$his['id']}"; ?>  </td>
                                    <td> <?php echo "{$his['username']}"; ?> </td>
                                    <td> <?php echo "{$his['account_name']}"; ?> </td>
                                    <td> <?php echo "{$his['password']}"; ?></td>
                                    <td> <?php echo "{$his['type']}"; ?></td>
                                    <td> <?php
                                        switch ($his['status']) {
                                            case 0: echo "Chưa thanh toán"; break;
                                            case 1: echo "Đã thực hiện thanh toán"; break;
                                            case 2:
                                                echo "Đang chờ xác nhận thanh toán";
                                                echo "<button id='confirm_button_{$his['id']}' class='btn btn-success btn-sm ms-2' onclick='confirmPayment({$his['id']})'>Xác nhận thanh toán</button>";
                                                break;
                                        }
                                    ?> </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $his['id']; ?>)">Delete</button>
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
        function confirmDelete(history_id) {
            const confirmAction = confirm(`Are you sure you want to delete transaction ID ${history_id}?`);
            if (confirmAction) {
                fetch(`delete_history.php?id=${history_id}`)
                .then(response => response.text())
                .then(response => {
                        alert(`Transaction ID ${history_id} has been successfully deleted.`);
                        location.reload();
                    })
                    .catch(error => {
                        alert(`Có lỗi không xác định xảy ra: ${error}`);
                        console.error('Error:', error);
                    });
            }
        }
        function confirmPayment(history_id) {
    const confirmAction = confirm(`Bạn có chắc muốn xác nhận thanh toán cho giao dịch ID ${history_id}?`);
    if (confirmAction) {
        fetch(`confirm_payment.php?id=${history_id}`, { method: 'GET' })
            .then(response => response.text())
            .then(response => {
                const statusElement = document.getElementById(`status_${history_id}`);
                if (statusElement) {
                    statusElement.innerText = 'Đã thanh toán';  // Cập nhật trạng thái
                }
                const confirmButton = document.getElementById(`confirm_button_${history_id}`);
                if (confirmButton) {
                    confirmButton.style.display = 'none';  // Ẩn nút xác nhận
                }
                alert(`Giao dịch ID ${history_id} đã được xác nhận thanh toán.`);
                location.reload();
            })
            .catch(error => {
                alert(`Có lỗi xảy ra: ${error}`);
                console.error('Error:', error);
            });
    }
}
    </script>
</body>
</html>
