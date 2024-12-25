<?php 
    include("../include/connect.php");
    $codeRoom = $_POST['codeRoom'];
    $sqlRoom = "SELECT * FROM rooms WHERE codeRoom = '$codeRoom'";
    $qRoom = $db->query($sqlRoom);
    $dataRoom = $qRoom->fetch_object();

    $sqlCheckRoom = "SELECT date FROM orders WHERE roomId = '$dataRoom->id'";
    $qCheckRoom = $db->query($sqlCheckRoom);
    $res = [];
    while($data = $qCheckRoom->fetch_object()){
        $obj = [
            "title"=>"จอง",
            "start"=>$data->date
        ];
        array_push($res,$obj);
    }
    
    echo json_encode($res);
?>