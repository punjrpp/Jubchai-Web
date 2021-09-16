<?php 
    require_once('../connection.php');

    session_start();

    if (isset($_REQUEST['update_id'])) {
        try {
            $UUID = $_REQUEST['update_id'];
            $select_stmt = $db->prepare("SELECT * FROM users WHERE UUID = :UUID");
            $select_stmt->bindParam(':UUID', $UUID);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    if (isset($_REQUEST['btn_update'])) {
        $point_up = $_REQUEST['txt_point'];
        $point_plus = $point_up + $point_web;

        if (empty($point_up)) {
            $errorMsg = "กรอกพอยท์ดิเห้ย";
        } else {
            try {
                if (!isset($errorMsg)) {
                    $update_stmt = $db->prepare("UPDATE users SET point_web = :ipoint_up WHERE UUID = :UUID");
                    $update_stmt->bindParam(':ipoint_up', $point_plus);
                    $update_stmt->bindParam(':UUID', $UUID);

                    if ($update_stmt->execute()) {
                        $updateMsg = "อัพเดตพอยท์ให้แล้วไอ่ชิงหมาเกิด";
                        header("refresh:3;index.php");
                    }
                }
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }


    $select_stmtup = $db->prepare("SELECT * FROM users WHERE playername = :playername");
    $select_stmtup->bindParam(':playername', $_SESSION['playername']);
    $select_stmtup->execute();
    $rowup = $select_stmtup->fetch(PDO::FETCH_ASSOC);


    $select_stmtua = $db->prepare("SELECT * FROM users WHERE UUID = :UUID");
    $select_stmtua->bindParam(':UUID', $UUID);
    $select_stmtua->execute();
    $rowua = $select_stmtua->fetch(PDO::FETCH_ASSOC);
    extract($rowua);


    if ($rowup['rank'] != 'jubchai_team') {
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
    <title>Admin Point</title>
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

<div class="container">
    <div class="display-3 text-center"><h1>Edit Page</h1></div>
    <div class="display-3 text-center"><h3>Edit Point</h3></div>

    <?php 
         if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger">
            <strong>Wrong! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>
    

    <?php 
         if (isset($updateMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>Success! <?php echo $updateMsg; ?></strong>
        </div>
    <?php } ?>

    <form method="post" class="form-horizontal mt-5">

    <h5><?php echo 'UUID: '. $UUID; ?></h5>
    <h5><?php echo 'IGN: '. $playername; ?></h5>
    <h5><?php echo 'พอยท์คงเหลือ: '. $point_web .' พอยท์'; ?></h5> <br>
            
            <div class="form-group text-center">
                <div class="row">
                    <label for="info" class="col-sm-3 control-label">Point</label>
                    <div class="col-sm-9">
                        <input type="number" step="0.01" name="txt_point" class="form-control" value="กรอกจำนวนพอยท์">
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_update" class="btn btn-success" value="Update">
                    <a href="index.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>


    </form>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.js"></script>
</body>

</html>

<?php } ?>