<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Hiển Project - Danh sách sản phẩm</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../asset/css/topnav.css">
    </head>
    <body>
        <?php
        include '/util/connect_db.php';
        $item_per_page = !empty($_GET['per_page'])?$_GET['per_page']:4;
        $current_page = !empty($_GET['page'])?$_GET['page']:1; //Trang hiện tại
        $offset = ($current_page - 1) * $item_per_page;
        $products = mysqli_query($con, "SELECT * FROM `product` ORDER BY `id` ASC  LIMIT " . $item_per_page . " OFFSET " . $offset);
        $totalRecords = mysqli_query($con, "SELECT * FROM `product`");
        $totalRecords = $totalRecords->num_rows;
        $totalPages = ceil($totalRecords / $item_per_page);
        ?>
        <?php
        session_start();
        if (!empty($_SESSION['current_user'])) {
            $currentUser = $_SESSION['current_user'];
            ?>
            <div class="topnav">
            <a href="/login/login.php">Chào <?= $currentUser['fullname'] ?> </a>
            <a href="/product/admin">Trang quản lý</a>
            <b>Hiển Project</b>
            </div>
            <div style="padding-right:16px">
            </div>
            <?php
        } else {
            ?>
            <div class="topnav">
            <a href="/login/login.php">Đăng nhập</a>
            <a href="/product/admin">Trang quản lý</a>
            <b>Hiển Project</b>
            </div>
            <div style="padding-right:16px">
            </div>
            
        <?php } ?>

        <div class="container">
            <h1>Danh sách sản phẩm</h1>
            <div class="product-items">
                <?php
                while ($row = mysqli_fetch_array($products)) {
                    ?>
                    <div class="product-item">
                        <div class="product-img">
                            <a href="detail.php?id=<?= $row['id'] ?>"><img src="<?= $row['image'] ?>" title="<?= $row['name'] ?>" /></a>
                        </div>
                        <strong><a href="detail.php?id=<?= $row['id'] ?>"><?= $row['name'] ?></a></strong><br/>
                        <label>Giá: </label><span class="product-price"><?= number_format($row['price'], 0, ",", ".") ?> đ</span><br/>
                        <p><?= $row['content'] ?></p>
                        <div class="buy-button">
                        <strong><a href="detail.php?id=<?= $row['id'] ?>">Mua sản phẩm</a></strong><br/>
                        </div>
                    </div>
                <?php } ?>
                <div class="clear-both"></div>
                <?php
                include '../apps/pagination.php';
                ?>
                <div class="clear-both"></div>
            </div>
        </div>

    </body>
</html>