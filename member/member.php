<?php 

  session_start();

  if (!$_SESSION['userid']) {
    header ("Location: index.php");
  } else {

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jubchai Community</title>
    <link rel="icon" href="img/jccom.png">

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- Logo -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- Css -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
    
    <style>

      *{
        margin: 0;
        padding: 0;
      }
      
      .one{
        background-image: url(shot.png)
        height: 100vh;
      }

    </style>

      <script src="https://apps.elfsight.com/p/platform.js" defer></script>
      <div class="elfsight-app-fd7560c0-a1d5-4998-b4eb-c0b7fbf98bed"></div>
</head>

<style type="text/css">
body {
    background-image: url('../img/bg02.jpg');
    -webkit-background-size: cover;
    background-attachment: fixed;
    font-weight: 700;
}

</style>

<body>

    <!-- Navbar -->
    <?php include_once (__DIR__).('/../include/navbar.php') ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script sec="assets/js/script.js"></script>
    <br>

    <!-- Button Social Start -->
    <center><div>
        <button type="button" class="btn btn-outline-dark" id="copy" style="
              border-top-left-radius: 40px;
              border-bottom-left-radius: 40px;
            " onclick="window.open('http://jubchairoom.net/discord', '_blank');">
            <i class="uil uil-discord"></i> Discord
        </button>
        <button type="button" class="btn btn-outline-dark" id="copy" style="
            " onclick="window.open('https://www.instagram.com/jubchairoom/', '_blank');">
            <i class="uil uil-instagram"></i> Instargram
        </button>
        <button type="button" class="btn btn-outline-dark" id="copy" style="
            " onclick="window.open('https://www.facebook.com/jubchairoom', '_blank');">
            <i class="uil uil-facebook"></i> Facebook
        </button>
        <button type="button" class="btn btn-outline-dark" id="copy" style="
            " onclick="window.open('https://www.twitch.tv/jubchaiofficial', '_blank');">
            <i class="fab fa-twitch"></i> Twitch
        </button>
        <button type="button" rel="noopener" class="btn btn-outline-dark" style="
              border-top-right-radius: 40px;
              border-bottom-right-radius: 40px;
            " onclick="window.open('https://www.youtube.com/channel/UCRbtmr09VBmbpkRmeuVsG3g', '_blank');">
            <i class="uil uil-youtube"></i> Youtube
        </button>
    </div></center>
    <!-- Button Social End -->

    <!-- Member -->
    <?php include_once (__DIR__).('/../include/jcteam.php') ?>

    <!-- Live chat -->
    <header class="chat">

    </header>

    <footer class="text-center">
      <font class="text-muted"><i class="far fa-copyright"></i> Copyright 2021 By <a href="https://facebook.com/jubchairoom" class="text-sky" target="_blank">Jubchairoom</a></font>
    </footer>
    <br>
</body>
</html>


<?php } ?>