<?php 

    session_start();

    require_once "../connection.php";

    $select_stmtua = $db->prepare("SELECT * FROM users WHERE UUID = :UUID");
    $select_stmtua->bindParam(':UUID', $_SESSION['uuid']);
    $select_stmtua->execute();
    $rowua = $select_stmtua->fetch(PDO::FETCH_ASSOC);
    extract($rowua);


    if ($playername != 'xRandelZ') {
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
    <title>Admin Rank</title>
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
        <h1>Rank Check</h1>
        <a href="index.php" class="btn btn-info">back</a>
        <hr>
        <table id="rankTable" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td>UUID</td>
                    <td>IGN</td>
                    <td>Rank</td>
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
                    <td><?php 
                    if ($row['rank'] == 'default') {
                        echo '<img src="../img/Rank/Villager.png" width="100px" alt="">';
                        } else if ($row['rank'] == 'villagerplus') {
                        echo '<img src="../img/Rank/Villager+.png" width="100px" alt="">';
                        } else if ($row['rank'] == 'pillager') {
                        echo '<img src="../img/Rank/Pillager.png" width="100px" alt="">';
                        } else if ($row['rank'] == 'pillagerplus') {
                        echo '<img src="../img/Rank/Pillager+.png" width="100px" alt="">';
                        } else if ($row['rank'] == 'evoker') {
                        echo '<img src="../img/Rank/Evoker.png" width="100px" alt="">';
                        } else if ($row['rank'] == 'leader') {
                        echo '<img src="../img/Rank/Leader.png" width="100px" alt="">';
                        } else if ($row['rank'] == 'jubchai_builder') {
                        echo '<img src="../img/Rank/Builder.png" width="100px" alt="">';
                        } else if ($row['rank'] == 'jubchai_member') {
                        echo '<img src="../img/Rank/Staff.png" width="100px" alt="">';
                        } else if ($row['rank'] == 'jubchai_team') {
                        echo '<img src="../img/Rank/Admin.png" width="100px" alt="">';
                        }
                        ?></td>
                    <td><a href="rankrz_edit.php?update_id=<?php echo $row['playername']; ?>" class="btn btn-warning">Edit</a></td>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#rankTable').DataTable({
                "pageLength": 50,
                "order": [[ 2, 'desc' ]],
            });
        } );
    </script>
</body>

</html>

<?php } ?>