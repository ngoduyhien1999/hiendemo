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
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;700&display=swap" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            
            body{

                background-repeat: repeat-x;
                font-family: 'Oswald', sans-serif;
                color:rgba(255, 255, 255, 1);
            }
            .box-content{
                margin: 0 auto;
                width: 800px;
                border: 1px solid #ccc;
                text-align: center;
                padding: 20px;
                background-image: url("./images/pagebgr.png");
                
            }
            #user_login form{
                width: 500px;
                margin: 40px auto;
            }
            #user_login form input{
                margin: 5px 0;
            }
            .topnav {
                overflow: hidden;
                background-color: #333;
            }
            .topnav b {
                float: left;
                font-size: 30px;
                color: white;
            }
            .topnav a {
                float: right;
                color: #f2f2f2;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
                font-size: 17px;
            }
            
            .topnav a:hover {
                background-color: #ddd;
                color: black;
            }
            
            .topnav a.active {
                background-color: #4CAF50;
                color: white;
            } 
        </style>
    </head>
    <body>
        <div class="topnav">
        <a href="../lesson-22/index.php">Trang chủ</a>
        <a href="../lesson-22/admin/">Trang quản lý</a>
        <b>Hiển Project</b>
        </div>
        <div style="padding-right:16px">
        </div>
        <?php
        session_start();
        include './connect_db.php';
        $error = false;
            if (isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])) {
            $result = mysqli_query($con, "Select `id`,`username`,`fullname`,`birthday` from `user` WHERE (`username` ='" . $_POST['username'] . "' AND `password` = md5('" . $_POST['password'] . "'))");
            if (!$result) {
                $error = mysqli_error($con);
            } else {
                $user = mysqli_fetch_assoc($result);
                $_SESSION['current_user'] = $user;
            }
            mysqli_close($con);
            if ($error !== false || $result->num_rows == 0) {
                ?>
                <div id="login-notify" class="box-content">
                    <h1>Thông báo</h1>
                    <h4><?= !empty($error) ? $error : "Thông tin đăng nhập không chính xác" ?></h4>
                    <a href="./index.php">Quay lại</a>
                </div>
                <?php
                exit;
            }
        ?>
        <?php
        if (!empty($_SESSION['current_user'])) {
            $currentUser = $_SESSION['current_user'];
            ?> 

            <div id="login-notify" class="box-content">
                Xin chào <?= $currentUser['fullname'] ?><br/>
                <a href="./edit.php">Đổi mật khẩu</a><br/>
                <a href="./logout.php">Đăng xuất</a>
            </div>
            <?php
        } else {
            include './facebook_source.php';
            include './google_source.php';
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
                    <a href="<?= $loginUrl ?>"><img src="./images/facebook.png" alt='facebook login' title="Facebook Login" height="50" width="280" /></a>
                    <?php } ?>
                    <?php if(isset($authUrl)){ ?>
                    <a href="<?= $authUrl ?>"><img src="./images/google.png" alt='google login' title="Google Login" height="50" width="280" /></a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </body>
</html>