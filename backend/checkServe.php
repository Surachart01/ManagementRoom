<?php
try {
    include("../include/connect.php");
    $date = $_POST['date'];
    $orderId = $_POST['orderId'];
    $roomId = $_POST['roomId'];
    $sqlReserve = "SELECT * FROM orders WHERE date = '$date' AND id != '$orderId' AND roomId = '$roomId'";
    $qReserve = $db->query($sqlReserve);
    if($qReserve->num_rows == 0){
        echo json_encode(['status' =>200,'message' => 'ไม่มีผู้จอง']);
    }else{
        echo json_encode(['status'=>400,'message' => 'ติดจอง']);
    }
} catch (\Throwable $th) {
    echo json_encode(['status'=>'500','message' => $th]) ;
}
