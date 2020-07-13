<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title> đăng ký, đăng nhập hệ thống</title>
        <meta charset="UTF-8">
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
            #user_register form{
                width: 200px;
                margin: 40px auto;
            }
            #user_register form input{
                margin: 5px 0;
            }
        </style>
    </head>
    <body>
        <?php
        include '../util/connect_db.php';
        include './function.php';
        $error = false;
        if (isset($_GET['action']) && $_GET['action'] == 'reg') {
            $user=registerUser(addslashes($_POST['username','password']));
            $user=Register_check(addslashes($_POST['username','password','birthday','fullname']));
        ?>
    </body>
</html>