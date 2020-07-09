<?php session_start(); ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Thông Tin Đơn Hàng</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../asset/css/style.css" >
        <link rel="stylesheet" href="../asset/css/style.css">
    </head>
    <body>
    <?php
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
        include '/util/connect_db.php';
        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = array();
        }
        $error = false;
        $success = false;
        if (isset($_GET['action'])) {

            function update_cart($add = false) {
                foreach ($_POST['quantity'] as $id => $quantity) {
                    if ($quantity == 0) {
                        unset($_SESSION["cart"][$id]);
                    } else {
                        if ($add) {
                            $_SESSION["cart"][$id] += $quantity;
                        } else {
                            $_SESSION["cart"][$id] = $quantity;
                        }
                    }
                }
            }
            switch ($_GET['action']) {
                case "add":
                    update_cart(true);
                    header('Location:../product/cart.php');
                    break;
                case "delete":
                    if (isset($_GET['id'])) {
                        unset($_SESSION["cart"][$_GET['id']]);
                    }
                    header('Location:../product/cart.php');
                    break;
                case "submit":
                    if (isset($_POST['update_click'])) { //Cập nhật số lượng sản phẩm
                        update_cart();
                        header('Location:../product/cart.php');
                    } elseif ($_POST['order_click']) { //Đặt hàng sản phẩm
                        if (empty($_POST['name'])) {
                            $error = "Bạn chưa nhập tên của người nhận";
                        } elseif (empty($_POST['phone'])) {
                            $error = "Bạn chưa nhập số điện thoại người nhận";
                        } elseif (empty($_POST['address'])) {
                            $error = "Bạn chưa nhập địa chỉ người nhận";
                        } elseif (empty($_POST['quantity'])) {
                            $error = "Giỏ hàng rỗng";
                        }
                        if ($error == false && !empty($_POST['quantity'])) { //Xử lý lưu giỏ hàng vào db
                            $products = mysqli_query($con, "SELECT * FROM `product` WHERE `id` IN (" . implode(",", array_keys($_POST['quantity'])) . ")");
                            $total = 0;
                            $orderProducts = array();
                            while ($row = mysqli_fetch_array($products)) {
                                $orderProducts[] = $row;
                                $total += $row['price'] * $_POST['quantity'][$row['id']];
                            }
                            $insertOrder = mysqli_query($con, "INSERT INTO `order` (`id`, `name`, `phone`, `address`, `note`, `total`, `created_time`, `last_updated`) VALUES (NULL, '" . $_POST['name'] . "', '" . $_POST['phone'] . "', '" . $_POST['address'] . "', '" . $_POST['note'] . "', '" . $total . "', '" . time() . "', '" . time() . "');");
                            $orderID = $con->insert_id;
                            $insertString = "";
                            foreach ($orderProducts as $key => $product) {
                                $insertString .= "(NULL, '" . $orderID . "', '" . $product['id'] . "', '" . $_POST['quantity'][$product['id']] . "', '" . $product['price'] . "', '" . time() . "', '" . time() . "')";
                                if ($key != count($orderProducts) - 1) {
                                    $insertString .= ",";
                                }
                            }
                            $insertOrder = mysqli_query($con, "INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_time`, `last_updated`) VALUES " . $insertString . ";");
                            $success = "Đặt hàng thành công";
                            unset($_SESSION['cart']);
                        }
                    }
                    break;
            }
        }
        if (!empty($_SESSION["cart"])) {
            $products = mysqli_query($con, "SELECT * FROM `product` WHERE `id` IN (" . implode(",", array_keys($_SESSION["cart"])) . ")");
        }
//        $result = mysqli_query($con, "SELECT * FROM `product` WHERE `id` = ".$_GET['id']);
//        $product = mysqli_fetch_assoc($result);
//        $imgLibrary = mysqli_query($con, "SELECT * FROM `image_library` WHERE `product_id` = ".$_GET['id']);
//        $product['images'] = mysqli_fetch_all($imgLibrary, MYSQLI_ASSOC);
        ?>
        <div class="container">
            <?php if (!empty($error)) { ?> 
                <div id="notify-msg">
                    <?= $error ?>. <a href="javascript:history.back()">Quay lại</a>
                </div>
            <?php } elseif (!empty($success)) { ?>
                <div id="notify-msg">
                    <?= $success ?>. <a href="index.php">Tiếp tục mua hàng</a>
                </div>
            <?php } else { ?>
                <h1>Giỏ hàng</h1>
                <form id="cart-form" action="cart.php?action=submit" method="POST">
                    <table>
                        <tr>
                            <th class="product-number">STT</th>
                            <th class="product-name">Tên sản phẩm</th>
                            <th class="product-img">Ảnh sản phẩm</th>
                            <th class="product-price">Đơn giá</th>
                            <th class="product-quantity">Số lượng</th>
                            <th class="total-money">Thành tiền</th>
                            <th class="product-delete">Xóa</th>
                        </tr>
                        <?php
                        if (!empty($products)) {
                            $total = 0;
                            $num = 1;
                            while ($row = mysqli_fetch_array($products)) {
                                ?>
                                <tr>
                                    <td class="product-number"><?= $num++; ?></td>
                                    <td class="product-name"><?= $row['name'] ?></td>
                                    <td class="product-img"><img src="<?= $row['image'] ?>" /></td>
                                    <td class="product-price"><?= number_format($row['price'], 0, ",", ".") ?></td>
                                    <td class="product-quantity"><input type="text" value="<?= $_SESSION["cart"][$row['id']] ?>" name="quantity[<?= $row['id'] ?>]" /></td>
                                    <td class="total-money"><?= number_format($row['price'] * $_SESSION["cart"][$row['id']], 0, ",", ".") ?></td>
                                    <td class="product-delete"><a href="cart.php?action=delete&id=<?= $row['id'] ?>">Xóa</a></td>
                                </tr>
                                <?php
                                $total += $row['price'] * $_SESSION["cart"][$row['id']];
                                $num++;
                            }
                            ?>
                            <tr id="row-total">
                                <td class="product-number">&nbsp;</td>
                                <td class="product-name">Tổng tiền</td>
                                <td class="product-img">&nbsp;</td>
                                <td class="product-price">&nbsp;</td>
                                <td class="product-quantity">&nbsp;</td>
                                <td class="total-money"><?= number_format($total, 0, ",", ".") ?></td>
                                <td class="product-delete">Xóa</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                    <div id="form-button">
                        <input type="submit" name="update_click" value="Cập nhật" />
                    </div>
                    <hr>
                    <div><label>Người nhận: </label><input type="text" value="" name="name" /></div>
                    <div><label>Điện thoại: </label><input type="text" value="" name="phone" /></div>
                    <div><label>Địa chỉ: </label><input type="text" value="" name="address" /></div>
                    <div><label>Ghi chú: </label><textarea name="note" cols="50" rows="7" ></textarea></div>
                    <input type="submit" name="order_click" value="Đặt hàng" />
                </form>
            <?php } ?>
        </div>
    </body>
</html>