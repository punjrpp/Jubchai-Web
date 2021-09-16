<?php 

        $db_host = "localhost";
        $db_user = "root";
        $db_password = "";
        $db_name = "users";

    $conn = mysqli_connect("$db_host", "$db_user", "$db_password", "$db_name");
    mysqli_set_charset($conn, 'utf8');
    header('Content-Type: text/html; charset=utf-8');

    //ตั้งค่าชุดอักขระไคลเอนต์เริ่มต้น
    mysqli_set_charset($conn, "utf8");

    //ตั้งค่า timezone ในประเทศไทย
    date_default_timezone_set('Asia/Bangkok');

    if (!$conn) {
        die("Failed to connec to databse" . mysqli_error($conn));
    }


    try {
        $db = new PDO("mysql:host={$db_host}; dbname={$db_name}", $db_user, $db_password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->exec("set names utf8");

        //ตั้งค่าชุดอักขระไคลเอนต์เริ่มต้น
        // mysql_set_charset($db, "utf8");

        //ตั้งค่า timezone ในประเทศไทย
        date_default_timezone_set('Asia/Bangkok');
    } catch(PDOEXCEPTION $e) {
        $e->getMessage();
    }

    
?>