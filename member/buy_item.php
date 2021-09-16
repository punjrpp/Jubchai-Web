<?php 

    require_once "../connection.php";

    session_start();

    if (isset($_REQUEST['buy_id'])) {
        try {
            $id = $_REQUEST['buy_id'];
            $select_stmt = $db->prepare("SELECT * FROM web_shop_item WHERE id = :id");
            $select_stmt->bindParam(':id', $id);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
        } catch(PDOException $e) {
            $e->getMessage();
        }

        try {
            $select_stmtu = $db->prepare("SELECT * FROM users WHERE playername = :UUID");
            $select_stmtu->bindParam(':UUID', $_SESSION['playername']);
            $select_stmtu->execute();
            $rowu = $select_stmtu->fetch(PDO::FETCH_ASSOC);
            extract($rowu);
        } catch(PDOException $e) {
            $e->getMessage();
        }

        try {
            $select_stmtr = $db->prepare("SELECT * FROM rank_price WHERE rank_code = :rank_code");
            $select_stmtr->bindParam(':rank_code', $rank);
            $select_stmtr->execute();
            $rowr = $select_stmtr->fetch(PDO::FETCH_ASSOC);
            extract($rowr);
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    
    $sale_i = (100-$row['sale']);
    $sale_real_i = $sale_i * $row["price"] / 100;

//q    
    if (isset($_REQUEST['quantity'])) {
        try {
            $qty = $_REQUEST['quantity'];


        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

//end    

    $qtyreal = $qty * $sale_real_i;

    if (isset($_REQUEST['btn_buy'])) {
        try {
            $pl_player = $_REQUEST['txt_buy_nameplayer'];
            $pl_name = $_REQUEST['txt_buy_name'];
            $pl_code = $_REQUEST['txt_buy_code'];
            $point_p = $_REQUEST['txt_ptp'];
    
            if ($qtyreal>$point_p) {
                $errorMsg = "พอยท์ไม่เพียงพอ.";
                header("refresh:0.0001;index.php");
            }
            if (!isset($errorMsg)) {
    
                $insert_stmt = $db->prepare('INSERT INTO product_list (playername, item_name, item_code)
                                            VALUES (:fplayername, :fitem_name, :fitem_code)');
                $insert_stmt->bindParam(':fplayername', $pl_player);
                $insert_stmt->bindParam(':fitem_name', $pl_name);
                $insert_stmt->bindParam(':fitem_code', $pl_code);
    
                if ($insert_stmt->execute()) {
                    $insertMsg = "คุณได้ซื้อ $item_name เรียบร้อยแล้ว";
                    header("refresh:0.0001;index.php");
                }
            }
    
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    if (isset($_REQUEST['btn_buy'])) {
        $point_up = $_REQUEST['txt_point'];
        $point_p = $_REQUEST['txt_ptp'];

        if ($qtyreal>$point_p) {
            $errorMsg = "พอยท์ไม่เพียงพอ.";
            header("refresh:0.0001;index.php");
        } else {
            try {
                if (!isset($errorMsg)) {
                    $update_stmt = $db->prepare("UPDATE users SET point_web = :ipoint_up WHERE playername = :UUID");
                    $update_stmt->bindParam(':ipoint_up', $point_up);
                    $update_stmt->bindParam(':UUID', $playername);

                    if ($update_stmt->execute()) {
                        $updateMsg = "คุณได้ซื้อ $item_name เรียบร้อยแล้ว";
                        header("refresh:0.0001;index.php");
                    }
                }
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

    if (isset($_REQUEST['btn_buy'])) {
        try {
            $playern = $_REQUEST['txt_pln'];
            $productn = $_REQUEST['txt_pdn'];
            $productc = $_REQUEST['txt_pdc'];
            $point_p = $_REQUEST['txt_ptp'];
            $product_p = $_REQUEST['txt_pdp'];
            $product_sale = $_REQUEST['txt_pdsale'];
            $pqty = $_REQUEST['txt_quantity'];
    
            if ($qtyreal>$point_p) {
                $errorMsg = "พอยท์ไม่เพียงพอ.";
                header("refresh:0.0001;index.php");
            } 
            if (!isset($errorMsg)) {
    
                $insert_stmt = $db->prepare('INSERT INTO web_purchase_history (playername, product_name, product_code, point_price, product_price, sale, quantity) 
                                            VALUES (:fplayername, :fproduct_name, :fproduct_code, :fpoint_price, :fproduct_price, :fproduct_sale, :fqty)');
                $insert_stmt->bindParam(':fplayername', $playern);
                $insert_stmt->bindParam(':fproduct_name', $productn);
                $insert_stmt->bindParam(':fproduct_code', $productc);
                $insert_stmt->bindParam(':fpoint_price', $point_p);
                $insert_stmt->bindParam(':fproduct_price', $product_p);
                $insert_stmt->bindParam(':fproduct_sale', $product_sale);
                $insert_stmt->bindParam(':fqty', $pqty);
    
                if ($insert_stmt->execute()) {
                    $insertMsg = "คุณได้ซื้อ $item_name เรียบร้อยแล้ว";
                    header("refresh:0.0001;index.php");
                }
            }
    
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }



    if (isset($_REQUEST['btn_buy'])) {
        try {
            $or_player = $_REQUEST['txt_alp'];
            $or_name = $_REQUEST['txt_aln'];
            $or_code = $_REQUEST['txt_alc'];
            $pqty = $_REQUEST['txt_quantity'];
            $point_p = $_REQUEST['txt_ptp'];
    
            if ($qtyreal>$point_p) {
                $errorMsg = "พอยท์ไม่เพียงพอ.";
                header("refresh:0.0001;index.php");
            } 
            if (!isset($errorMsg)) {
    
                $insert_stmt = $db->prepare('INSERT INTO alert_order (playername, order_name, order_code, quantity)
                                            VALUES (:fplayername, :forder_name, :forder_code, :fqty)');
                $insert_stmt->bindParam(':fplayername', $or_player);
                $insert_stmt->bindParam(':forder_name', $or_name);
                $insert_stmt->bindParam(':forder_code', $or_code);
                $insert_stmt->bindParam(':fqty', $pqty);
    
                if ($insert_stmt->execute()) {
                    $insertMsg = "คุณได้ซื้อ $item_name เรียบร้อยแล้ว";
                    header("refresh:0.0001;index.php");
                }
            }
    
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }


    if (!$_SESSION['playername']) {
        header ("Location: index.php");
        exit();
    } else {

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confrirm Shop</title>
    <link rel="icon" href="../img/jccom.png">
    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.css" rel="stylesheet" />
</head>

<style type="text/css">

body {
    background-color: #1c1c1c;
    -webkit-background-size: cover;
    background-attachment: fixed;
    font-family: Kanit;
}

</style>

<body>

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

    <form action="" method="post" class="form-horizontal shop-buy" enctype="multipart/form-data" >

    <h5 style="margin-left: 1;" class="txt_buy">รายการสั่งซื้อ: <img src="../backend/upload_item/<?php echo $row['item_image']; ?>" width="70px" alt=""> </h5>
    <h5 class="txt_hign">ชื่อในเกม: <?php echo $rowu['playername']; ?> </h5>
    <h5 class="txt_hpointi">พอยท์ของคุณ: <?php echo $rowu['point_web']; ?> </h5>
    <h5 class="txt_hpointi">จำนวนสินค้า: <?php echo $qty ?> </h5>
    <?php
            if ($row['sale'] != 0) {
                            
    ?>
    <h5 class="txt_hpointii">สินค้าลดราคา: <b style="color:red;"><?php echo $row['sale']. " %" ?></b></h5>
    <?php } ?>
    <h5 class="txt_hreal">ราคาที่ต้องชำระ: 
    <?php echo $qtyreal; ?> พอยท์ 
        <?php
            if ($row['sale'] != 0) {
                            
    ?>
    <s style="color: red; font-size: 14.5px;"><?php echo $row['price']; ?> พอยท์</s><?php } ?></h5>
    

    


        <!-- <input class="text-center quantity qty" maxlength="4" size="2" name="quantity" type="number" value='1' min='1'> -->
        <!-- <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">จำนวน</span>
            <input name="quantity" type="number" value='1' min='1' class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
        </div> -->

        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">จำนวน</span>
            <input name="quantity" type="number" value='1' min='1' maxlength="2" class="form-control" placeholder="กรอกจำนวนสินค้า" aria-label="Recipient's username" aria-describedby="button-addon2">
            <button class="btn btn-outline-secondary btn-warning" style="color: black;" type="submit" id="button-addon2">ยืนยัน</button>
        </div>

        <!-- <a href="buy_item.php?buy_id=<?php // echo $it["id"] ?>" name="btn_buy"
            class="btn btn-success mb-3">ซื้อ</a> -->
        <!-- <input type="submit" value='ซื้อ' class="btn btn-success mb-3"> -->

    


            <div class="form-group text-center">
                <div class="row">
                    <label for="info" class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                        <input type="hidden" name="txt_buy_nameplayer" class="form-control"
                            value="<?php echo $playername; ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="row">
                    <label for="info" class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                        <input type="hidden" name="txt_buy_name" class="form-control"
                            value="<?php echo $item_name; ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="row">
                    <label for="info" class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                        <input type="hidden" name="txt_buy_code" class="form-control"
                            value="<?php echo $item_code; ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="row">
                    <label for="info" class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                        <input type="hidden" name="txt_point" class="form-control"
                            value="<?php echo $rowu['point_web'] - $qtyreal; ?>" readonly>
                    </div>
                </div>
            </div>
            <!-- <div class="form-group text-center">
                <div class="row">
                    <label for="info" class="col-sm-3 control-label">จำนวน</label>
                    <div class="col-sm-9">
                        <input type="number" name="txt_count" class="form-control"
                            value="1" min="1">
                    </div>
                </div>
            </div> -->
            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <!-- <input type="submit" name="btn_buy" class="btn btn-success" value="ยืนยันการสั่งซื้อ" 
                    id="myCheck" onclick="alert('กรุณายืนยันอีกครั้ง')"> -->
                    <input type="submit" name="btn_buy" class="btn btn-success" value="ยืนยันการสั่งซื้อ" 
                    onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;">
                    <!-- <button  type="submit" name="btn_buy" class="btn btn-success">ยืนยันการสั่งซื้อ</button> -->
                    <a href="index.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>


            <div class="form-group text-center">
                <div class="row">
                    <label for="info" class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                        <input type="hidden" name="txt_pln" class="form-control"
                            value="<?php echo $rowu['playername']; ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="row">
                    <label for="info" class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                        <input type="hidden" name="txt_pdn" class="form-control"
                            value="<?php echo $row['item_name']; ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="row">
                    <label for="info" class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                        <input type="hidden" name="txt_pdc" class="form-control"
                            value="<?php echo $row['item_code']; ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="row">
                    <label for="info" class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                        <input type="hidden" name="txt_ptp" class="form-control"
                            value="<?php echo $rowu['point_web']; ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="row">
                    <label for="info" class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                        <input type="hidden" name="txt_pdp" class="form-control" value="<?php echo $qtyreal; ?>"
                            readonly>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="row">
                    <label for="info" class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                        <input type="hidden" name="txt_pdsale" class="form-control" value="<?php echo $row['sale']; ?> %"
                            readonly>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="row">
                    <label for="info" class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                        <input type="hidden" name="txt_quantity" class="form-control" value="<?php echo $qty ?> %"
                            readonly>
                    </div>
                </div>
            </div>

            <br>
            <div class="form-group text-center">
                <div class="row">
                    <label for="info" class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                        <input type="hidden" name="txt_alp" class="form-control" value="<?php echo $rowu['playername']; ?>"
                            readonly>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="row">
                    <label for="info" class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                        <input type="hidden" name="txt_aln" class="form-control" value="<?php echo $item_name; ?>"
                            readonly>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="row">
                    <label for="info" class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                        <input type="hidden" name="txt_alc" class="form-control" value="<?php echo $item_code; ?>"
                            readonly>
                    </div>
                </div>
            </div>

                    </form>






    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.js"></script>
</body>

</html>

<script>
function myFunction() {
  document.getElementById("myCheck").click();
}
</script>

<script>

    // var price=document.getElementByClassName('price');
    // var quantity=document.getElementByClassName('quantity');
    // var total=document.getElementByClassName('total');

    // function subTotal() 
    // {
    //     for(i=0;i<price.length;i++)
    //     {
    //         total[i].innerText=(price[i].value)*(quantity[i].value);
    //     }
    // }

    // subTotal();

</script>

<?php } ?>