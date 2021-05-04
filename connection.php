<?php 

    $conn = mysqli_connect("localhost", "root", "", "logincommunity");

    if (!$conn) {
        die("Failed to vonnec to databse" . mysqli_error($conn));
    }



    $db_host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "logincommunity";

    try {
        $db = new PDO("mysql:host={$db_host}; dbname={$db_name}", $db_user, $db_password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOEXCEPTION $e) {
        $e->getMessage();
    }

    
?>