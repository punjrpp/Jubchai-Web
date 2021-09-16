<?php 

    session_start();

    require_once "../connection.php";

    if (isset($_REQUEST['delete_id'])) {
        $id = $_REQUEST['delete_id'];

        $select_stmt = $db->prepare("SELECT * FROM web_topup WHERE id = :id");
        $select_stmt->bindParam(':id', $id);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

        // Delete an original record from db
        $delete_stmt = $db->prepare('DELETE FROM web_topup WHERE id = :id');
        $delete_stmt->bindParam(':id', $id);
        $delete_stmt->execute();

        header('Location:topup.php');
    }




    if (isset($_REQUEST['confirm_id'])) {
        try {
            $id = $_REQUEST['confirm_id'];

            $select_stmt = $db->prepare("SELECT * FROM web_topup WHERE id = :id");
            $select_stmt->bindParam(':id', $id);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);

        } catch(PDOException $e) {
            $e->getMessage();
        }


        if ($row['status'] == 'success') {
            $errorMsg = "มึงจะกดทำไมหลายรอบ";
        } else {
            try {
                $status_up = "success";

                if (!isset($errorMsg)) {
                    $update_stmts = $db->prepare("UPDATE web_topup SET status = :istatus_up WHERE id = :id");
                    $update_stmts->bindParam(':istatus_up', $status_up);
                    $update_stmts->bindParam(':id', $id);

                    if ($update_stmts->execute()) {
                        $updateMsg = "อัพเดตข้อมูลให้แล้วไอ่สัสนรก...";
                        header("refresh:3;index.php");
                    }
                }

            } catch(PDOException $e) {
                $e->getMessage();
            }
        }

        try {
            $select_stmtr = $db->prepare("SELECT * FROM users WHERE playername = :playername");
            $select_stmtr->bindParam(':playername', $row['playername']);
            $select_stmtr->execute();
            $rowr = $select_stmtr->fetch(PDO::FETCH_ASSOC);
            extract($rowr);
        } catch(PDOException $e) {
            $e->getMessage();
        }

        $realpoints = $row['amount'] + $rowr['point_web'];

        if ($row['status'] == 'success') {
            $errorMsg = "มึงจะกดทำไมหลายรอบ";
        } else {
            try {
                if (!isset($errorMsg)) {
                    $update_stmtp = $db->prepare("UPDATE users SET point_web = :ipoint_up WHERE UUID = :UUID");
                    $update_stmtp->bindParam(':ipoint_up', $realpoints);
                    $update_stmtp->bindParam(':UUID', $UUID);

                    if ($update_stmtp->execute()) {
                        $updateMsg = "อัพเดตพ้อยให้แล้วไอ่ชิงหมาเกิด..";
                        header("refresh:3;index.php");
                    }
                }
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
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
    <title>Admin Topup</title>
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

    <div class="container text-center">
        <h1>Topup Check</h1>
        <a href="index.php" class="btn btn-info">back</a>
                        <hr>

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

        <table id="topupTable" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td>#</td>
                    <td>IGN</td>
                    <td>Channel Payment</td>
                    <td>Times</td>
                    <td>Amount</td>
                    <td>img Payment</td>
                    <td>Status</td>
                    <td>Manage</td>
                </tr>
            </thead>

            <tbody>
                <?php 
                    $select_stmt = $db->prepare('SELECT * FROM web_topup'); 
                    $select_stmt->execute();

                    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {

                        $queryrp = "SELECT * FROM users WHERE playername = '".$row['playername']."'";
                        $resultrp = mysqli_query($conn, $queryrp);
                        $rowrp = mysqli_fetch_array($resultrp, MYSQLI_ASSOC);
    
                        $realpoint = $row['amount'] + $rowrp['point_web'];

                ?>
                <tr>
                    <td class="ign_id"><?php echo $row['id']; ?></td>
                    <td><?php echo $row['playername']; ?></td>
                    <td><?php echo $row['paymentch']; ?></td>
                    <td><?php echo $row['time']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><img src="upload_topup/<?php echo $row['image']; ?>" width="100px" height="100px" alt=""></td>
                    <td><?php
                            if ($row['status'] == 'in_progress') {
                            echo '<p style="color: #eeff57">กำลังดำเนินการ</p>';
                            } else if ($row['status'] == 'success') {
                            echo '<p style="color: green">ทำรายการสำเร็จ</p>';
                            } else if ($row['status'] == 'cancel') {
                            echo '<p style="color: red">ยกเลิกรายการ</p>';
                            }
                            ?></td>
                    <td><!-- <a href="#" class="badge bg-warning edit_btn">Edit N</a> --> <a href="?confirm_id=<?php echo $row['id']; ?>" name="btn_confirm" class="badge bg-success">Confirm</a> <a href="topup_edit.php?update_id=<?php echo $row['id']; ?>" class="badge bg-warning">Edit</a>  <a href="?delete_id=<?php echo $row['id']; ?>" class="badge bg-danger">Delete</a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <hr>
        <a href="index.php" class="btn btn-info">back</a>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#topupTable').DataTable({
                "pageLength": 25,
                "order": [[ 0, 'asc' ]],
                dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
            });
        } );
    </script>

    <!-- Popup -->

<!--     <script>

/*         $(document).ready(function () {
            
            $('.edit_btn').click(function (e) { 
                e.preventDefault();

                var ign_id = $(this).closest('tr').find('.ign_id').text();
                // console.log(ign_id);

                $.ajax({
                    type: "POST",
                    url: "topup_popup.php",
                    data: {
                        'checking_editbtn': true,
                        'ignp_id': ign_id,
                    },
                    success: function (response) {
                        console.log(response);
                        $('.ign_viewing_data').html(response);
                        $('#IGNedit').modal('show');
                    }
                });
                
            });

        }); */

    </script> -->

</body>

</html>

<?php } ?>