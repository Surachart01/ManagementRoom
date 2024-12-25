<?php  
    session_start();
    include("../include/connect.php");
    $email = $_POST['email'];
    $password = $_POST['password'];

    $passwordEncrypt = md5($password);
    $sqlCheckLogin = "SELECT * FROM users WHERE email = '$email' AND password = '$passwordEncrypt'";
    $qCheckLogin = $db->query($sqlCheckLogin);
    if($qCheckLogin->num_rows != 1){
        echo '500';
    }else{
        $dataUser = $qCheckLogin->fetch_object();
        $_SESSION['auth'] = $dataUser;
        if($dataUser->role == 1){
            echo '200';
        }else{
            echo '201';
        }
        
    }
?>