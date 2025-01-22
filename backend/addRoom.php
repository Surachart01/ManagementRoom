<?php
session_start();
try {
    include("../include/connect.php");
    $dataUser = $_SESSION['auth'];
    $date = $_POST['date'];
    $time = json_decode($_POST['time']);
    $codeRoom = $_POST['roomId'];
    for($i=0;$i< count($time) ;$i++){
        $index = $time[$i];
        $sqlAddOrder = "INSERT INTO orders (roomId,date,userId,time) VALUES ('$codeRoom','$date','$dataUser->id','$index')";
        $qAddOrder = $db->query($sqlAddOrder);
        
    }
    if ($qAddOrder) {
        echo json_encode(['status' => '200','message' => 'insert order complate']);
    }else{
        echo json_encode(['status' => '400','message' => 'Bad Request']);
    }
} catch (\Throwable $th) {
    echo json_encode(['status' => '500','message' => "$th"]);
}?>
