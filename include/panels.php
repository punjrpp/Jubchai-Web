<?php 
    require_once('../connection.php');

    if (isset($_REQUEST['delete_id'])) {
        $id = $_REQUEST['delete_id'];

        $select_stmt = $db->prepare("SELECT * FROM announce WHERE id = :id");
        $select_stmt->bindParam(':id', $id);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

        // Delete an original record from db
        $delete_stmt = $db->prepare('DELETE FROM announce WHERE id = :id');
        $delete_stmt->bindParam(':id', $id);
        $delete_stmt->execute();

        header('Location:page.php');
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="icon" href="../img/jccom.png">

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>


<body>

    <!-- Panal Slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- Panal 00 -->
                <div class="panel panel-primary" style="
              border-top-left-radius: 20px;
              border-bottom-left-radius: 20px;
              border-top-right-radius: 20px;
              border-bottom-right-radius: 20px;">
                    <div class="panel-body" style="padding: 0px;">
                        <?php include_once (__DIR__).('/slider.php') ?>
                    </div>
                </div>

                <!-- End Panal 00 -->

                <!-- Panal Left-->
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8">

                            <!-- Panal 01 -->
                            <div class="panel panel-primary"> 
                                <div class="panel-heading uil uil-megaphone"> ประกาศจากทางเซิฟเวอร์</div>
                                <div class="panel-body"> <!-- endpn1 -->
                                    <?php 
                $select_stmt = $db->prepare("SELECT * FROM announce");
                $select_stmt->execute();

                while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>


                    
                    <h5><span class="label label-danger">New</span> <?php echo $row["information"]; ?></h5>


            <?php } ?>
                                </div> <!-- pn1 -->
                            </div><!-- pn1 -->

                            <!-- End Panal 01 -->

                            <!-- Panal 02 -->
                            <div class="panel panel-primary">
                                <div class="panel-heading uil uil-video"> Video Preview</div>
                                <div class="panel-body" style="padding: 0px;">
                                <iframe width="748" height="420" src="https://www.youtube.com/embed/ydnc3jL0Ybw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            </div>

                            <!-- End Panal 02 -->

                        </div>
                        <!-- Panal Right 03 -->

                        <div class="col-sm-4">

                            <div class="panel panel-primary">
                                <div class="panel-heading uil uil-user"> ข้อมูลผู้เล่น</div>
                                <div class="panel-body" style="padding: 0px;">
<br>
                                    <center><img src="https://minotar.net/helm/<?php echo $_SESSION['user']; ?>/70.png" alt="headsplayer"></center>

                                    <li><a href="" class="h-shake col-md-3 btn btn-success text-white">ชื่อผู้ใช้</a>
                                        <input type="text" class="h-shake col-md-7 btn-line-b text-white "
                                            value="<?php echo $_SESSION['user']; ?>" disabled="">
                                    </li>
<br>
                                    <li><a href="" class="h-shake col-md-3 btn btn-success text-white">ยศของคุณ</a>
                                        <input type="text" class="h-shake col-md-7 btn-line-b text-white "
                                            value="<?php echo $_SESSION['userlevel']; ?>" disabled="">
                                    </li>

<br>
                                    <li><a href="../logout.php"
                                            class="h-shake col-md-12 btn btn-danger text-white">ออกจากระบบ</a>
                                    </li>
<br>
<br>
                                </div>
                            </div>

                            <!-- End Panal 03 -->

                            <!-- Panal 04 -->
                            
                                
                                <div class="panel-body" style="padding: 0px;">
                                <iframe width="358px" src="https://discord.com/widget?id=831919906924134431&theme=dark" width="350" height="500" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
                                </div>
                            

                            <!-- End Panal 04 -->

                        </div>
                    </div>
                </div>

</body>

</html>