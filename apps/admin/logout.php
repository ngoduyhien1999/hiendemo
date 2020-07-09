<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Đăng xuất tài khoản</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="admin.css">
    </head>
    <body>
        <?php if (empty($_SESSION['current_user'])) { ?>
            <div class="topnav">
                <a href="../product/index.php">Trở lại Trang chủ</a>
                <a href="../apps/admin/index.php">Quay lại trang đăng nhập</a>
                <b>Hiển Project</b>
                </div>
                <div style="padding-right:16px">
                </div>
        <?php
        session_start();
        unset($_SESSION['current_user']);
        ?>
        <div id="user_logout" class="box-content">
            <h1>Đăng xuất tài khoản thành công</h1>
            <a href="./index.php">Đăng nhập lại</a>
        </div>
    </body>
</html>
