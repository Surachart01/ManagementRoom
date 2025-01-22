<?php 
    include("../include/connect.php");
    $roomId = $_POST['roomId'];
    $sqlRoom = "SELECT * FROM rooms WHERE id = '$roomId'";
    $qRoom = $db->query($sqlRoom);
    $item = $qRoom->fetch_object();
?>

<h3>แก้ไขข้อมูลห้อง</h3>
<hr />
<label for="">ชื่อห้อง</label>
<input type="text" class="form-control my-2" value="<?php echo $item->roomName ?>" id="roomName">
<label for="">เลขห้อง</label>
<input type="text" value="<?php echo $item->codeRoom ?>" class="form-control my-2  "id="codeRoom">
<label for="">รายละเอียด</label>
<textarea name="" id="description" class="form-control"><?php echo $item->description ?></textarea>
<label for="">รูปห้อง</label>
<input type="file" value="" class="form-control my-2"  id="image">
<button class="btn btn-success form-control" data-id="<?php echo $roomId ?>" id="btnEdit">แก้ไขข้อมูล</button>