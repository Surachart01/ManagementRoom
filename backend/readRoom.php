<?php  
    include("../include/connect.php");
    $roomId = $_POST['roomId'];
    $sql = "SELECT * FROM rooms WHERE id = '$roomId'";
    $qSql = $db->query($sql);

    $data = $qSql->fetch_object();


?>

<div class="d-flex justify-content-center">
    <img src="<?php echo $data->image ?>" alt="">
</div>
<div class="fs-2 mt-2"> รายละเอียดห้อง</div>
<hr>
<p>ชื่อห้อง : <?php echo $data->roomName ?></p>
<p>รหัสห้อง : <?php echo $data->codeRoom ?></p>