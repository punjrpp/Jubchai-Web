<?php 

    session_start();

    require_once "../connection.php";

    if (isset($_REQUEST['delete_id'])) {
        $id = $_REQUEST['delete_id'];

        $select_stmt = $db->prepare("SELECT * FROM web_purchase_history WHERE id = :id");
        $select_stmt->bindParam(':id', $id);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

        // Delete an original record from db
        $delete_stmt = $db->prepare('DELETE FROM web_purchase_history WHERE id = :id');
        $delete_stmt->bindParam(':id', $id);
        $delete_stmt->execute();

        header('Location:purchase_history.php');
    }

    $select_stmtua = $db->prepare("SELECT * FROM users WHERE UUID = :UUID");
    $select_stmtua->bindParam(':UUID', $_SESSION['uuid']);
    $select_stmtua->execute();
    $rowua = $select_stmtua->fetch(PDO::FETCH_ASSOC);
    extract($rowua);


    $queryr = "SELECT * FROM web_shop_rank";
    $resultr = mysqli_query($conn, $queryr);
    $rowr = mysqli_fetch_array($resultr, MYSQLI_ASSOC);

    $queryi = "SELECT * FROM web_shop_item";
    $resulti = mysqli_query($conn, $queryi);
    $rowi = mysqli_fetch_array($resulti, MYSQLI_ASSOC);


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
    <title>Admin Purchase</title>
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
        <h1>Purchase History Check</h1>
        <a href="index.php" class="btn btn-info">back</a>
        <hr>

        <table id="historyTable" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td>#</td>
                    <td>IGN</td>
                    <td>Product Name</td>
                    <td>Product Code</td>
                    <td>Point Before Buying </td>
                    <td>Price Product</td>
                    <td>Quantity</td>
                    <td>Posting Date</td>
                    <td>Manage</td>
                </tr>
            </thead>

            <tbody>
                <?php 
                    $select_stmt = $db->prepare('SELECT * FROM web_purchase_history'); 
                    $select_stmt->execute();

                    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['playername']; ?></td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['product_code']; ?></td>
                    <td><?php echo $row['point_price']; ?></td>
                    <td>

                        <?php echo $row['product_price']; ?>
                        <?php
                            if ($row['sale'] != 0) {
                                                        
                        ?>
                        <p>(- <?php echo $row['sale']; ?> %)</>
                        <?php } ?>

                    </td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['postingdate']; ?></td>
                    <td><a href="?delete_id=<?php echo $row['id']; ?>" class="badge bg-danger">Delete</a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

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

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#historyTable').DataTable({
                "pageLength": 25,
                "order": [[ 0, 'desc' ]],
                dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
            });
        } );
    </script>
</body>

</html>

<?php } ?>