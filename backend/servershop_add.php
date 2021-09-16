<?php 
    require_once('../connection.php');

    if (isset($_REQUEST['btn_insert'])) {
        $itemid = $_REQUEST['txt_item'];
        $buy = $_REQUEST['txt_buy'];
        $sell = $_REQUEST['txt_sell'];
        $shop = $_REQUEST['txt_shop'];
        $dn = $_REQUEST['txt_dn'];

        if (empty($itemid)) {
            $errorMsg = "กรอกข้อมูลดิ";
        } else if (empty($buy)){
            $errorMsg = "กรอกข้อมูลดิ";
        } else if (empty($sell)){
            $errorMsg = "กรอกข้อมูลดิ";
        } else if (empty($shop)){
            $errorMsg = "กรอกข้อมูลดิ";
        } else if (empty($dn)){
            $errorMsg = "กรอกข้อมูลดิ";
        } else {
            try {
                if (!isset($errorMsg)) {
                    $insert_stmt = $db->prepare("INSERT INTO shop (ItemID, buy, sell, shop, displayname) 
                                                            VALUES (:iitem, :ibuy, :isell, :ishop, :idn)");
                    $insert_stmt->bindParam(':iitem', $itemid);
                    $insert_stmt->bindParam(':ibuy', $buy);
                    $insert_stmt->bindParam(':isell', $sell);
                    $insert_stmt->bindParam(':ishop', $shop);
                    $insert_stmt->bindParam(':idn', $dn);

                    if ($insert_stmt->execute()) {
                        $insertMsg = "เรียบร้อยละ";
                        header("location: servershop.php");
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
    <title>Add Server Shop</title>
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
            <h3>Add Server Shop</h3>
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
                    <label for="info" class="col-sm-3 control-label">Display Name</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_dn" class="form-control" placeholder="กรอกข้อมูล">
                    </div>
                    <br><br>
                    <label for="info" class="col-sm-3 control-label">buy</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_buy" class="form-control" placeholder="กรอกข้อมูล">
                    </div>
                    <br><br>
                    <label for="info" class="col-sm-3 control-label">sell</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_sell" class="form-control" placeholder="กรอกข้อมูล">
                    </div>
                    <br><br>
                    <label for="info" class="col-sm-3 control-label">shop</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_shop" class="form-control" placeholder="กรอกข้อมูล">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_insert" class="btn btn-success" value="Insert">
                    <a href="servershop.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>


        </form>
    </div>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.js"></script>

</body>

</html>

<?php } ?>