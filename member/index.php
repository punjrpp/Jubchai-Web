<?php 

  session_start();

  require_once "../connection.php";
  

  if (isset($_REQUEST['btn_topup'])) {
    try {
        $player = $_REQUEST['txt_playername'];
        $paymentch = $_REQUEST['txt_channel'];
        $time = $_REQUEST['txt_time'];
        $amount = $_REQUEST['txt_amount'];
        $status = "in_progress";

        $image_file = $_FILES['txt_file']['name'];
        $type = $_FILES['txt_file']['type'];
        $size = $_FILES['txt_file']['size'];
        $temp = $_FILES['txt_file']['tmp_name'];

        $path = "../backend/upload_topup/" . $image_file;

        if (empty($player)) {
            $errorMsg = "กรุณากรอกชื่อในเกมของคุณ";
        } else if (empty($paymentch)) {
            $errorMsg = "กรุณากรอกช่องทางการชำระเงินของคุณ";
        } else if (empty($time)) {
            $errorMsg = "กรุณากรอกเวลาทำรายการของคุณ";
        } else if (empty($amount)) {
            $errorMsg = "กรุณากรอกจำนวนเงินของคุณ";
        } else if (empty($image_file)) {
            $errorMsg = "กรุณาเพิ่มไฟล์สลิปทำรายการของคุณ";
        } else if ($type == "image/jpg" || $type == 'image/jpeg' || $type == "image/png" || $type == "image/gif") {
            if (!file_exists($path)) {
                if ($size < 5000000) {
                    move_uploaded_file($temp, '../backend/upload_topup/'.$image_file);
                } else {
                    $errorMsg = "ไฟล์ของคุณขนาดใหญ่เกิน 5 MB";
                }
            } else {
                $errorMsg = "มีรูปภาพสลิปการทำรายการของคุณแล้ว";
            }
        } else {
            $errorMsg = "กรุณาอัพโหลดไฟล์ด้วย JPG, JPEG, PNG และ GIF";
        }
        if (!isset($errorMsg)) {

            $insert_stmt = $db->prepare('INSERT INTO web_topup (playername, paymentch, time, amount, image, status) 
                                        VALUES (:fplayer, :fpaymentch, :ftime, :famount, :fimage, :fstatus)');
            $insert_stmt->bindParam(':fplayer', $player);
            $insert_stmt->bindParam(':fpaymentch', $paymentch);
            $insert_stmt->bindParam(':ftime', $time);
            $insert_stmt->bindParam(':famount', $amount);
            $insert_stmt->bindParam(':fimage', $image_file);
            $insert_stmt->bindParam(':fstatus', $status);

            if ($insert_stmt->execute()) {
                $insertMsg = "เติมเงินเรียบร้อย";
                header("refresh:2;index.php");
            }
        }

    } catch(PDOException $e) {
        $e->getMessage();
    }


    try {
        $tu_name = $_REQUEST['txt_playername'];
        $tu_pch = $_REQUEST['txt_channel'];
        $tu_amount = $_REQUEST['txt_amount'];

        if (empty($tu_name)) {
            $errorMsg = "กรุณากรอกชื่อในเกมของคุณ";
        } else if (empty($tu_pch)) {
            $errorMsg = "กรุณากรอกช่องทางการชำระเงินของคุณ";
        } else if (empty($tu_amount)) {
            $errorMsg = "กรุณากรอกจำนวนเงินของคุณ";
        }
        if (!isset($errorMsg)) {

            $insert_stmt = $db->prepare('INSERT INTO alert_topup (playername, payment_ch, amount)
                                        VALUES (:fplayername, :fpayment_ch, :famount)');
            $insert_stmt->bindParam(':fplayername', $tu_name);
            $insert_stmt->bindParam(':fpayment_ch', $tu_pch);
            $insert_stmt->bindParam(':famount', $tu_amount);

            if ($insert_stmt->execute()) {
                $insertMsg = "เติมเงินเรียบร้อย";
                header("refresh:2;index.php");
            }
        }

    } catch(PDOException $e) {
        $e->getMessage();
    }

}

  if (!$_SESSION['playername']) {
    header ("Location: ../index.php");
    exit();
  } else {

    if ($_SESSION != NULL) {
        $query = "SELECT * FROM users WHERE playername = '".$_SESSION['playername']."' ";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        extract($row);

        $_SESSION['uuid'] = $row['UUID'];
        $_SESSION['playername'] = $row['playername'];
    }
?>

<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jubchai Community</title>
    <link rel="icon" href="../img/jccomn.png">
    <link rel="stylesheet" href="style.css">


    <!-- Bootstrap CSS -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.css" rel="stylesheet" />
</head>

<style type="text/css">
body {
    font-family: 'Kanit', sans-serif;
}
</style>

<body>

    <header>
        
        <nav class="navbar">
            <div class="navbar-div">
                <div class="hamburger-menu">
                    <div class="line line-1"></div>
                    <div class="line line-2"></div>
                </div>

                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="#topup" class="nav-link"><img width="30px" src="../img/topup.png" alt="money"
                                class="nav"></a>
                    </li>
                    <li class="nav-item">
                        <a href="#shop" class="nav-link"><img width="30px" src="../img/shop.png" alt="shopping-cart"
                                class="nav"></a>
                    </li>
                    <li class="nav-item">
                        <a href="#top" class="nav-link"><img width="30px" src="../img/home.png" alt="home class="
                                nav"></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="banner-area">
        <div class="md">
            <div class="md-r">
                <a id="myBtn"><img src="../img/PatchW.png" alt="patch" class="nav"></a>
            </div>
        </div>

        <div class="banner-logo">
            <div class="imgant"><img class="logo-bn animationt" src="../img/jccomn.png" alt="logo"></div>
        </div>
    </div>


    <div class="content-area">
        <!-- content-area -->
        <div class="wrapper">
            <!-- wrapper -->

            <form class="finfo" action="" method="post">
                <div class="playerinfo">


                    <!-- <a href="change_password.php" style="float: right; margin-right: 1rem;">เปลี่ยนรหัสผ่าน</a> -->
                    <!-- <a href="change_password.php" style="float: right; margin-right: 1rem; background: red; border-radius: 10px; width: 100px; " id="myBtn"><span class="badge">จัดการสมาชิก</span></a> -->
                        <!-- Button trigger modal -->
                    <button type="button" style="margin-left: 10rem; margin-right: 10rem; margin-top: 3px; position: absolute;" class="badge btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    จัดการสมาชิก
                    </button>

                    <!-- Headplayer -->
                    <!-- https://mc-heads.net/head/<?php // echo $row['playername']; ?>/80 -->
                    <br>
                    <div class="form-outline mb-4">
                        <img src="https://minotar.net/helm/<?php echo $row['playername']; ?>/80.png" alt="headplayer"
                            class="headplayer">
                    </div>

                    <!-- Playername -->
                    <div class="txt form-outline mb-4">
                        <h2> <?php echo $row['playername']; ?> </h2>
                    </div>

                    <!-- Rank -->
                    <div class="txt form-outline mb-4">
                        <?php 
                    if ($row['rank'] == 'default') {
                    echo '<img src="../img/Rank/Villager.png" width="100px" alt="">';
                    } else if ($row['rank'] == 'villagerplus') {
                    echo '<img src="../img/Rank/Villager+.png" width="100px" alt="">';
                    } else if ($row['rank'] == 'pillager') {
                    echo '<img src="../img/Rank/Pillager.png" width="100px" alt="">';
                    } else if ($row['rank'] == 'pillagerplus') {
                    echo '<img src="../img/Rank/Pillager+.png" width="100px" alt="">';
                    } else if ($row['rank'] == 'evoker') {
                    echo '<img src="../img/Rank/Evoker.png" width="100px" alt="">';
                    } else if ($row['rank'] == 'leader') {
                    echo '<img src="../img/Rank/Leader.png" width="100px" alt="">';
                    } else if ($row['rank'] == 'jubchai_builder') {
                    echo '<img src="../img/Rank/Builder.png" width="100px" alt="">';
                    } else if ($row['rank'] == 'jubchai_member') {
                    echo '<img src="../img/Rank/Staff.png" width="100px" alt="">';
                    } else if ($row['rank'] == 'jubchai_team') {
                    echo '<img src="../img/Rank/Admin.png" width="100px" alt="">';
                    }
                    ?>
                    </div>

                    <!-- Point -->
                    <div class="txt form-outline mb-4">
                        <h5> <?php echo "คงเหลือ " .$row["point_web"]. " พอยท์" ?> </h5>
                    </div>

                    
                    <!-- Submit button -->
                    <!-- <a href="../logout.php" style="color: white; width: 130px; height: 40px;"
                        class="btn-logout btn mb-4 btn-secondary">จัดการสมาชิก</a> -->
                    <a href="../logout.php" style="color: white; width: 130px; height: 40px;"
                        class="btn-logout btn mb-4 btn-danger">ออกจากระบบ</a>
                    <?php
                    if ($rank == "jubchai_team") {
                    ?>
                    <a href="../backend" target="_blank" class="btn-logout btn mb-4 btn-black"
                        style="color: white; width: 130px; height: 40px;">ระบบหลังบ้าน</a>
                    <?php } ?>

                </div>
            </form>


            <div class="bg-topup" id="topup">
                <img class="topupway" src="../img/topupway.png" alt="topupway">
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

                <div class="container text-center">
                    <form action="" method="post" class="form-horizontal payment-tu" enctype="multipart/form-data">
                        <img src="../img/logo_tw.png" alt="logotw" class="logo-tw" width="350px">
                        <img src="../img/logo_pp.png " alt="logotw " class="logo-pp " width="350px "
                            style="margin-left: 5rem; ">
                        <br><br><br>
                        <?php 
                            if(isset($errorMsg)) {

                        ?>
                        <div class="alert alert-danger">
                            <strong><?php echo $errorMsg; ?></strong>
                        </div>
                        <?php } ?>

                        <?php 
                            if(isset($insertMsg)) {

                        ?>
                        <div class="alert alert-success">
                            <strong><?php echo $insertMsg; ?></strong>
                        </div>
                        <?php } ?>


                        <div class="form-payment">
                            <div class="row">
                                <label for="name" class="col-sm-3 control-label" class="ign">ชื่อในเกม</label>
                                <div class="col-sm-9">
                                    <input type="text" name="txt_playername" class="form-control"
                                        value="<?php echo $_SESSION['playername']; ?>" readonly
                                        placeholder="Enter name">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-payment">
                            <div class="row">
                                <label for="name" class="col-sm-3 control-label ">ช่องทางการเติม</label>
                                <div class="col-sm-9">
                                    <select id="country" name="txt_channel" class="form-control">
                                        <option value="Truemoney Wallet">Truemoney Wallet</option>
                                        <option value="PromptPay">PromptPay</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-payment">
                            <div class="row">
                                <label for="name" class="col-sm-3 control-label">ช่วงเวลาที่เติม</label>
                                <div class="col-sm-9">
                                    <input type="datetime-local" name="txt_time" class="form-control"
                                        placeholder="ช่วงเวลาที่คุณเติมเงิน">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-payment">
                            <div class="row">
                                <label for="name" class="col-sm-3 control-label">จำนวนเงินที่เติม</label>
                                <div class="col-sm-9">
                                    <input type="number" name="txt_amount" class="form-control"
                                        placeholder="จำนวนเงิน (บาท)">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-payment">
                            <div class="row">
                                <label for="name" class="col-sm-3 control-label">แนบสลิปเติม</label>
                                <div class="col-sm-9">
                                    <input type="file" name="txt_file" class="form-control">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="submit" name="btn_topup" class="btn btn-success" value="เติมเงิน">
                                <input class="btn btn-danger" type="reset" value="รีเซต">
                            </div>
                        </div>
                    </form>
                </div>

                <p style="margin-top: 1.5rem; text-align: center; background: red; color: white;">**หมายเหตุ:
                    ทางทีมงานจะใช้เวลาตรวจสอบสถานะการเติมเงินในระยะเวลา 1 ชม. ของเวลาทำการคือ 09.00น. - 23.00น.</p>

            </div> <!-- end bg-topup -->


            <div class="shop" id="shop">
                <div class="heading-shop">
                    <h1>Shop</h1>
                </div>

                <!-- <div class="pomo">
                    <img width="800px" src="../img/202107231.jpg" alt="pomotion">
                </div> -->

                <div class="row-shop">

                    <?php 
                $select_stmt = $db->prepare("SELECT * FROM web_shop_rank");
                $select_stmt->execute();

                $queryu = "SELECT * FROM users WHERE playername = '".$_SESSION['playername']."'";
                $resultu = mysqli_query($conn, $queryu);
                $rowu = mysqli_fetch_array($resultu, MYSQLI_ASSOC);

                $querya = "SELECT * FROM rank_price WHERE rank_code = '".$rowu['rank']."'";
                $resulta = mysqli_query($conn, $querya);
                $rowa = mysqli_fetch_array($resulta, MYSQLI_ASSOC);

                while ($pd = $select_stmt->fetch(PDO::FETCH_ASSOC)) {

                    $queryrp = "SELECT * FROM rank_price WHERE rank_code = '".$pd['product_code']."'";
                    $resultrp = mysqli_query($conn, $queryrp);
                    $rowrp = mysqli_fetch_array($resultrp, MYSQLI_ASSOC);


                    $queryr = "SELECT * FROM rank_price WHERE rank_code = '".$row['rank']."'";
                    $resultr = mysqli_query($conn, $queryr);
                    $rowr = mysqli_fetch_array($resultr, MYSQLI_ASSOC);

                    $realprice = $rowrp['rank_price'] - $rowr['rank_price'];

                    $sale_r = (100-$pd['sale']);
                    $sale_real_r = $sale_r * $realprice / 100;


                    if($rowa['rank_level'] < $rowrp['rank_level']) {

                        

                ?>

                    <div class="main">
                        <div class="img-shop">
                            <img src="../backend/upload_rank/<?php echo $pd["logo_image"] ?>" alt="item"
                                class="logo-rank">
                            <?php
                                                    if ($pd['sale'] != 0) {
                                                    
                            ?>
                            <h4 class="sale sl"><?php echo "Save " .$pd['sale']. " %" ?></h4>
                            <!-- <p><?php // echo "Real: " .$sale_real. " พอยท์" ?></p> -->
                            <?php } ?>
                        </div>
                        <div class="content">
                            <h1><?php echo $pd['product_name']; ?></h1>
                            <p><?php echo "ราคา: " .$sale_real_r. " พอยท์" ?>
                            <?php
                                                    if ($pd['sale'] != 0) {
                                                    
                            ?>
                            <s style="color: red; font-size: 14.5px;"><?php echo $realprice ?> พอยท์</s><?php } ?></p>
                            <br>
                            <a href="buy_rank.php?buy_id=<?php echo $pd["id"] ?>" name="btn_buy"
                                class="btn btn-success mb-3">ซื้อ</a>
                        </div>
                        <div class="footer">
                            <div class="ft-l">
                                <img src="../img/jccomn.png" alt="logo">
                            </div>
                        </div>
                    </div>

                    <?php } else if ($rowrp['rank_code'] == 'evoker') {

                        $queryevoker = "SELECT * FROM rank_price WHERE rank_code = 'evoker'";
                        $resultevoker = mysqli_query($conn, $queryevoker);
                        $rowevoker = mysqli_fetch_array($resultevoker, MYSQLI_ASSOC);


                        $queryevo = "SELECT * FROM rank_price WHERE rank_code = 'pillagerplus'";
                        $resultevo = mysqli_query($conn, $queryevo);
                        $rowevo = mysqli_fetch_array($resultevo, MYSQLI_ASSOC);

                        
                        $pricereal_evoker = $rowevoker['rank_price'] - $rowevo['rank_price'];
                        $sale_evo = (100-$pd['sale']);
                        $sale_real_evo = $sale_evo * $pricereal_evoker / 100;
                     ?>

                    <div class="main">
                        <div class="img-shop">
                            <img src="../backend/upload_rank/<?php echo $pd["logo_image"] ?>" alt="item"
                                class="logo-rank">
                            <?php
                                                    if ($pd['sale'] != 0) {
                                                    
                            ?>
                            <h4 class="sale sl"><?php echo "Save " .$pd['sale']. " %" ?></h4>
                            <!-- <p><?php // echo "Real: " .$sale_real. " พอยท์" ?></p> -->
                            <?php } ?>
                        </div>
                        <div class="content">
                            <h1><?php echo $pd['product_name']; ?></h1>
                            <p><?php echo "ราคา: " .$sale_real_evo. " พอยท์" ?>
                            <?php
                                                    if ($pd['sale'] != 0) {
                                                    
                            ?>
                            <s style="color: red; font-size: 14.5px;"><?php echo $pricereal_evoker ?> พอยท์</s><?php } ?></p>
                            <br>
                            <a href="buy_rank.php?buy_id=<?php echo $pd["id"] ?>" name="btn_buy"
                                class="btn btn-success mb-3">ซื้อ</a>
                        </div>
                        <div class="footer">
                            <div class="ft-l">
                                <img src="../img/jccomn.png" alt="logo">
                            </div>
                        </div>
                    </div>                    

                     <?php  } } ?>

                    <?php 
                    $select_stmt = $db->prepare("SELECT * FROM web_shop_item");
                    $select_stmt->execute();
                    
                    // $sale = 10;
                    // $a = (100-$sale);

                    while ($it = $select_stmt->fetch(PDO::FETCH_ASSOC)) {

                        $sale_i = (100-$it['sale']);
                        $sale_real_i = $sale_i * $it["price"] / 100;
                        


                    ?>

                    <div class="main">

                        <div class="img-shop">

                            <img src="../backend/upload_item/<?php echo $it["item_image"] ?>" height="170px" alt="item"
                                class="logo-rank">

                                                            <?php
                                                    if ($it['sale'] != 0) {
                                                    
                            ?>
                            <h4 class="sale sl"><?php echo "Save " .$it['sale']. " %" ?></h4>
                            <!-- <p><?php // echo "Real: " .$sale_real. " พอยท์" ?></p> -->
                            <?php } ?>

                        </div>
                        <div class="content">
                            <h1><?php echo $it["item_name"] ?></h1>
                            <p> ราคา: <?php echo $sale_real_i. " พอยท์" ?> 
                            <?php
                                                    if ($it['sale'] != 0) {
                                                    
                            ?>
                            <s style="color: red; font-size: 14.5px;"><?php echo $it['price'] ?> พอยท์</s><?php } ?></p>
                            <a href="buy_item.php?buy_id=<?php echo $it["id"] ?>&quantity=1" name="btn_buy"
                                class="btn btn-success mb-3">ซื้อ</a>
                        </div>
                        <div class="footer">
                            <div class="ft-l">
                                <img src="../img/jccomn.png" alt="logo">
                            </div>
                        </div>
                    </div>
                    <?php } ?>



                </div>

            </div>

            <div class="footer-credit">
                <footer class="footer-content">Powered by <a href="https://www.facebook.com/jubchairoom"
                        target="_blank">Jubchairoom</a> | Designed by <a href="https://www.facebook.com/jubchairoom"
                        target="_blank">Jubchairoom</a> | Developed by <a href="https://www.facebook.com/jubchairoom"
                        target="_blank">Jubchairoom</a>
                    <br>Copyright © 2021 .
                </footer>
            </div>

        </div>

    </div> <!-- end content-area -->



    <!-- Trigger/Open The Modal -->


    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content modal-dialog-scrollable">
            <div class="modal-header">
                <span class="close">&times;</span>

                <div class="w3-bar w3-black">
                    <button class="btn btn-primary" onclick="openPatch('Patch1')">แพทซ์ 1</button>
                    <button class="btn btn-primary" onclick="openPatch('Patch1.1')">แพทซ์ 1.1</button>
                    <button class="btn btn-primary" onclick="openPatch('Patch1.2')">แพทซ์ 1.2</button>
                    <button class="btn btn-primary" onclick="openPatch('Patch1.3')">แพทซ์ 1.3</button>
                    <button class="btn btn-primary" onclick="openPatch('Patch1.4')">แพทซ์ 1.4</button>
                    <button class="btn btn-primary" onclick="openPatch('Patch1.5')">แพทซ์ 1.5</button>
                    <button class="btn btn-primary" onclick="openPatch('Patch1.6')">แพทซ์ 1.6</button>
                </div>

            </div>
            <div class="modal-body">
                <center>

                    <div id="Patch1" class="w3-container city" style="display:none">
                        <h2>Patch #1 (Economy Updates)</h2>
                        <p>     Patch #1 (Economy Updates) <br>
                        เซิฟเวอร์เปิดทำการปกติโดยมีการอัปเดตเพิ่มเติมดังต่อไปนี้<br>
                        🔶 ยกเลิกระบบปิด X Y Z<br>
                        🔶 ยกเลิกระบบเข็มทิศ<br>
                        🔶 เพิ่มระบบ tpa และ sethome<br>
                        🔶 เพิ่มระบบ เกรดผลผลิตจากฟาร์ม<br>
                        🔶 เพิ่มระบบ ขายของตามเกรดของผลผลิต ยิ่งเกรดสูงยิ่งขายได้ราคาดี<br>
                        🔶 เพิ่มระบบ ป้องการเกรียน หินโพรเทค<br>
                        🔶 เพิ่มระบบ กล่องสุ่มเสี่ยงโชค<br>
                        🔶 เพิ่มระบบ เงินดิจิตอล (/money)<br>
                        🔶 เพิ่มระบบ ตายสุ่มเงินหาย<br>
                        🔶 เพิ่มระบบ ธนาคาร เพื่อให้ผู้เล่น ฝาก/ถอน เพื่อป้องกันเงินหายจากตัว<br>
                        🔶 เพิ่มระบบ ฝากเงินในธนาคารแล้ว +ดอกเบี้ย 0.5% ต่อวันเลยทีเดียว<br>
                        🔶 เพิ่มระบบ บัตรออนไลน์ เพื่อให้ผู้เล่นนำบัตรออนไลน์ไปแลกไอเทมภายในเซิฟเวอร์<br>
                        🔶 เฟอร์นิเจอร์ ที่ทีมงานทำกันข้ามวันข้ามคืนเพื่อให้ผู้เล่นได้มี อุปกรณ์ต่างๆ ไปใช้กันไปเลย (เฟอร์นิเจอร์ เก้าอี้,โต๊ะ ยังไม่มีเข้ามาใน อัพเดตนี้ แต่มี อุปกรณ์ส่วนใส่ หรือ อุปกรณ์ต่างๆเช่น อาวุธ ขวาน ที่ขุด)</p>
                    </div>

                    <div id="Patch1.1" class="w3-container city" style="display:none">
                        <h2>แพทซ์ 1.1 | อัปเดตร้านค้า (Store)</h2>
                        <p>📔 รายละเอียดแพทซ์ 1.1 - อัปเดตร้านค้า  🏪 <br>
<br>
                        📌 เพิ่มร้านค้า : <br>
                        ร้านค้าคอนกรีต, ร้านค้าขนแกะ, ร้านค้าธง, ร้านค้าผงคอนกรีต, ร้านค้าดินเหนียว, ร้านค้ากระจก, <br>
                        ร้านค้าดอกไม้, ร้านค้าขายของมอนเตอร์, ร้านค้าขายอุปกรณ์ม้า, ร้านค้าขายสี, ร้านค้าแผ่นเพลง, ร้านค้าพรม, ร้านค้าไม้, ร้านค้าของตกแต่ง<br>
                        📌 เพิ่มระบบ : /warp เพื่อใช้วาปไปยังสถานที่ต่างๆ<br>
                        📌 เพื่มระบบ Announcement ทุกๆ 10 นาที<br>
                        📌 เพิ่มระบบ : /rp เพื่อใส่รีซอสแพค<br>
                        📌 เพิ่มเซิฟเวอร์ล็อกอิน<br>
                        📌 ยกเลิกคูลดาวน์คำสั่ง /spawn<br>
                        📌 เพิ่มระบบการเตือนผู้เล่นเมื่อกระทำความผิด<br>
                        <br>
                        หากพบบัคสามารถส่งบัคมาได้เลยครับ**</p>
                    </div>
                    
                    <div id="Patch1.2" class="w3-container city" style="display:none">
                    <h2>แพทซ์ 1.2 | อัปเดตตลาดโลก (World Trade Updates)</h2>
                        <p>📔 รายละเอียดแพทซ์ 1.2 - อัปเดตตลาดโลก | World Trade Updates 🌍 <br>
                        <br>
                        📌 เพิ่มตลาดโลกโดยสามารถใช้งานได้ผ่าน NPC ที่เขตชุมชนหรือใช้คำสั่ง /worldtrade (/wt, /ah, /globalmarket)<br>
                        📌 เพิ่มการแสดงผลธนาคารที่สกอร์บอร์ด<br>
                        📌 เพิ่มเวลาแสดงผลทางเพย์เยอร์ลิสต์<br>
                        📌 แก้ไขบัคดอกเบี้ยธนาคาร<br>
                        <br>
                        หากพบบัคสามารถส่งบัคมาได้เลยครับ<br><br><br><br>
                        </p>
                    </div>

                    <div id="Patch1.3" class="w3-container city" style="display:none">
                        <h2>แพทซ์ 1.3 | อัปเดตเควส (Quest Updates)</h2>
                        <p>📔 รายละเอียดแพทซ์ 1.3 - อัปเดตเควส | Quest Updates 📚<br>
                        <br>
                        📌 เพิ่มระบบเควสเข้ามา (/q, /quest)<br>
                        📌 เปลี่ยนชื่อยศเป็นภาษาอังกฤษ<br>
                        📌 เพิ่มโมเดลใหม่เข้ามา<br>
                        <br>
                        หากพบบัคสามารถส่งบัคมาได้เลยครับ<br><br><br><br>
                        
                        📔 รายละเอียดแพทซ์ 1.3 (เพิ่มเติม) - ระบบแรงค์ (Rank) 📚
                        <br>
                        📌 เปิดตัวเว็บไซต์ http://community.jubchairoom.net/ <br>
                        📌 การเติมเงินอาจใช้เวลา 0 - 1 ชั่วโมงในช่วงเวลาทำการ (09.00 - 23.00 น.) หากช้าเกินกว่ากำหนดโปรดแจ้งแอดมินเพื่อดำเนินการตรวจสอบและแก้ไข<br>
                        📌 เพิ่มคำสั่ง (/rankup) เพื่อดูความสามารถแต่ละยศ<br>
                        📌 เพิ่มยศ Villager+, Pillager, Pillager+, Evoker และ Leader<br>
                        📌 ยศ Villager+, Pillager และ Pillager+ สามารถซื้อได้ (ถาวร)<br>
                        📌 ยศ Evoker จะเป็นรูปแบบเช่าโดยที่จะเช่าได้ต้องเป็นยศ Pillager+ ก่อน โดยการเช่าจะเช่าได้ครั้งละ 30 วัน<br>
                        📌 ยศ Leader คือยศที่ได้รับการแต่งตั้งจากผู้เล่นภายในเซิฟเวอร์หรือแอดมินตามสถานการณ์และจะเปลี่ยน Leader คนใหม่ทุกซีซั่น<br>
                        <br>
                        ทางทีมงานขอสงวนสิทธิ์ในการเปลี่ยนแปลงความสามารถของยศหรือราคาโดยไม่จำเป็นต้องแจ้งให้ทราบล่วงหน้า 
                        </p>
                    </div>

                    <div id="Patch1.4" class="w3-container city" style="display:none">
                        <h2>แพทซ์ 1.4 | อัปเดตถ้ำ (Updates Cave)</h2>
                        <p>รายละเอียดการอัปเดตแพทซ์ 1.4<br>
<br>
                        📌   สิ่งที่เพิ่มเข้ามาใหม่ 💫<br>
                        🔶 อัปเดตเซิฟเวอร์สู่มายคราฟเวอร์ชั่น 1.17<br>
                        🔶  เปิดโลกสร้างบ้านใหม่ (1.17 + ถ้ำ)<br>
                        🔶 เปิดโลกมังกร โดยสามารถเข้าได้ผ่าน NPC ข้างร้านกล่องสุ่ม<br>
                        🔶 เพิ่มระบบสกิล (ประกาศอย่างเป็นทางการ)<br>
                        🔶 เพิ่มร้านค้า Chat Color (Villager+ ขึ้นไปเท่านั้น)<br>
                        🔶 ยศ Pillager+ ขึ้นไปสามาถตั้งฉายาแบบกำหนดเองได้<br>
                        🔶 เพิ่มกล่องสุ่มทอง รูบี้ และ เทพ<br>
                        🔶 เพิ่มคำสั่ง /use เพื่อเปิดใช้ไอเท็มพิเศษต่างๆ<br>
                        🔶 เพิ่มไอเท็มพิเศษ Double XP<br>
                        🔶 เพิ่มระบบ Challenge เพื่อท้าทายชิงเงินรางวัล<br>
                        📌 สิ่งที่มีการแก้ไข 💫<br>
                        🔶 ประตูวาปโลกสร้างบ้านจะวาปไปยังโลกสร้างบ้านใหม่ (1.17)<br>
                        🔶 โลกสร้างบ้านเก่า (1.16.5) ยังคงมีอยู่เหมือนเดิมแต่ต้องใช้คำสั่งเฉพาะเพื่อไปเท่านั้นเช่น /tpa, /home<br>
                        🔶 รีเซ็ตโลกนรก<br>
                        🔶 กล่อง Wooden Crate และ กล่อง Silver Crate ได้เปลี่ยนรางวัลใหม่<br>
                        🔶 กุญแจม่วงไม่สามารถซื้อได้จากร้านขายของ แต่สามารถซื้อได้ผ่านเว็บ community.jubchairoom.net เท่านั้น<br>
                        🔶 สามารถตรวจเช็คสินค้าที่สามารถขายได้ในร้านค้าโดยเปิดเมนูขายแล้วกดที่ ดูรายการที่สามารถขายได้<br>
                        🔶 ไอเท็มออนไลน์ตอนนี้อยู่ในช่วงคัดสรรไอเท็ม โปรดรอสักครู่...<br>
                        <br>
                        📌  สิ่งที่มีการนำออกไป 💫<br>
                        🔶 คำสั่ง /ride<br>
                        <br>
                        📌 เว็บไซต์ community.jubchairoom.net 💫<br>
                        🔶 เพิ่มสินค้า Double XP ในราคา 50 พอยท์<br>
                        🔶 เพิ่มสินคา กุญแจม่วง ในราคา 20 พอยท์<br>
                        <br>
                        📣📣 เพิ่มเติม<br>
                        ทางเราขออนุญาตงดจับเวลายศ Evoker ชั่วคราว. (ยังไม่มีการนับวัน 30 วัน)<br>
                        <br>
                        ** หากผู้เล่นพบบัค สามารถแจ้งบัคมาได้ที่ #⚡แจ้งบัค ได้เลยครับ<br>
                        <br>
                        @Jubchai Admin <br>
                        18 / 06 / 2021
                        </p>
                    </div>

                    <div id="Patch1.5" class="w3-container city">
                        <h2>แพทซ์ 1.5 | บทเรียนแห่งความรัก (Love Lesson Update)</h2>
                        <p>📌 ประกาศรายละเอียดการอัปเดตแพทซ์ 1.5 | บทเรียนแห่งความรัก (Love Lesson Update) 💘
                            <br>
                            ⭐ เพิ่มระบบคบ<br>
                            ⭐ เพิ่มระบบแต่งงาน<br>
                            ⭐ เพิ่มสถานที่โบสถ์บริเวณ Spawn<br>
                            <br>
                            🎲 แพทซ์ 1.5 จะอัปเดตเข้ามาในคืนวันที่ : 26 มิถุนายน 2564<br>
                            <br>
                            💗 ระบบคบ 💗<br>
                            <br>
                            ✏️ ผู้เล่นสามารถใช้คำสั่ง /คบ to <ชื่อผู้เล่น> เพื่อทำการขอคบได้<br>
                                ✏️ เมื่อมีการคบกันเกิดขึ้นระบบจะไม่ประกาศว่าใครกำลังคบกับใคร<br>
                                ✏️ เมื่อคบกันอยู่สามารถพิมพ์แชทส่วนตัวกันได้โดยพิมพ์ # ไว้ด้านหน้าข้อความ เช่น
                                #รักนะ<br>
                                ✏️ หากต้องการเลิกคบสามารถใช้คำสั่ง /คบ divorce ได้เลย<br>
                                <br>
                                💖 ระบบแต่งงาน 💖<br>
                                <br>
                                ✏️ ผู้เล่นสามารถแต่งงานกันได้ที่โบสถ์เท่านั้น (พาคนที่อยากแต่งงานไปในโบสถ์)<br>
                                ✏️ การแต่งงาน ฝ่ายขอจำเป็นจะต้องมีเงิน Jc ในตัวอย่างต่ำ 10,000 Jc<br>
                                ✏️ เมื่อการขอแต่งงานสำเร็จเงินจะถูกหักออกจากฝ่ายขอ 5,000 Jc โดยที่<br>
                                - 3,000 Jc จะถูกโอนไปให้ฝ่ายถูกขอแต่งงาน<br>
                                - 2,000 Jc จะถูกหักค่าบริการ (เซิฟเวอร์แดก)<br>
                                ✏️ เมื่อคบกันแล้วสามารถใช้คำสั่ง /marry เพื่อ
                                เพื่อดูรายละเอียดและความสามารถเพิ่มเติมหลังจากแต่งงานได้<br>
                                <br>
                                @Jubchai Admin<br>
                                24 / 06 / 2021
                        </p>
                    </div>

                    <div id="Patch1.6" class="w3-container city">
                        <h2>แพทซ์ 1.6 | ไม่สปอยหรอก แบร่ (No Spoilers)</h2>
                        <p>
                            อยากรู้ติดตามได้ที่ Discord ได้เลยยยย มีสปอยอยู่นะจ๊ะ<br><br>
                            <a class="btn btn-info" href="http://jubchairoom.net/discord"
                        target="_blank">Discord</a>
                        </p>
                    </div>

                </center>
            </div>
            <div class="modal-footer">
                <img width="100px" style="align-items: center;" src="../img/jccomn.png" alt="logo">
            </div>
        </div>

    </div>

    <script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>

    <script>
    function openPatch(cityName) {
        var i;
        var x = document.getElementsByClassName("city");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        document.getElementById(cityName).style.display = "block";
    }
    </script>




<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background: orange;">
        <h5 class="modal-title" id="staticBackdropLabel">ข้อมูลผู้เล่น</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4>ชื่อในเกม: <span class="badge badge-info text-white" style="background: #037bfc;"><?php echo $row['playername']; ?></span> </h4>
        <h4>ยศของคุณ: <?php 
                    if ($row['rank'] == 'default') {
                    echo '<img src="../img/Rank/Villager.png" width="100px" alt="">';
                    } else if ($row['rank'] == 'villagerplus') {
                    echo '<img src="../img/Rank/Villager+.png" width="100px" alt="">';
                    } else if ($row['rank'] == 'pillager') {
                    echo '<img src="../img/Rank/Pillager.png" width="100px" alt="">';
                    } else if ($row['rank'] == 'pillagerplus') {
                    echo '<img src="../img/Rank/Pillager+.png" width="100px" alt="">';
                    } else if ($row['rank'] == 'evoker') {
                    echo '<img src="../img/Rank/Evoker.png" width="100px" alt="">';
                    } else if ($row['rank'] == 'leader') {
                    echo '<img src="../img/Rank/Leader.png" width="100px" alt="">';
                    } else if ($row['rank'] == 'jubchai_builder') {
                    echo '<img src="../img/Rank/Builder.png" width="100px" alt="">';
                    } else if ($row['rank'] == 'jubchai_member') {
                    echo '<img src="../img/Rank/Staff.png" width="100px" alt="">';
                    } else if ($row['rank'] == 'jubchai_team') {
                    echo '<img src="../img/Rank/Admin.png" width="100px" alt="">';
                    }
                    ?> </h4>
        <h4>พอยท์ของคงเหลือ: <span class="badge badge-info text-white" style="background: #037bfc;"><?php echo $row['point_web']; ?> พอยท์ </h4></span>
        <h4>บัญชีของคุณ: <?php
            if ($row['premium'] == '0') {
            echo '<span class="badge badge-info text-white" style="background: #037bfc;">ไม่เป็นพรีเมี่ยม</span>';
            } else if ($row['premium'] == '1') {
            echo '<span class="badge badge-info text-white" style="background: #037bfc;">เป็นพรีเมี่ยม</span>';
            }
            ?> </h4>
        <h4>เงินในตัวของคุณ: <span class="badge badge-info text-white" style="background: #037bfc;"><?php echo number_format($row['jc'], 2); ?> Jc</span></h4>
        <h4>เงินในธนาคารของคุณ: <span class="badge badge-info text-white" style="background: #037bfc;"><?php echo number_format($row['bank'], 2); ?> Jc</span></h4>
        <br>
        <a href="change_password.php" style="color: white; width: 130px; height: 40px;"
                        class="btn mb-4 btn-success">เปลี่ยนรหัสผ่าน</a>
      </div>
      <div class="modal-footer" style="background: orange;">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


    <script src="../assets/js/script.js"></script>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js "
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4 " crossorigin="anonymous ">
    </script>
    <!-- MDB -->
    <script type="text/javascript " src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.js "></script>

</body>

<script>
function fun_alert() {
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'ออกจากระบบ',
        showConfirmButton: false,
        timer: 2000
    })
}
</script>

</html>

<?php } ?>