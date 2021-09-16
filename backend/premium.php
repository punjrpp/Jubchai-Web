<?php 

    session_start();

    require_once "../connection.php";

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
    <title>Admin Premium</title>
    <link rel="icon" href="../img/jccom.png">
    <link rel="stylesheet" href="../assets/css/style.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container text-center">
        <h1>Premium</h1>
        <a href="index.php" class="btn btn-info">back</a>
        <hr>
        <table id="prTable" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td>UUID</td>
                    <td>IGN</td>
                    <td>Premium</td>
                    <td>Manage</td>
            </thead>

            <tbody>
                <?php 
                    $select_stmt = $db->prepare('SELECT * FROM users'); 
                    $select_stmt->execute();

                    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td><?php echo $row['UUID']; ?></td>
                    <td><?php echo $row['playername']; ?></td>
                    <td><?php echo $row['premium']; ?></td>
                    <td><a href="premium_edit.php?update_id=<?php echo $row['UUID']; ?>" class="badge bg-warning">Edit</a></td>
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

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#prTable').DataTable({
                "pageLength": 50,
                "order": [[ 3, 'asc' ]]
            });
        } );
    </script>
</body>

</html>

<?php } ?>