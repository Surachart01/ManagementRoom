<?php  
    try {
        include("../include/connect.php");
        $roomId = $_POST['roomId'];
        $sqlDelete = "DELETE FROM rooms WHERE id = '$roomId'";
        $qDelete = $db->query($sqlDelete);
        if($qDelete){
            $sqlDelete = "DELETE FROM orders WHERE roomId = '$roomId'";
            $qDel = $db->query($sqlDelete);
            echo json_encode(['status' => '200' , 'message' => 'success']);
        }else{
            echo json_encode(['status' => '400' , 'message' => 'error']);
        }
    } catch (\Throwable $th) {
        echo json_encode(['status' => '500' , 'message' => "$th"]);
    }
?>