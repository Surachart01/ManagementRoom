<?php  
    include("../include/connect.php");
    $id = $_POST['id'];
    $sql = "DELETE FROM users WHERE id = '$id'";
    $qSql = $db->query($sql);
    if($qSql){
        echo json_encode(['status' => '200' , 'message' => 'OK']);
    }else{
        echo json_encode(['status' => '400' , 'message' => 'cannot query Sql']);
    }
?>