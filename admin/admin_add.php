<?php 
    require_once('connection.php');

    if (isset($_REQUEST['btn_insert'])) {
        $information = $_REQUEST['txt_info'];

        if (empty($information)) {
            $errorMsg = "Please enter Information";
        } else {
            try {
                if (!isset($errorMsg)) {
                    $insert_stmt = $db->prepare("INSERT INTO announce(information) VALUES (:iname)");
                    $insert_stmt->bindParam(':iname', $information);

                    if ($insert_stmt->execute()) {
                        $insertMsg = "Insert Successfully...";
                        header("refresh:2;admin_page.php");
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

    
    session_start();

    if ($_SESSION['userlevel'] != 'Admin') {
      header ("Location: ../member/page.php");
    } else {

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Page</title>
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

    <link rel="stylesheet" href="bootstrap/bootstrap.css">
</head>
<body>

    <div class="container">
    <div class="display-3 text-center"><h1>Add Page</h1></div>
    <div class="display-3 text-center"><h3>Add Information</h3></div>

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
                    <label for="info" class="col-sm-3 control-label">Information</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_info" class="form-control" placeholder="Enter Information...">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_insert" class="btn btn-success" value="Insert">
                    <a href="admin_page.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>


    </form>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>

<?php } ?>