<?php 
    require_once('../connection.php');

    if (isset($_REQUEST['update_id'])) {
        try {
            $id = $_REQUEST['update_id'];
            $select_stmt = $db->prepare("SELECT * FROM web_shop_rank WHERE id = :id");
            $select_stmt->bindParam(':id', $id);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }


    
    if (isset($_REQUEST['btn_update'])) {
    
        try {
            $r_name = $_REQUEST['txt_name'];
            $r_code = $_REQUEST['txt_namecode'];
            $r_price = $_REQUEST['txt_price'];
            $r_sale = $_REQUEST['txt_sale'];

            $image_file = $_FILES['txt_file']['name'];
            $type = $_FILES['txt_file']['type'];
            $size = $_FILES['txt_file']['size'];
            $temp = $_FILES['txt_file']['tmp_name'];

            $path = "upload_rank/".$image_file;
            $directory = "upload_rank/"; 

            if ($image_file) {
                if ($type == "image/jpg" || $type == 'image/jpeg' || $type == "image/png" || $type == "image/gif") {
                    if (!file_exists($path)) {
                        if ($size < 5000000) {
                            unlink($directory.$row['logo_image']);
                            move_uploaded_file($temp, 'upload_rank/'.$image_file);
                        } else {
                            $errorMsg = "ไฟล์มันใหญ่เกิน 5 MB ไอ่ควาย";
                        }
                    } else {
                        $errorMsg = "มันมีไฟล์นี้แล้วไอ่ชาติหมา";
                    }
                } else {
                    $errorMsg = "มึงอย่าใช้ไฟล์อื่นดิหน้าเหี้ย JPG, JPEG, PNG และ GIF";
                }
            } else {
                $image_file = $row['logo_image'];
            }

            if(!isset($errorMsg)) {
                $update_stmt = $db->prepare("UPDATE web_shop_rank SET logo_image = :file_up, product_name = :pd_name_up, product_code = :pd_code_up, price = :price_up, sale = :sale_up WHERE id = :id");
                $update_stmt->bindParam(':file_up', $image_file);
                $update_stmt->bindParam(':pd_name_up', $r_name);
                $update_stmt->bindParam(':pd_code_up', $r_code);
                $update_stmt->bindParam(':price_up', $r_price);
                $update_stmt->bindParam(':sale_up', $r_sale);
                $update_stmt->bindParam(':id', $id);

                if($update_stmt->execute()) {
                    $updateMsg = "แก้ไขเรียบแล้วร้อยแล้วไอ่สัส";
                    header("refresh:2;shop_rank.php");
                }
            }

                } catch(PDOException $e) {
                    echo $e->getMessage();
                }



        try {
            $r_price = $_REQUEST['txt_price'];
            $name = $_REQUEST['txt_name'];

            if (empty($r_price)) {
                $errorMsg = "กรอกราคาซะ";
            } else 

            if(!isset($errorMsg)) {
                $update_stmt = $db->prepare("UPDATE rank_price SET rank_price = :rprice WHERE rank_code = :rcode");
                $update_stmt->bindParam(':rprice', $r_price);
                $update_stmt->bindParam(':rcode', $product_code);

                if($update_stmt->execute()) {
                    $updateMsg = "แก้ไขเรียบแล้วร้อยแล้วไอ่สัส";
                    header("refresh:2;shop_rank.php");
                }
            }

                } catch(PDOException $e) {
                    echo $e->getMessage();
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
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
        <div class="display-3 text-center">
            <h1>Edit Page</h1>
        </div>
        <div class="display-3 text-center">
            <h3>Edit Item</h3>
        </div>
        <a href="shop_rank.php" class="btn btn-info">back</a>
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

        <form action="" method="post" class="form-horizontal backend-" enctype="multipart/form-data">
            <h2>แก้ไขร้าน</h2>
            <br><br>
            <div class="form-payment">
                <div class="row">
                    <label for="name" class="col-sm-3 control-label" class="ign">ชื่อสินค้า</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_name" class="form-control" value="<?php echo $product_name; ?>">
                    </div>
                </div>
            </div>
            <br>
            <div class="form-payment">
                <div class="row">
                    <label for="name" class="col-sm-3 control-label" class="ign">รหัสสินค้า</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_namecode" class="form-control" value="<?php echo $product_code; ?>">
                    </div>
                </div>
            </div>
            <br>
            <div class="form-payment">
                <div class="row">
                    <label for="name" class="col-sm-3 control-label">ราคาสินค้า</label>
                    <div class="col-sm-9">
                        <input type="number" name="txt_price" class="form-control" value="<?php echo $price; ?>">
                    </div>
                </div>
            </div>
            <br>
            <div class="form-payment">
                <div class="row">
                    <label for="name" class="col-sm-3 control-label">ส่วนลด</label>
                    <div class="col-sm-9">
                        <input type="number" name="txt_sale" class="form-control" value="<?php echo $sale; ?>">
                    </div>
                </div>
            </div>
            <br>
            <div class="form-payment">
                <div class="row">
                    <label for="name" class="col-sm-3 control-label">แนบ LOGO</label>
                    <div class="col-sm-9">
                        <input type="file" name="txt_file" class="form-control">
                    </div>
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="submit" name="btn_update" class="btn btn-warning" value="แก้ไข">
                    <input class="btn btn-danger" type="reset" value="รีเซต">
                </div>
            </div>
        </form>
    </div>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.js"></script>
</body>

</html>

<?php } ?>