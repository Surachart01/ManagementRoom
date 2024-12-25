<?php 
try {
    include("../include/connect.php");
    $roomId = $_POST['roomId'];
    $codeRoom = $_POST['codeRoom'];
    $roomName = $_POST['roomName'];

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
            $sqlUpdateimage = "UPDATE rooms SET image = '$nameImage' WHERE id = '$roomId'";
            $qUpdateImage = $db->query($sqlUpdateimage);
        }
    }
    $sqlUpdateDes = "UPDATE rooms SET roomName = '$roomName' , codeRoom = '$codeRoom' WHERE id = '$roomId'";
    $qUpdateDes = $db->query($sqlUpdateDes);
    if($qUpdateDes){
        echo json_encode(['status' => '200','message'=>"เสร็จสิ้น"]);
    }else{
        echo json_encode(['status' => '400','message'=>"เกิดช้อผิดพลาด"]);
    }

    
} catch (\Throwable $th) {
    echo json_encode(['status' => '500','message'=>"$th"]);
}
   
?>