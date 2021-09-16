<?php 
    require_once('../connection.php');

    if (isset($_REQUEST['btn_insert'])) {
        $itemid = $_REQUEST['txt_item'];
        $amount = $_REQUEST['txt_am'];
        $droprate = $_REQUEST['txt_dr'];
        $crateid = $_REQUEST['txt_cid'];

        if (empty($itemid)) {
            $errorMsg = "กรอกข้อมูลดิ";
        } else if (empty($amount)){
            $errorMsg = "กรอกข้อมูลดิ";
        } else if (empty($droprate)){
            $errorMsg = "กรอกข้อมูลดิ";
        } else if (empty($crateid)){
            $errorMsg = "กรอกข้อมูลดิ";
        } else {
            try {
                if (!isset($errorMsg)) {
                    $insert_stmt = $db->prepare("INSERT INTO crate (ItemID, Amount, droprate, crateid) 
                                                            VALUES (:iitem, :iam, :idr, :icid)");
                    $insert_stmt->bindParam(':iitem', $itemid);
                    $insert_stmt->bindParam(':iam', $amount);
                    $insert_stmt->bindParam(':idr', $droprate);
                    $insert_stmt->bindParam(':icid', $crateid);

                    if ($insert_stmt->execute()) {
                        $insertMsg = "เรียบร้อยละ";
                        header("location: crate.php");
                    }
                }
            } catch (PDOException $e) {
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
    <title>Add Crate</title>
    <link rel="icon" href="../img/jccom.png">

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

<body>

    <div class="container">
        <div class="display-3 text-center">
            <h1>Add Page</h1>
        </div>
        <div class="display-3 text-center">
            <h3>Add Crate</h3>
        </div>

        <?php 
         if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger">
            <strong>Wrong! <?php echo $errorMsg; ?></strong>
        </div>
        <?php } ?>


        <?php 
         if (isset($insertMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>Success! <?php echo $insertMsg; ?></strong>
        </div>
        <?php } ?>

        <form method="post" class="form-horizontal mt-5">

            <div class="form-group text-center">
                <div class="row">
                    <label for="info" class="col-sm-3 control-label">ItemID</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_item" class="form-control" placeholder="กรอกข้อมูล">
                    </div>
                    <br><br>
                    <label for="info" class="col-sm-3 control-label">Amount</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_am" class="form-control" placeholder="กรอกข้อมูล">
                    </div>
                    <br><br>
                    <label for="info" class="col-sm-3 control-label">Drop Rate</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_dr" class="form-control" placeholder="กรอกข้อมูล">
                    </div>
                    <br><br>
                    <label for="info" class="col-sm-3 control-label">Crate ID</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_cid" class="form-control" placeholder="กรอกข้อมูล">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_insert" class="btn btn-success" value="Insert">
                    <a href="crate.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>


        </form>
    </div>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.js"></script>

</body>

</html>

<?php } ?>