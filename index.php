<?php 

    session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jubchai Community</title>
    <link rel="icon" href="img/jccom.png">

    <!-- Css -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<style type="text/css">
body {
    background-image: url('img/bg01.png');
    -webkit-background-size: cover;
    background-attachment: fixed;
    font-weight: 700;
}

</style>

<body>

    <center><img width="300px" src="img/jccom.png" alt=""></center>

    <form class="box" action="login.php" method="post">
        <h1>Login</h1>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" name="btn_login" value="Login">
        <a href="register.php">
        <input type="button" value="register">
        </a>
        <font class="text-muted"><i class="far fa-copyright"></i>© Copyright 2021 By <a href="https://facebook.com/jubchairoom" class="text-sky" target="_blank">Jubchairoom</a></font>
    </form>

    <?php if (isset($_SESSION['success'])) : ?>
        <div class="success">
            <?php 
                echo $_SESSION['success'];
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])) : ?>
        <div class="error">
            <?php 
                echo $_SESSION['error'];
            ?>
        </div>
    <?php endif; ?>


</body>
</html>

<?php 

    if (isset($_SESSION['success']) || isset($_SESSION['error'])) {
        session_destroy();
    }

?>