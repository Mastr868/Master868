<?php
// config.php
$servername = "sql210.ezyro.com";  // میزبان MySQL
$username = "ezyro_39259758";       // نام کاربر دیتابیس
$password = "7ecfbe46";       // پسورد دیتابیس
$dbname = "ezyro_39259758_titan";    // نام دیتابیس

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    ?>