<?php 
    require_once('../connection.php');

    if (isset($_REQUEST['update_id'])) {
        try {
            $id = $_REQUEST['update_id'];
            $select_stmt = $db->prepare("SELECT * FROM cratecategory WHERE id = :id");
            $select_stmt->bindParam(':id', $id);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    if (isset($_REQUEST['btn_update'])) {
        $crateid = $_REQUEST['txt_cid'];
        $key = $_REQUEST['txt_key'];
        $dname = $_REQUEST['txt_dn'];

        if (empty($crateid)) {
            $errorMsg = "กรอกข้อมูลดิ";
        } else if (empty($key)){
            $errorMsg = "กรอกข้อมูลดิ";
        } else if (empty($dname)){
            $errorMsg = "กรอกข้อมูลดิ";
        } else {
            try {
                if (!isset($errorMsg)) {
                    $update_stmt = $db->prepare("UPDATE cratecategory SET crateid = :icid, keyid = :ikey, displayname = :idn WHERE id = :id");
                    $update_stmt->bindParam(':icid', $crateid);
                    $update_stmt->bindParam(':ikey', $key);
                    $update_stmt->bindParam(':idn', $dname);
                    $update_stmt->bindParam(':id', $id);

                    if ($update_stmt->execute()) {
                        $updateMsg = "เรียบร้อยละ";
                        header("refresh:2;cratecategory.php");
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
    <div class="display-3 text-center"><h3>Edit Shop Category</h3></div>

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
                <label for="info" class="col-sm-3 control-label">Crate ID</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_cid" class="form-control" value="<?php echo $crateid;?>">
                    </div>
                    <br><br>
                    <label for="info" class="col-sm-3 control-label">Key</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_key" class="form-control" value="<?php echo $keyid;?>">
                    </div>
                    <br><br>
                    <label for="info" class="col-sm-3 control-label">Display Name</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_dn" class="form-control" value="<?php echo $displayname;?>">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_update" class="btn btn-success" value="Update">
                    <a href="cratecategory.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>


    </form>
    </div>

  <!-- MDB -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.js"></script>
    
</body>
</html>

<?php } ?>