<?php

$host = "localhost";
$user = "hiendemo";
$password = "th1s_1s_mySQl@p4ss";
$database = "hiendemo";
$con = mysqli_connect($host, $user, $password, $database, $email, $fullname);
if (mysqli_connect_errno()) {
    echo "Connection Fail: " . mysqli_connect_errno();
    exit;
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

