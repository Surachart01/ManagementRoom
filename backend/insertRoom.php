<?php 
try {
    include("../include/connect.php");
    $codeRoom = $_POST['codeRoom'];
    $roomName = $_POST['roomName'];
    $description = $_POST['description'];

    if (isset($_FILES['image'])) {
        $image = $_FILES['image'];
        $date = date("Y-m-d-H-i-s");
        $upload_dir = "../images/rooms";
        $nameFile = $userName . "_" . $date;
        if ($image['error'] == 0) {
            $file_exp = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));  // รับนามสกุลไฟล์
            $upload_profile = "$upload_dir/$nameFile.$file_exp";
            move_uploaded_file($image['tmp_name'], $upload_profile);
            $nameImage = "./images/rooms/$nameFile.$file_exp";
            $sqlUpdateimage = "INSERT INTO rooms (roomName,codeRoom,image,description) VALUES ('$roomName','$codeRoom','$nameImage','$description')";
            $qUpdateImage = $db->query($sqlUpdateimage);
            if($qUpdateImage){
                echo json_encode(['status' => '200','message'=>"เสร็จสิ้น"]);
            }
        }
    }else{
        echo json_encode(['status' => '400','message'=>"ต้องใส่รูป"]);
    }
    
} catch (\Throwable $th) {
    echo json_encode(['status' => '500','message'=>"$th"]);
}
   
?>