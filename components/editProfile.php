<?php
include("../include/connect.php");
try {
    $userId = $_POST['userId'];
    $sqlUser = "SELECT * FROM users WHERE id = '$userId'";
    $qUser = $db->query($sqlUser);
    $item = $qUser->fetch_object();
} catch (\Throwable $th) {
    echo $th;
}
?>
<h3>เพิ่มผู้ใช้งาน</h3>
<hr />
<label for="">ชื่อจริง</label>
<input type="text" class="form-control" id="firstName" value="<?php echo $item->firstName ?>">
<label for="">นามสกุล</label>
<input type="text" class="form-control" id="lastName" value="<?php echo $item->lastName ?>">
<label for="">อีเมล</label>
<input type="email" class="form-control" id="email" value="<?php echo $item->email ?>">
<label for="">สถานะ</label>
<select name="" id="role" class="form-select">
    <option value="0" <?php echo ($item->role == 0) ? 'selected' : '' ?>>Admin</option>
    <option value="1" <?php echo ($item->role == 1) ? 'selected' : '' ?>>User</option>
</select>
<button class="btn btn-success my-2 form-control" id="submitProfile" data-id="<?php echo $userId ?>">ยืนยัน</button>