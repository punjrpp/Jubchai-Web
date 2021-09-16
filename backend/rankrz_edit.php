<?php 
    require_once('../connection.php');

    if (isset($_REQUEST['update_id'])) {
        try {
            $pln = $_REQUEST['update_id'];
            $select_stmt = $db->prepare("SELECT * FROM users WHERE playername = :pln");
            $select_stmt->bindParam(':pln', $pln);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    if (isset($_REQUEST['btn_update'])) {
        $rank_up = $_REQUEST['txt_rank'];

        if (empty($rank_up)) {
            $errorMsg = "กรอกยศดิเห้ย";
        } else {
            try {
                if (!isset($errorMsg)) {
                    $update_stmt = $db->prepare("UPDATE users SET rank = :irank_up WHERE playername = :pln");
                    $update_stmt->bindParam(':irank_up', $rank_up);
                    $update_stmt->bindParam(':pln', $pln);

                    if ($update_stmt->execute()) {
                        $updateMsg = "อัพเดตยศให้แล้วไอ่ชิงหมาเกิด";
                        header("refresh:3;index.php");
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


    if ($playername != 'xRandelZ') {
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
    <title>Rank Point</title>
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
    <div class="display-3 text-center"><h3>Edit Rank</h3></div>

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
                    <label for="info" class="col-sm-3 control-label">Rank</label>
                    <div class="col-sm-9">
                    <select id="country" name="txt_rank" class="form-control">
                            <option value="default">Villager</option>
                            <option value="villagerplus">Villager+</option>
                            <option value="pillager">Pillager</option>
                            <option value="pillagerplus">Pillager+</option>
                            <option value="evoker">Evoker</option>
                            <option value="leader">Leader</option>
                            <option value="jubchai_member">Staff</option>
                            <option value="jubchai_builder">Builder</option>
                            <option value="jubchai_team">Admin</option>
                        </select>
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