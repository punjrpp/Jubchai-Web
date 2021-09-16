<?php
    session_start();
    include('connection.php');

    if (isset($_POST['submit'])) {
        $playername = mysqli_real_escape_string($conn, $_POST['playername']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $query = "SELECT * FROM users WHERE playername = '".$playername."' ";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
            
        if (password_verify($password, $row['password'])) {
            
            $_SESSION['uuid'] = $row['UUID'];
            $_SESSION['playername'] = $row['playername'];

            if ($row['rank'] == 'default') {
                header('location: member/index.php');
            }

            if ($row['rank'] == 'villagerplus') {
                header('location: member/index.php');
            }

            if ($row['rank'] == 'pillager') {
                header('location: member/index.php');
            }

            if ($row['rank'] == 'pillagerplus') {
                header('location: member/index.php');
            }

            if ($row['rank'] == 'evoker') {
                header('location: member/index.php');
            }
            
            if ($row['rank'] == 'leader') {
                header('location: member/index.php');
            }

            if ($row['rank'] == 'jubchai_builder') {
                header('location: member/index.php');
            }

            if ($row['rank'] == 'jubchai_member') {
                header('location: member/index.php');
            }

            if ($row['rank'] == 'jubchai_team') {
                header('location: member/index.php');
            }
        }
        else {
            echo "<script>alert('Username หรือ Password ไม่ถูกต้อง')</script>";
                header("Location: index.php");
       }
    }