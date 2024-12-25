<?php 
try {
    session_start();
    include("../include/connect.php");

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $userId = $_POST['userId'];

    $sqlUpdateUser = "UPDATE users SET firstName = '$firstName' , lastName = '$lastName' , email = '$email' WHERE id = '$userId' ";
    $qUpdateUser = $db->query($sqlUpdateUser);
    if($qUpdateUser){
        $sqlUser = "SELECT * FROM users WHERE id = '$userId'";
        $qUser = $db->query($sqlUser);
        $data = $qUser->fetch_object();
        $_SESSION['auth'] = $data;
        echo json_encode(['status' => '200','message' => 'แก้ไขเสร็จสิ้น']);
    }
} catch (\Throwable $th) {
    echo json_encode(['status' => '500','message' => "$th"]);
}
?>