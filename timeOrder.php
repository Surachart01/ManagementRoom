<?php
try {
    include("./include/connect.php");
$date = $_POST['date'];
$roomCode = $_POST['roomCode'];
$sqlRoom = "SELECT * FROM rooms WHERE codeRoom='$roomCode'";
$qRoom = $db->query($sqlRoom);
$itemRoom = $qRoom->fetch_object();
$arrTime = ['08:00-09:00', '09:00-10:00', '10:00-11:00', '11:00-12:00', '13:00-14:00', '14:00-15:00', '15:00-16:00'];
$sqlCheckTime = "SELECT * FROM orders WHERE roomId='$itemRoom->id' AND date = '$date'";
$qCheckTime = $db->query($sqlCheckTime);
$arrOrder = [];
while ($item = $qCheckTime->fetch_object()) {
    array_push($arrOrder, $item->time);
}
} catch (\Throwable $th) {
    echo $th;
}

?>
<div class="modal-header">
    <h5 class="modal-title" id="infoModalLabel">Select Time Slot</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <input type="hidden" id="roomId" value="<?php echo $itemRoom->id; ?>">
    <?php
    try {
        foreach ($arrTime as $time) {
            if (in_array($time, $arrOrder)) {
                // Time slot is already booked
                echo '<button class="btn btn-outline-secondary mx-2 my-2" disabled style="width:200px ;height:70px">' . $time . '</button>';
            } else {
                // Time slot is available
                echo '<button class="btn btn-success time-slot mx-2 my-2" data-time="' . $time . '" style="width:200px; height:70px" >' . $time . '</button>';
            }
        }
    } catch (\Throwable $th) {
       echo $th;
    }
    
    ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" id="close" data-bs-dismiss="modal">ปิด</button>
    <button type="button" class="btn btn-primary" id="submit" data-roomid="<?php echo $itemRoom->id; ?>" data-date="<?= $date?>">ยืนยัน</button>
</div>
