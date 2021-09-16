<?php 
    require_once('../connection.php');

    if (isset($_REQUEST['update_id'])) {
        try {
            $id = $_REQUEST['update_id'];
            $select_stmt = $db->prepare("SELECT * FROM announcement WHERE id = :id");
            $select_stmt->bindParam(':id', $id);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    if (isset($_REQUEST['btn_update'])) {
        $ann_up = $_REQUEST['txt_ann'];
        $type_up = $_REQUEST['txt_type'];

        if (empty($ann_up)) {
            $errorMsg = "กรอกข้อมูลซะ";
        } else if (empty($type_up)) {
            $errorMsg = "กรอกข้อมูลซะ";
        } else {
            try {
                if (!isset($errorMsg)) {
                    $update_stmt = $db->prepare("UPDATE announcement SET announcement = :iann_up, type = :itype_up WHERE id = :id");
                    $update_stmt->bindParam(':iann_up', $ann_up);
                    $update_stmt->bindParam(':itype_up', $type_up);
                    $update_stmt->bindParam(':id', $id);

                    if ($update_stmt->execute()) {
                        $updateMsg = "เรียบร้อยละ";
                        header("refresh:2;announce.php");
                    }
                }
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }


    session_start();

    $select_stmtua = $db->prepare("SELECT * FROM users WHERE UUID = :UUID");
    $select_stmtua->bindParam(':UUID', $_SESSION['uuid']);
    $select_stmtua->execute();
    $rowua = $select_stmtua->fetch(PDO::FETCH_ASSOC);
    extract($rowua);

    if ($rank != 'jubchai_team') {
        header ("Location: ../member");
        exit();
      } else {

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Page</title>
    <link rel="icon" href="../img/jccom.png">
    <link rel="stylesheet" href="../assets/css/style.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

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
    <div class="display-3 text-center"><h3>Edit Announcement</h3></div>

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
            
    <div class="form-group text-center">
                <div class="row">
                    <label for="info" class="col-sm-3 control-label">Announcement</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_ann" class="form-control" value="<?php echo $announcement;?>">
                    </div>
                    <br><br>
                    <label for="info" class="col-sm-3 control-label">Type</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_type" class="form-control" value="<?php echo $type;?>">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_update" class="btn btn-success" value="Update">
                    <a href="announce.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>


    </form>
    </div>

  <!-- MDB -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.js"></script>
    
</body>
</html>

<?php } ?>