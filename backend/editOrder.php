<?php  
try {
    
    $date = $_POST['date'];
    $orderId = $_POST['orderId'];
    include("../include/connect.php");

    $sqlUpdateOrder = "UPDATE orders SET date = '$date' WHERE id = '$orderId'";
    $qUpdateOrder = $db->query($sqlUpdateOrder);

    if($qUpdateOrder){
        echo json_encode(['status' => '200' , 'message' => 'success']);
    }
} catch (\Throwable $th) {
    echo json_encode(['status' => '500' , 'message' => $th]);
}
?>