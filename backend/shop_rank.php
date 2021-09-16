<?php 

  session_start();

  require_once "../connection.php";

  if (isset($_REQUEST['delete_id'])) {
    $id = $_REQUEST['delete_id'];

    $select_stmt = $db->prepare("SELECT * FROM web_shop_rank WHERE id = :id");
    $select_stmt->bindParam(':id', $id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

    // Delete an original record from db
    $delete_stmt = $db->prepare('DELETE FROM web_shop_rank WHERE id = :id');
    $delete_stmt->bindParam(':id', $id);
    $delete_stmt->execute();

    header('Location:shop_rank.php');
}

  if (isset($_REQUEST['btn_shop'])) {
    try {
        $name = $_REQUEST['txt_name'];
        $name_code = $_REQUEST['txt_namecode'];
        $price = $_REQUEST['txt_price'];
        $sale = $_REQUEST['txt_sale'];

        $image_file = $_FILES['txt_file']['name'];
        $type = $_FILES['txt_file']['type'];
        $size = $_FILES['txt_file']['size'];
        $temp = $_FILES['txt_file']['tmp_name'];

        $path = "upload_rank/" . $image_file;

        if (empty($name)) {
            $errorMsg = "อะไรของมึง มึงก็ใส่ชื่อสินค้าดิเห้ย";
        } else if (empty($price)) {
            $errorMsg = "แล้วมึงเป็นเหี้ยไรไม่ใส่ราคาเค้าจะรู้มั้ย";
        } else if (empty($image_file)) {
            $errorMsg = "มึงอย่าเอ๋อดิใส่ logo ด้วย";
        } else if ($type == "image/jpg" || $type == 'image/jpeg' || $type == "image/png" || $type == "image/gif") {
            if (!file_exists($path)) {
                if ($size < 5000000) {
                    move_uploaded_file($temp, 'upload_rank/'.$image_file);
                } else {
                    $errorMsg = "กูก็บอกไปแล้วนะว่า ไฟล์อย่าเกิน 5 MB";
                }
            } else {
                $errorMsg = "รูปนี้มึงเคยใส่ไปแล้ว";
            }
        } else {
            $errorMsg = "มึงอย่าใช้ไฟล์อื่นดิหน้าเหี้ย JPG, JPEG, PNG และ GIF";
        }
        if (!isset($errorMsg)) {

            $insert_stmt = $db->prepare('INSERT INTO web_shop_rank (logo_image, product_name, product_code, price, sale) 
                                        VALUES (:flogo_image, :fproduct_name, :fproduct_code, :fprice, :fsale)');
            $insert_stmt->bindParam(':flogo_image', $image_file);
            $insert_stmt->bindParam(':fproduct_name', $name);
            $insert_stmt->bindParam(':fproduct_code', $name_code);
            $insert_stmt->bindParam(':fprice', $price);
            $insert_stmt->bindParam(':fsale', $sale);

            if ($insert_stmt->execute()) {
                $insertMsg = "เพิ่มร้านแล้วไอ่หน้าหนังหมา";
                header("refresh:2;shop_rank.php");
            }
        }

    } catch(PDOException $e) {
        $e->getMessage();
    }
}


$select_stmtua = $db->prepare("SELECT * FROM users WHERE UUID = :UUID");
$select_stmtua->bindParam(':UUID', $_SESSION['uuid']);
$select_stmtua->execute();
$rowua = $select_stmtua->fetch(PDO::FETCH_ASSOC);
extract($rowua);


if ($rank != 'jubchai_team') {
    header ("Location: ../member");
    exit();
  } else {

    if ($_SESSION != NULL) {
        $query = "SELECT * FROM users WHERE playername = '".$_SESSION['playername']."' ";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Shop</title>
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

                        <br><br><br><br>
                        <a href="index.php" class="btn btn-info">back</a>
                        <hr>
                        <div class="container text-center">
                        <form action="" method="post" class="form-horizontal backend-" enctype="multipart/form-data">
                        <h2>สร้างร้าน</h2>
                        <br><br>
                            <?php 
                                if(isset($errorMsg)) {

                            ?>
                            <div class="alert alert-danger">
                                <strong><?php echo $errorMsg; ?></strong>
                            </div>
                            <?php } ?>

                            <?php 
                                if(isset($insertMsg)) {

                            ?>
                            <div class="alert alert-success">
                                <strong><?php echo $insertMsg; ?></strong>
                            </div>
                            <?php } ?>


                            <div class="form-payment">
                                <div class="row">
                                    <label for="name" class="col-sm-3 control-label" class="ign">ชื่อสินค้า</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="txt_name" class="form-control" placeholder="ใส่ชื่อดิวะ">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-payment">
                                <div class="row">
                                    <label for="name" class="col-sm-3 control-label" class="ign">รหัสสินค้า</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="txt_namecode" class="form-control" placeholder="ใส่ชื่อดิวะ">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-payment">
                                <div class="row">
                                    <label for="name" class="col-sm-3 control-label">ราคาสินค้า</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="txt_price" class="form-control" placeholder="ใส่ราคาดิเห้ย">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-payment">
                                <div class="row">
                                    <label for="name" class="col-sm-3 control-label">ส่วนลด</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="txt_sale" class="form-control" placeholder="ใส่ส่วนลดดิเห้ย">
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
                                    <input type="submit" name="btn_shop" class="btn btn-success" value="create">
                                    <input class="btn btn-danger" type="reset" value="รีเซต">
                                </div>
                            </div>
                        </form>
                    </div>


                    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><hr>

                    <?php 
                $select_stmt = $db->prepare("SELECT * FROM web_shop_rank");
                $select_stmt->execute();

                while ($pd = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="main">
                    <div class="img-shop">
                        <img src="upload_rank/<?php echo $pd["logo_image"] ?>" alt="rank" class="logo-rank">

                    </div>
                    <div class="content">
                        <h1><?php echo $pd["product_name"] ?></h1>
                        <p><?php echo "ราคา: " .$pd["price"]. " พอยท์" ?></p>
                        <a href="member/buy.php" name="btn_buy" class="btn btn-success mb-3">ซื้อ</a>
                    </div>
                    <div class="footer">
                        <div class="ft-l">
                        <a href="rank_shop_edit.php?update_id=<?php echo $pd['id']; ?>" class="badge bg-warning">Edit</a> &nbsp;&nbsp;
                        <a href="?delete_id=<?php echo $pd['id']; ?>" class="badge bg-danger">Delete</a>
                        </div>
                    </div>
                </div>
                <?php } ?>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.js"></script>
</body>

</html>

<?php } ?>