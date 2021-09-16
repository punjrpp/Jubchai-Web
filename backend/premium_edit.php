<?php 
    require_once('../connection.php');

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
        $premium_up = $_REQUEST['txt_premium'];

        if (empty($premium_up)) {
            $errorMsg = "กรอกข้อมูลดิเห้ย";
        } else {
            try {
                if (!isset($errorMsg)) {
                    $update_stmt = $db->prepare("UPDATE users SET premium = :ipremium_up WHERE UUID = :UUID");
                    $update_stmt->bindParam(':ipremium_up', $premium_up);
                    $update_stmt->bindParam(':UUID', $UUID);

                    if ($update_stmt->execute()) {
                        $updateMsg = "อัพเดต Premium ให้แล้วไอ่ชิงหมาเกิด";
                        header("refresh:3;index.php");
                    }
                }
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }


    session_start();

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
    <title>Admin Premium</title>
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
    <div class="display-3 text-center"><h3>Edit Premium</h3></div>

    <?php 
         if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger">
            <strong>สัส! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>
    

    <?php 
         if (isset($updateMsg)) {
    ?>
        <div class="alert alert-success">
            <strong><?php echo $updateMsg; ?></strong>
        </div>
    <?php } ?>

    <form method="post" class="form-horizontal mt-5">
            
            <div class="form-group text-center">
                <div class="row">
                    <label for="info" class="col-sm-3 control-label">Premium</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_premium" class="form-control" value="<?php echo $premium; ?>">
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