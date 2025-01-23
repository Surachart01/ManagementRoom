<?php
try {
    session_start();
    include("./include/connect.php");
    if (isset($_SESSION['auth']) && isset($_SESSION['auth']->role)) {
        if ($_SESSION['auth']->role != '0') {
            header("Location: login.php");
            exit();
        }
    } else {
        header("Location: login.php");
        exit();
    }
    $sqlUSer = "SELECT * FROM users WHERE role = '1'";
    $qUser = $db->query($sqlUSer);
    $sqlRooms = "SELECT * FROM orders WHERE date >= CURRENT_DATE";
    $qRoom = $db->query($sqlRooms);
    $dataUser = $_SESSION['auth'];
    $sqlCheckReserve = "SELECT rooms.roomName, rooms.codeRoom, orders.date,orders.time, orders.id,users.firstName,users.lastName FROM orders  INNER JOIN rooms ON rooms.id = orders.roomId INNER JOIN users ON users.id = orders.userId WHERE orders.date >= CURRENT_DATE AND status ='0' ";
    // WHERE date >= CURRENT_DATE
    $qCheckReserve = $db->query($sqlCheckReserve);
} catch (\Throwable $th) {
    echo $th;
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Admin</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
    <link rel="icon" type="image/gif" href="./images/Logo.gif">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <style>
        body {
            background-color: #4C585B;
            height: 100vh;
            overflow-y: hidden;
        }

        .col-2 {
            border-radius: 0px 30px 30px 0px;
            background-color: rgba(183, 228, 245, 0.67);
            height: 100vh;
        }

        .menu {
            text-decoration: none;
            text-align: center;
            margin-bottom: 10px;
            color: #fff;
            background-color: #4C585B;
            border-radius: 20px;
            transition: ease-in-out 0.5s all;
        }

        .menu:hover {
            background-color: #F4EDD3;
            color: #000000;
        }

        .content {
            width: 97%;
            height: 95%;
            background-color: #fff;
            border-radius: 30px;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-2 ">
            <div class="d-flex justify-content-center my-5 flex-column px-2">

                <a href="./admin.php" class="py-2 menu" style="background-color:rgb(146, 141, 125); color:#fff;">
                    หน้าหลัก
                </a>
                <a href="./history.php" class="py-2 menu">
                    ประวัติการจองห้อง
                </a>
                <a href="./room.php" class="py-2 menu">
                    รายการห้อง
                </a>
                <a href="./user.php" class="py-2 menu">
                    ผู้ใช้งาน
                </a>
            </div>
        </div>
        <div class="col-10">
            <div class="content mx-3 my-3">
                <div class="d-flex justify-content-between px-3 py-3 " style="background-color:rgb(220, 220, 218);">
                    <a href="./admin.php" class="mt-auto"><h5 class="my-auto">Admin</h5></a>
                    <a href="./backend/logout.php" class="mt-auto">ออกจากระบบ</a>
                </div>
                <div class="row px-3 py-2">
                    <div class="col-6">
                        <div class="card" style="background-color: #4C585B; color:#fff;">
                            <div class="card-body">
                                <h4>จำนวนห้องที่จองไว้</h4>
                                <h5><?php echo $qRoom->num_rows ?> ห้อง</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 ">
                        <div class="card">
                            <div class="card-body" style="background-color:rgb(30, 56, 63); color:#fff;"">
                                <h4>จำนวนผู้ใช้งานในระบบ</h4>
                                <h5><?php echo $qUser->num_rows ?> คน</h5>
                            </div>
                        </div>
                    </div>
                    <hr class=" my-3" />
                        </div>

                        <div class="content mx-3 ">
                            <div class="row px-3 py-2">
                                <table class="table table-responsive table-hover mb-2" id="myTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">ชื่อห้อง</th>
                                            <th class="text-center">เลขห้อง</th>
                                            <th class="text-center">ผู้จอง</th>
                                            <th class="text-center">วันที่จอง</th>
                                            <th class="text-center">เวลา</th>
                                            <th class="text-center">ยืนยัน</th>
                                            <th class="text-center">แก้ไขวันที่ </th>
                                            <th class="text-center">ยกเลิก</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        while ($item = $qCheckReserve->fetch_object()) {
                                        ?>
                                            <tr>
                                                <td><?php echo $i ?></td>
                                                <td><?php echo $item->roomName ?></td>
                                                <td><?php echo $item->codeRoom ?></td>
                                                <td><?php echo $item->firstName . " " . $item->lastName  ?></td>
                                                <td><?php echo $item->date ?></td>
                                                <td><?php echo $item->time ?></td>
                                                <td>
                                                    <button class="btn btn-success" id="confirm" data-id="<?php echo $item->id ?>">อนุมัติ</button>
                                                    <button class="btn btn-danger" id="notConfirm" data-id="<?php echo $item->id ?>">ไม่อนุมัติ</button>
                                                </td>
                                                <td><button class="btn btn-warning" data-id="<?php echo $item->id ?>" id="edit">แก้ไข</button></td>
                                                <td><button class="btn btn-danger" data-id="<?php echo $item->id ?>" id="delete">ลบ</button></td>
                                            </tr>
                                        <?php
                                            $i++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <hr class="my-3" />
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <!-- Bootstrap JavaScript Libraries -->
            <!-- Bootstrap JavaScript Libraries -->
            <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
            <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
                let table = new DataTable('#myTable');

                $(document).on("click","#confirm",function(){
                    Swal.fire({
                        title: "คุณแน่ใจหรือไม่?",
                        text: "คุณต้องการอนุมัติการจองนี้หรือไม่?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "ยืนยัน",
                        cancelButtonText: "ยกเลิก",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let orderId = $(this).data("id");
                            let formData = new FormData();
                            formData.append("orderId",orderId);
                            $.ajax({
                                url:"./backend/confirmOrder.php",
                                type:"POST",
                                data:formData,
                                dataType:'json',
                                contentType:false,
                                processData:false,
                                success:function(res){
                                    if(res.status == '200'){
                                        Swal.fire({
                                            title:"อนุมัติการจองเสร็จสิ้น",
                                            icon:"success",
                                            showConfirmButton:false,
                                            timer:1500
                                        }).then(() => {
                                            window.location.reload()
                                        })
                                    }else{
                                        Swal.fire({
                                            title:"เกิดข้อผิดพลาด",
                                            icon:"error",
                                            showConfirmButton:false,
                                            timer:1500
                                        }).then(() => {
                                            window.location.reload()
                                        })
                                    }
                                }
                            })
                        }
                    })
                })

                $(document).on("click","#notConfirm",function(){
                    Swal.fire({
                        title: "คุณแน่ใจหรือไม่?",
                        text: "คุณต้องการไม่อนุมัติการจองนี้หรือไม่?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "ยืนยัน",
                        cancelButtonText: "ยกเลิก",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let orderId = $(this).data("id");
                            let formData = new FormData();
                            formData.append("orderId",orderId);

                            $.ajax({
                                url:"./backend/unConfirmOrder.php",
                                type:"POST",
                                data:formData,
                                dataType:'json',
                                contentType:false,
                                processData:false,
                                success:function(res){
                                    if(res.status == '200'){
                                        Swal.fire({
                                            title:"ไม่อนุมัติการจองเสร็จสิ้น",
                                            icon:"success",
                                            showConfirmButton:false,
                                            timer:1500
                                        }).then(() => {
                                            window.location.reload()
                                        })
                                    }else{
                                        Swal.fire({
                                            title:"เกิดข้อผิดพลาด",
                                            icon:"error",
                                            showConfirmButton:false,
                                            timer:1500
                                        }).then(() => {
                                            window.location.reload()
                                        })
                                    }
                                }
                            })
                        }
                    })
                })

                $(document).on("click", "#edit", function() { //success
                    let orderId = $(this).data("id");
                    let formData = new FormData();
                    formData.append("orderId", orderId);
                    $.ajax({
                        url: "./components/editOrder.php",
                        type: "POST",
                        data: formData,
                        dataType: "html",
                        contentType: false,
                        processData: false,
                        success: function(res) {
                            Swal.fire({
                                html: res,
                                showConfirmButton: false,
                            })
                        }
                    })
                })

                $(document).on("input", "#changeDate", function() { //success
                    let date = $(this).val();
                    let selectedDate = new Date(date);
                    let currentDate = new Date();
                    if (selectedDate < currentDate.setHours(0, 0, 0, 0)) {
                        $('#btnEdit').attr('disabled', true)
                        $('#alert').html("โปรดเลือกวันที่ใหม่");
                        return;
                    }

                    let roomId = $(this).data("room");

                    let formData = new FormData();
                    let orderId = $('#btnEdit').data("id");
                    formData.append("date", date);
                    formData.append("orderId", orderId);
                    formData.append("roomId", roomId);
                    $.ajax({
                        url: "./backend/checkServe.php",
                        type: "POST",
                        data: formData,
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        success: function(res) {
                            console.log(res)
                            if (res.status == 200) {
                                console.log('tt')
                                $('#btnEdit').attr('disabled', false)
                                $('#alert').html("")
                            } else {
                                console.log('uu')
                                $('#btnEdit').attr('disabled', true)
                                $('#alert').html("ติดจองแล้ว");
                            }
                        }
                    })
                })

                $(document).on("click", "#btnEdit", function() { //success
                    let orderId = $(this).data("id")
                    let date = $('#changeDate').val()
                    let formData = new FormData();
                    formData.append("orderId", orderId);
                    formData.append("date", date)
                    $.ajax({
                        url: "./backend/editOrder.php",
                        type: "POST",
                        data: formData,
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        success: function(res) {
                            if (res.status == 200) {
                                Swal.fire({
                                    title: "แก้ไขวันที่เสร็จสิ้น",
                                    icon: "success",
                                    timer: 1000,
                                    showConfirmButton: false,
                                }).then(() => {
                                    window.location.reload();
                                })
                            } else {
                                Swal.fire({
                                    title: "เกิดข้อผิดพลาด โปรดลองอีกครั้ง",
                                    icon: "error",
                                    timer: 1000,
                                    showConfirmButton: false,
                                }).then(() => {
                                    window.location.reload();
                                })
                            }
                        }
                    })
                })

                $(document).on("click", "#delete", function() { //success
                    Swal.fire({
                        title: "ต้องการยกเลิกการจองใช้หรือไม่",
                        icon: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "ยืนยัน"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let orderId = $(this).data("id");
                            let formData = new FormData();
                            formData.append("orderId", orderId);
                            $.ajax({
                                url: "./backend/deleteOrder.php",
                                type: "POST",
                                data: formData,
                                dataType: "json",
                                contentType: false,
                                processData: false,
                                success: function(res) {
                                    if (res.status == '200') {
                                        Swal.fire({
                                            title: "ลบการจองเสร็จสิ้น",
                                            icon: "success",
                                            showConfirmButton: false,
                                            timer: 1000
                                        }).then(() => {
                                            window.location.reload()
                                        })

                                    } else {
                                        Swal.fire({
                                            title: "เกิดข้อผิดพลาด",
                                            icon: "error",
                                            showConfirmButton: false,
                                            timer: 1000
                                        }).then(() => {
                                            window.location.reload()
                                        })
                                    }
                                }
                            })
                        }
                    })
                })
            </script>
</body>

</html>