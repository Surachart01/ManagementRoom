<?php  
    include("../include/connect.php");
    $orderId = $_POST['orderId'];
    $sqlOrder = "SELECT * FROM orders WHERE id = '$orderId' ";
    $qOrder = $db->query($sqlOrder);
    $item = $qOrder->fetch_object();
?>

<h2>แก้ไขการจอง</h2>
<label for="">วันที่จอง <span class="text-danger" id="alert"></span></label>
<input type="date" value="<?php echo $item->date ?>" data-room="<?php echo $item->roomId ?>" class="form-control" id="changeDate">

<button class="btn btn-success my-2 form-control" id="btnEdit" data-id="<?php echo $orderId ?>" >แก้ไข</button>

