<?php 
try {
    include("../include/connect.php");
    $userId = $_POST['userId'];
    $password = $_POST['password'];
    $encyptPassword = md5($password);

    $sqlUpdate = "UPDATE users SET password = '$encyptPassword' WHERE id = '$userId'";
    $qUpdate = $db->query($sqlUpdate);
    if($qUpdate){
        echo json_encode(['status' => '200','message' => 'edit password success']);
    }else{
        echo json_encode(['status' => '400','message' => 'cannot edit password ']);
    }


} catch (\Throwable $th) {
    echo json_encode(['status' => '500','message' => "$th"]);
}
    

?>