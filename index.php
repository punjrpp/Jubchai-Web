<?php 

    session_start();


    if ($_SESSION == NULL) {
        

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jubchai Community</title>
    <link rel="icon" href="img/jccom.png">
    <link rel="stylesheet" href="assets/css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.css" rel="stylesheet" />
</head>


<style type="text/css">
body {
    background-image: url('img/bg_login.png');
    -webkit-background-size: cover;
    background-attachment: fixed;
}

</style>


<body>
<div class="bg">
        <div class="login-logo">
            <div class="imgano"><img width="350px" class="logo-bn animationo" src="img/jccom.png" alt="logo"></div>
        </div>
    <div class="container">
        <form action="index_db.php" method="post">
            <h1>ล็อคอิน</h1>
            <!-- Email input -->
            <div class="form-outline mb-4">
                <input type="username" name="playername" placeholder="Username" id="form2Example1" class="form-control" required/>
                <label class="form-label" for="form2Example1">ชื่อผู้เล่น</label>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <input type="password" name="password" placeholder="Password" id="form2Example2" class="form-control" required/>
                <label class="form-label" for="form2Example2">รหัสผ่าน</label>
            </div>

            <!-- 2 column grid layout for inline styling -->
            <div class="row mb-4">
                <div class="col d-flex justify-content-center">
                    <!-- <-- Checkbox --/>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="form2Example3" checked />
                        <label class="form-check-label" for="form2Example3"> Remember me </label>
                    </div>
                </div> -->

                <!-- <div class="col">
                    <-- Simple link --/>
                    <a href="#!">ลืมรหัสผ่าน?</a>
                </div> -->
            </div>

            <!-- Submit button -->
            <button type="submit" name="submit" class="btn btn-primary btn-block mb-4">ล็อคอิน</button>

            <!-- Register buttons -->
            <div class="text-center">
                <p>เธอยังไม่มีไอดีหรอเข้าไปสมัครที่ jubchairoom.net สิ!!</a></p>
                <p>ติดต่อสอบถาม</p>
                <button type="button" class="btn btn-primary btn-floating mx-1" onclick="window.open('https://www.facebook.com/jubchairoom', '_blank');">
                    <i class="fab fa-facebook-f"></i>
                </button>

                <button type="button" class="btn btn-primary btn-floating mx-1" onclick="window.open('http://www.jubchairoom.net/discord', '_blank');">
                    <i class="fab fa-discord"></i>
                </button>

                <!-- <button type="button" class="btn btn-primary btn-floating mx-1">
                    <i class="fab fa-twitter"></i>
                </button> -->

            </div>
        </form>
    </div>

</div>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.js"></script>
    <?php  
    
        echo '
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
        ';
    
    ?>
</body>

</html>

<?php 

    if (isset($_SESSION['success']) || isset($_SESSION['error'])) {
        session_destroy();
    }

?>

<?php }else{
    header("Location: member");
} ?>