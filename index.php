<?php include('template/head.php') ?>
<?php include('template/header.php') ?>

<style>
    #slider {
        padding-bottom: 30px;
        border: none;
        overflow: hidden;
    }
    .aspect-ratio-169 {
        display: block;
        position: relative;
        width: 100%;
        height: 0;
        overflow: hidden;
        padding-top: 35%;
        transition: 0.3s;
        align-items: center;
    }
    .aspect-ratio-169 img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover; /* Đảm bảo ảnh chiếm toàn bộ khung hình */
        text-align:center;
        
    }
    .btn-action {
        color: #DC93A9(220,147,169);
        text-decoration: underline;
        background-color: transparent;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .btn-action:hover {
        color: #fff;
        background-color: red;
        border-color: red;
    }
    .account-box {
    background-color: #ffc83d;
    border-radius: 10px;
    padding: 20px;
    margin: 10px 0;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s ease;
    min-width: 100px;
    height: auto; /* Chiều cao tự động phù hợp với nội dung */
    display: flex;
    flex-wrap: wrap; /* Cho phép phần tử linh hoạt xuống dòng */
    justify-content: space-between;
    align-items: center;
    text-align: left;
}

.account-info {
    display: flex;
    justify-content: space-between; /* Đặt các phần tử cách đều và kéo chúng ra hai bên */
    width: 100%;
}

.account-info .info p {
    margin: 0;
}

.account-info .info .rank {
    margin-left: auto; /* Đẩy phần tử Rank ra bên phải */
}

.account-box .info {
    width: 48%; /* Đảm bảo mỗi phần tử chiếm 48% chiều rộng của box */
    margin-bottom: 10px;
}

.account-box img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 2%;
    margin-right: 10px;
}

.account-box .price {
    font-weight: bold;
    color: #d9535f;
    font-size: 18px;
}
    .container {
        width: 100%; /* Đảm bảo container chiếm toàn bộ chiều rộng */
        max-width: 100%; /* Ngăn chặn giới hạn chiều rộng */
        overflow: hidden; /* Loại bỏ các phần thừa ra ngoài */
    }
    
    .container img {
        width: 100%; /* Hình ảnh chiếm toàn bộ chiều rộng container */
        height: auto; /* Giữ nguyên tỷ lệ khung hình */
        object-fit: cover; /* Làm cho hình ảnh bao phủ toàn bộ container */
    }
</style>

<!-- Hero Section -->
<div class="hero">
    <section id="slider">
        <div class="container">
            <div class="aspect-ratio-169">
                <div class="img-wrapper">
                    <img src="media/Lmhtarcane.jpg" alt="Arcane Lore">
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Main Content -->
<div class="container">
    <?php
    require('controller/c_list_acc_home.php');
    $c_acc = new C_acc;
    $list_acc = $c_acc->list_all_account();

    // Lấy giá trị tìm kiếm
    $searchQuery = isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '';
    $searchOption = isset($_GET['search-option']) ? $_GET['search-option'] : 'name';

    // Hiển thị tiêu đề tìm kiếm
    if ($searchQuery != '') {
        echo "<h3 class='search-results'>Kết quả tìm kiếm cho: <strong>$searchQuery</strong></h3>";
        echo "<p>Tiêu chí tìm kiếm: <strong>" . ucfirst($searchOption) . "</strong></p>";
    } else {
        echo "<h3 class='search-results'>Danh sách tài khoản</h3>";
    }
    ?>
    <div class="search-container">
        <form method="GET" action="index.php">
            <select id="search-option" name="search-option">
                <option value="name" <?php echo ($searchOption == 'name' ? 'selected' : ''); ?>>Tìm theo tên</option>
                <option value="rank" <?php echo ($searchOption == 'rank' ? 'selected' : ''); ?>>Tìm theo thứ hạng</option>
                <option value="skin" <?php echo ($searchOption == 'skin' ? 'selected' : ''); ?>>Tìm theo trang phục</option>
                <option value="champions" <?php echo ($searchOption == 'champions' ? 'selected' : ''); ?>>Tìm theo tướng</option>
                <option value="type" <?php echo ($searchOption == 'type' ? 'selected' : ''); ?>>Tìm theo loại</option>
                <option value="price" <?php echo ($searchOption == 'price' ? 'selected' : ''); ?>>Tìm theo giá</option>
            </select>
            <input type="text" name="query" id="search-input" placeholder="Nhập từ khóa..." value="<?php echo $searchQuery; ?>">
            <button type="submit" id="search-button">Tìm kiếm</button>
        </form>
    </div>
    <?php
    // Lọc danh sách tài khoản theo từ khóa và tiêu chí tìm kiếm
    $filteredAccounts = array_filter($list_acc, function ($acc) use ($searchQuery, $searchOption) {
        if ($acc['status'] != 0) return false;  // Chỉ hiển thị tài khoản có trạng thái 0

        switch($searchOption){
            case 'name':
                return stripos($acc['name'], $searchQuery) !== false;
            case 'rank':
                return stripos($acc['rank'], $searchQuery) !== false;
            case 'skin':
                return isset($acc['skins']) && intval($acc['skins']) <= intval($searchQuery);
            case 'champions':
                return isset($acc['champions']) && intval($acc['champions']) <= intval($searchQuery);
            case 'type':
                return stripos($acc['type'], $searchQuery) !== false;
            case 'price':
                return isset($acc['price']) && intval($acc['price']) <= intval($searchQuery);
            default:
                return false;
        }
    });
    if (!empty($filteredAccounts)) {
        // Hiển thị danh sách tài khoản
        echo "<div class='row'>";
        foreach ($filteredAccounts as $acc) {
            ?>
            <div class="col-lg-3">
                <div class="account-box">
                    <div class="account-info">
                        <!-- Dòng 1: Name và Rank -->
                        <div class="info">
                            <p ><strong>Name:<br><?php echo htmlspecialchars($acc['name']); ?></strong></p>
                            <p>Rank: <?php echo htmlspecialchars($acc['rank']); ?></p>
                        </div>
    
                        <!-- Dòng 2: Champions và Skin -->
                        <div class="info">
                            <p>Champions: <?php echo htmlspecialchars($acc['champions']); ?></p>
                            <p>Skins: <?php echo htmlspecialchars($acc['skins']); ?></p>
                        </div>
    
                        <!-- Dòng 3: Price -->
                        <div class="info">
                            <p class="price"><strong>Price:<br> <?php echo number_format($acc['price']); ?> đ</strong></p>
                        </div>
                    </div>
    
                    <p><img src="<?php echo substr($acc['avatar'], 3); ?>" alt="Avatar" style="width: 80%; height: auto;"></p>
                    
                    <?php if (!isset($_SESSION['loginUSER'])): ?>
                        <p class="message">Bạn chưa đăng nhập ? <a href="signin.php" class="btn-action">Đăng nhập</a></p>
                    <?php else: ?>
                        <p><a href="controller/c_add_to_cart.php?id=<?php echo $acc['id'] ?>" class="btn-action">Thêm</a></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php
        }
        echo "</div>";
    } else {
        echo "<p>Không có tài khoản nào phù hợp với tìm kiếm của bạn.</p>";
    }
    ?>

    <!-- Tìm kiếm -->
    
</div>

<?php include('template/footer.php') ?>