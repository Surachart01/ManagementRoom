<?php  
    include("../include/connect.php");
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $sqlCheckEmail = "SELECT * FROM users WHERE email = '$email'";
    $qCheckEmail = $db->query($sqlCheckEmail);
    if($qCheckEmail->num_rows != 0){
        echo '403';
    }else{
        $passwordEncrypt = md5($password);
        $sqlAddUser = "INSERT INTO users (firstName , lastName , email , password ,role) VALUES ('$firstName','$lastName','$email','$passwordEncrypt','1')";
        $qAddUser = $db->query($sqlAddUser);
        if($qAddUser){
            echo '200';
        }else{
            echo '500';
        }
        
    }
?>