<?php  
    try {
        include("../include/connect.php");
        $orderId = $_POST['orderId'];
        $sqlDelete = "DELETE FROM orders WHERE id = '$orderId'";
        $qDelete = $db->query($sqlDelete);
        if($qDelete){
            echo json_encode(['status' => '200' , 'message' => "$qDelete"]);
        }
    } catch (\Throwable $th) {
        echo json_encode(['status' => '500' , 'message' => "$th"]);
    }
?>