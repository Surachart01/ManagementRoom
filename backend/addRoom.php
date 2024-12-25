<?php  
    session_start();
    //receive valiable
    include("../include/connect.php");
    $dataUser = $_SESSION['auth'];
    $date = $_POST['date'];
    $codeRoom = $_POST['roomCode'];

    $sqlRoom = "SELECT * FROM rooms WHERE codeRoom = '$codeRoom'";
    $qRoom = $db->query($sqlRoom);
    $dataRoom = $qRoom->fetch_object();
    
    $sqlCheckRoom  = "SELECT * FROM orders WHERE date = '$date' AND roomId = '$dataRoom->id'";
    $qCheckRoom = $db->query($sqlCheckRoom);
    if($qCheckRoom->num_rows > 0){
        echo '400';
    }else{
        $sqlAddOrder = "INSERT INTO orders (roomId,date,userId) VALUES ('$dataRoom->id','$date','$dataUser->id')";
        $qAddOrder = $db->query($sqlAddOrder);
        if($qAddOrder){
            echo "200";
        }
    }
?>