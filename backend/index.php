<?php 

    session_start();

    require_once "../connection.php";


    $select_stmtua = $db->prepare("SELECT * FROM users WHERE UUID = :UUID");
    $select_stmtua->bindParam(':UUID', $_SESSION['uuid']);
    $select_stmtua->execute();
    $rowua = $select_stmtua->fetch(PDO::FETCH_ASSOC);

    $queryt = "SELECT * FROM web_topup WHERE status = 'in_progress'";
    $resultt = mysqli_query($conn, $queryt);
    $rowt = mysqli_num_rows($resultt);

    if ($_SESSION == NULL) {
        header("location:index.php");
        exit();
      }

    if ($rowua['rank'] != 'jubchai_team') {
        header ("Location: ../member");
        exit();
      } else {

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="icon" href="../img/jccom.png">
    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.css" rel="stylesheet" />
</head>

<body>
<br><br><br><br><br><br><br><br><br>
    <a href="topup.php" class="btn btn-info position-relative">Manage Topup   <?php if($rowt != '0') { ?>
      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
    <?php echo $rowt. '+' ?>
    <span class="visually-hidden">unread messages</span>
  </span> <?php }?> </a>
    <a href="point.php" class="btn btn-info">Manage Point Web</a>
    <a href="premium.php" class="btn btn-info">Manage Player Premium</a>
    <a href="shop_rank.php" class="btn btn-info">Manage Shop Rank</a>
    <a href="shop_item.php" class="btn btn-info">Manage Shop Item</a>
    <a href="purchase_history.php" class="btn btn-info">Purchase History</a>
    <a href="rank.php" class="btn btn-info">Manage Server Rank</a>
    <br>
    <br>
    <a href="announce.php" class="btn btn-info"> Manage Announcement</a>
    <a href="servershop.php" class="btn btn-info">Manage Server Shop</a>
    <a href="shopcategory.php" class="btn btn-info">Manage Shop Category</a>
    <a href="crate.php" class="btn btn-info">Manage Crate</a>
    <a href="cratecategory.php" class="btn btn-info">Manage Crate Category</a>
    <a href="login_player.php" class="btn btn-info">Login Player</a>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.js"></script>
</body>

</html>

<?php } ?>