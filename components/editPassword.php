<?php  
    $userId = $_POST['userId'];
?>
<h3>แก้ไขรหัสผ่าน</h3>
<hr />
<label for="">รหัสผ่าน</label>
<input type="text" class="form-control my-2" id="password">
<button class="btn btn-success form-control" data-id="<?php echo $userId ?>" id="submitPassword">ยืนยัน</button>
