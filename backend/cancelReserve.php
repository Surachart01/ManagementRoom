<?php  
    include("../include/connect.php");
    $orderId = $_POST['orderId'];

    $sqlDelete = "DELETE FROM orders WHERE id = '$orderId'";
    $qDelete = $db->query($sqlDelete);
    if($qDelete){
        echo '200';
    }else{
        echo '500';
    }
?>