<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Chi Tiết Sản Phẩm</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../asset/css/style.css" >
        <link rel="stylesheet" href="../asset/css/topnav.css">
    </head>
    <body>
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v7.0&appId=393359981624946&autoLogAppEvents=1" nonce="0cLQjVUy"></script>
        <?php
        session_start();
        if (!empty($_SESSION['current_user'])) {
            $currentUser = $_SESSION['current_user'];
            ?>
            <div class="topnav">
            <a href="../login/login.php">Chào <?= $currentUser['fullname'] ?> </a>
            <a href="../product/index.php">Trang Chủ</a>
            <b>Hiển Project</b>
            </div>
            <div style="padding-right:16px">
            </div>
            <?php
        } else {
            ?>
            <div class="topnav">
            <a href="../login/login.php">Đăng nhập</a>
            <a href="../product/index.php">Trang Chủ</a>
            <b>Hiển Project</b>
            </div>
            <div style="padding-right:16px">
            </div>
            }
        <?php } ?>
        <?php
        include '../util/connect_db.php';
        $result = mysqli_query($con, "SELECT * FROM `product` WHERE `id` = ".$_GET['id']);
        $product = mysqli_fetch_assoc($result);
        $imgLibrary = mysqli_query($con, "SELECT * FROM `image_library` WHERE `product_id` = ".$_GET['id']);
        $product['images'] = mysqli_fetch_all($imgLibrary, MYSQLI_ASSOC);
        ?>
        <div class="container">
            <h2>Chi tiết sản phẩm</h2>
            <div id="product-detail">
                <div id="product-img">
                    <img src="<?=$product['image']?>" />
                </div>
                <div id="product-info">
                    <h1><?=$product['name']?></h1>
                    <label>Giá: </label><span class="product-price"><?= number_format($product['price'], 0, ",", ".") ?> VND</span><br/>
                    <form id="add-to-cart-form" action="cart.php?action=add" method="POST">
                        <input type="text" value="1" name="quantity[<?=$product['id']?>]" size="2" /><br/>
                        <input type="submit" value="Mua sản phẩm" /><br/><br/>
                        <div class="fb-share-button" data-href="https://hiendemo.uns.vn/product/detail.php?id=<?=$product['id']?>" data-layout="button" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fhiendemo.uns.vn%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                    </form>
                    <?php if(!empty($product['images'])){ ?>
                    <div id="gallery">
                        <ul>
                            <?php foreach($product['images'] as $img) { ?>
                                <li><img src="<?=$img['path']?>" /></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php } ?>
                </div>
                <div class="clear-both"></div>
                <?=$product['content']?>
            </div>
        </div>
    </body>
</html>