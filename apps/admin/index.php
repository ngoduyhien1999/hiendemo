<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title> Quản lý sản phẩm </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="admin.css">
    </head>
    <body>
        <?php
        session_start();
        include '../util/connect_db.php';
        include '../login/facebook_source.php';
        include '../login/google_source.php';
        $error = false;
        $user = loginUser(addslashes($_POST['username','password']));
        ?>
        <?php if (empty($_SESSION['current_user'])) { ?>
            <div class="topnav">
                <a href="../product/index.php">Trở lại Trang chủ</a>
                <b>Hiển Project</b>
                </div>
                <div style="padding-right:16px">
                </div>
            <div id="user_login" class="box-content">
                <h1>Đăng nhập tài khoản</h1>
                <form action="./index.php" method="Post" autocomplete="off">
                    <label>Username</label></br>
                    <input type="text" name="username" value="" /><br/>
                    <label>Password</label></br>
                    <input type="password" name="password" value="" /></br>
                    <br>
                    <input type="submit" value="Đăng nhập" />
                </form>
                <h2>Hoặc đăng nhập với mạng xã hội</h2>
                <div id="login-with-social">
                    <?php if(isset($authUrl)){ ?>
                    <a href="<?= $loginUrl ?>"><img src="../asset/images/facebook.png" alt='facebook login' title="Facebook Login" height="50" width="280" /></a>
                    <?php } ?>
                    <?php if(isset($authUrl)){ ?>
                    <a href="<?= $authUrl ?>"><img src="../asset/images/google.png" alt='google login' title="Google Login" height="50" width="280" /></a>
                    <?php } ?>
                </div>
            </div>
            <?php
        } else {
            $currentUser = $_SESSION['current_user'];
            ?>
            <div class="topnav">
                <a href="./index.php">Trở lại Trang chủ</a>
                <b>Hiển Project</b>
                </div>
                <div style="padding-right:16px">
                </div>
            <div id="login-notify" class="box-content">
                Xin chào <?= $currentUser['fullname'] ?><br/>
                <a href="./product_listing.php">Quản lý sản phẩm</a><br/>
                <a href="./edit.php">Đổi mật khẩu</a><br/>
                <a href="./logout.php">Đăng xuất</a>
            </div>
        <?php } ?>
    </body>
</html>