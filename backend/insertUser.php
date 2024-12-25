<?php  
try {
    include("../include/connect.php");
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    
    $sqlCheckEmail = "SELECT * FROM users WHERE email = '$email'";
    $qCheckEmail = $db->query($sqlCheckEmail);
    if($qCheckEmail->num_rows != 0){
        echo json_encode(['status' => '403','message' => 'อีเมลซ้ำ']);
    }else{
        $passwordEncrypt = md5($password);
        $sqlAddUser = "INSERT INTO users (firstName , lastName , email , password ,role) VALUES ('$firstName','$lastName','$email','$passwordEncrypt','$role')";
        $qAddUser = $db->query($sqlAddUser);
        if($qAddUser){
            echo json_encode(['status' => '200','message' => 'เสร็จสิ้น']);
        }
    }
} catch (\Throwable $th) {
    echo json_encode(['status' => '500','message' => "$th"]);
}
?>