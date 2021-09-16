<?php

session_start();

require_once "../connection.php";


if (isset($_REQUEST['update_id'])) {
    try {
        $id = $_REQUEST['update_id'];
        $select_stmt = $db->prepare("SELECT * FROM web_topup WHERE id = :id");
        $select_stmt->bindParam(':id', $id);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
    } catch(PDOException $e) {
        $e->getMessage();
    }
}

if (isset($_REQUEST['btn_update'])) {
    $status_up = $_REQUEST['txt_status'];

    if (empty($status_up)) {
        $errorMsg = "มึงก็ใส่ข้อมูลดิไอ่ชิงหมาเกิด";
    } else {
        try {
            if (!isset($errorMsg)) {
                $update_stmt = $db->prepare("UPDATE web_topup SET status = :istatus_up WHERE id = :id");
                $update_stmt->bindParam(':istatus_up', $status_up);
                $update_stmt->bindParam(':id', $id);

                if ($update_stmt->execute()) {
                    $updateMsg = "อัพเดตข้อมูลให้แล้วไอ่สัสนรก";
                    header("refresh:3;index.php");
                }
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}


if(isset($_POST['checking_editbtn']) ) {

    $i_id = $_POST['ignp_id'];
    // echo $return = $i_id;

    $query = "SELECT * FROM web_topup WHERE id='$i_id' ";
    $quert_run = mysqli_query($conn, $query);

    if(mysqli_num_rows($quert_run) > 0) {
        
        foreach($quert_run as $row)
        {


            $status = $row['status'] == 'in_progress';


            echo $return = '
                <h5> ID : '.$row['id'].'</h5>
                <h5> Playername : '.$row['playername'].'</h5>
                <h5> Paymentch : '.$row['paymentch'].'</h5>
                <h5> Time : '.$row['time'].'</h5>
                <h5> Amount : '.$row['amount'].'</h5>
                <h5> Status : '.$row['status'].'</h5>


                <div class="form-group text-center">
                <div class="row">
                    <label for="info" class="col-sm-3 control-label">สถานะการชำระเงิน</label>
                    <div class="col-sm-9">
                        <select id="country" name="txt_status" class="form-control">
                            <option value="in_progress">กำลังดำเนินการ</option>
                            <option value="success">ทำรายการสำเร็จ</option>
                            <option value="cancel">ยกเลิกรายการ</option>
                        </select>
                    </div>
                </div>
            </div>

                
            ';
        }
    }
    else {
        echo $return = "<h5>หาไม่เจอ</h5>";
    }
    

}


?>