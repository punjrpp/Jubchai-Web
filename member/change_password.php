<?php

    session_start();

    require_once "../connection.php";

if ($_SESSION == NULL) {
  header("location:index.php");
  exit();
}




$check_submit = "";

$sql = "SELECT playername, password FROM users WHERE playername = '".$_SESSION['playername']."'";
$query = mysqli_query($conn,$sql);
$result = mysqli_fetch_array($query);

if (isset($_POST['save'])) {
  $password = mysqli_real_escape_string($conn, $_POST['password_old']);
  $hash = password_hash($password, PASSWORD_BCRYPT);

  $password1 = mysqli_real_escape_string($conn, $_POST['password_new']);
  $hash1 = password_hash($password, PASSWORD_BCRYPT);

  $options = [
    'cost' => 10
  ];
  
  if (password_verify($_POST['password_old'], $result['password']) != $result[1]) {
    $check_submit = '<div class="alert alert-danger" role="alert">';
    $check_submit .= '<span><i class="bi bi-info-circle"></i> รหัสผ่านเดิมไม่ถูกต้อง</span>';
    $check_submit .= '</div>';
  }else if ($_POST['password_new'] != $_POST['confirm_password']) {
    $check_submit = '<div class="alert alert-danger" role="alert">';
    $check_submit .= '<span><i class="bi bi-info-circle"></i> รหัสผ่านใหม่ ไม่ตรงกับ ยืนยันรหัสผ่านใหม่</span>';
    $check_submit .= '</div>';
  }else {

    $hash_real = password_hash($_POST["password_new"], PASSWORD_BCRYPT);
    $hash_replace = str_replace("$2y$", "$2a$", $hash_real);

    $sql_2 = "UPDATE users SET password = '".$hash_replace."' WHERE playername = '".$_SESSION['playername']."'";
    $query_2 = mysqli_query($conn, $sql_2);

    header("location:index.php?update=pass");
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title> เปลี่ยนรหัสผ่านใหม่</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/icons/bootstrap-icons.css">

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
<body class="default">

  <div class="container-fluid">
    <div class="col-md-12 mt-4">
      <div class="row justify-content-md-center">
        <div class="col-md-auto"><?php echo $check_submit;?></div>
      </div>
    </div>
    <div class="row justify-content-md-center">
      <div class="col-md-5 mb-4">
        <div class="card border-dark mt-2">
          <h5 class="card-header">เปลี่ยนรหัสผ่าน : <?php echo $result[0]; ?></h5>
          <div class="card-body">
            <div class="row justify-content-md-center mb-2">
              <div class="col col-lg-6">
                <img src="../img/password.png" style="width: 100%;">
              </div>
            </div>
            <form method="post">
              <div class="mb-3">
                <label class="form-label">รหัสผ่านเดิม</label>
                <input type="password" class="form-control" name="password_old" required/>
              </div>
              <div class="mb-3">
                <label class="form-label">รหัสผ่านใหม่</label>
                <input type="password" class="form-control" name="password_new" required/>
              </div>
              <div class="mb-3">
                <label class="form-label">ยืนยันรหัสผ่านใหม่</label>
                <input type="password" class="form-control" name="confirm_password" required/>
              </div>
              <button type="submit" class="btn btn-success" name="save">บันทึกข้อมูล</button>
              <a href="index.php" type="submit" class="btn btn-danger" name="save">ย้อนกลับ</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <?php mysqli_close($conn);?>
</body>
</html>
