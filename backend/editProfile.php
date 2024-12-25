<?php 
try {
    include("../include/connect.php");

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $userId = $_POST['userId'];
    $role = $_POST['role'];

    $sqlUpdateUser = "UPDATE users SET firstName = '$firstName' , lastName = '$lastName' , email = '$email' ,role = '$role' WHERE id = '$userId' ";
    $qUpdateUser = $db->query($sqlUpdateUser);
    if($qUpdateUser){
        echo json_encode(['status' => '200','message' => 'แก้ไขเสร็จสิ้น']);
    }
} catch (\Throwable $th) {
    echo json_encode(['status' => '500','message' => "$th"]);
}
?>