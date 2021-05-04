<?php 

    session_start();

    require_once "connection.php";

    if (isset($_POST['submit'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        $user_check = "SELECT * FROM user WHERE username = '$username' LIMIT 1";
        $result = mysqli_query($conn, $user_check);
        $user = mysqli_fetch_assoc($result);

        if ($user['username'] === $username) {
            echo "<script>alert('Username already exists');</script>";
        } else {
            $passwordenc = md5($password);

            $query = "INSERT INTO user (username, password, email, userlevel)
                        VALUE ('$username', '$passwordenc', '$email', 'Member')";
            $result = mysqli_query($conn, $query);

            if ($result){
                $_SESSION['success'] = "สมัครสมาชิกสำเร็จ";
                header("Location: index.php");
            } else {
                $_SESSION['error'] = "สมัครสมาชิกผิดพลาด";
                header("Location: index.php");
            }
        }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jubchai Community Register</title>
    <link rel="icon" href="img/jccom.png">
    <!-- Css -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<style type="text/css">
body {
    background-image: url('img/bg3.png');
    -webkit-background-size: cover;
    background-attachment: fixed;
    font-weight: 700;
}

</style>
<body>

    <center><img align="top" width="300px" src="img/jccom.png" alt=""></center>
    
    <form class="box" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

    <h1>Register</h1>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="submit" name="submit" value="Register">
        <font class="text-muted"><i class="far fa-copyright"></i> Copyright 2021 By <a href="https://facebook.com/jubchairoom" class="text-sky" target="_blank">Jubchairoom</a></font>
    </form>

</body>
</html>