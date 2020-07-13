<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Hiển Project sign-in social</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type='text/css' href="login.css">
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;700&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="topnav">
        <a href="../product/index.php">Trang chủ</a>
        <a href="../product/admin/">Trang quản lý</a>
        <b>Hiển Project</b>
        </div>
        <div style="padding-right:16px">
        </div>
        <?php
        session_start();
        include '../util/connect_db.php';
        $error = false;
        $user = loginUser(addslashes($_POST['username','password']));
        ?>
        <?php
        if (!empty($_SESSION['current_user'])) {
            $currentUser = $_SESSION['current_user'];
            ?> 

            <div id="login-notify" class="box-content">
                Xin chào <?= $currentUser['fullname'] ?><br/>
                <a href="../userprofile/edit.php">Đổi mật khẩu</a><br/>
                <a href="./logout.php">Đăng xuất</a>
            </div>
            <?php
        } else {
            include '../vendor/facebook_source.php';
            include '../vendor/google_source.php';
            ?>
            <div id="user_login" class="box-content">
                <h1>Đăng nhập tài khoản</h1>
                <form action="./login.php" method="Post" autocomplete="off">
                    <label>Username</label></br>
                    <input type="text" name="username" value="" /><br/>
                    <label>Password</label></br>
                    <input type="password" name="password" value="" /></br>
                    <input type="checkbox" name="remember-me" value="">
                    <label for="remember-me">Ghi nhớ tài khoản</label>
                    <br>
                    <input type="submit" value="Đăng nhập" /><br/>
                    <a href="./register.php">Click vào đây để đăng ký</a>
                </form>
                <h2>Hoặc đăng nhập với mạng xã hội</h2>
                <div id="login-with-social">
                    <?php if(isset($authUrl)){ ?>
                    <a href="<?= $loginUrl ?>"><img src="../asset/images/facebook_login.png" alt='facebook login' title="Facebook Login" height="50" width="280" /></a>
                    <?php } ?>
                    <?php if(isset($authUrl)){ ?>
                    <a href="<?= $authUrl ?>"><img src="../asset/images/google_login.png" alt='google login' title="Google Login" height="50" width="280" /></a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </body>
</html>