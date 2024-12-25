<?php
session_start();
if (isset($_SESSION['auth'])) {
    if ($_SESSION['auth']->role == '1') {
        header("location:login.php");
    }
} else {
    header("location:login.php");
}

try {
    include("./include/connect.php");
    $sqlRooms = "SELECT * FROM rooms ";
    $qRooms = $db->query($sqlRooms);
} catch (\Throwable $th) {
    //throw $th;
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

                <a href="./admin.php" class="py-2 menu">
                    หน้าหลัก
                </a>
                <a href="./recserveRoom.php" class="py-2 menu">
                    การจองห้อง
                </a>
                <a href="./history.php" class="py-2 menu">
                    ประวัติการจองห้อง
                </a>
                <a href="./room.php" class="py-2 menu" style="background-color:rgb(146, 141, 125); color:#fff;">
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
                    <a href="./admin.php" class="mt-auto">UserName</a>
                    <a href="./backend/logout.php" class="mt-auto">ออกจากระบบ</a>
                </div>
                <div class="row px-3 py-2">
                    <button class="form-control btn btn-warning" id="insert">เพิ่มห้อง</button>
                    <table id="myTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>รูปห้อง</th>
                                <th>ชื่อห้อง</th>
                                <th>เลขห้อง</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            while ($item = $qRooms->fetch_object()) {
                            ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><img src="<?php echo $item->image ?>" width="60px" alt=""></td>
                                    <td><?php echo $item->roomName ?></td>
                                    <td><?php echo $item->codeRoom ?></td>
                                    <td>
                                        <button class="btn btn-warning" data-id="<?php echo $item->id ?>" id="edit">แก้ไข</button>
                                        <button class="btn btn-danger" data-id="<?php echo $item->id ?>" id="delete">ลบ</button>
                                    </td>

                                </tr>
                            <?php
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let table = new DataTable('#myTable');

        $(document).on("click", "#insert", function() {
            $.ajax({
                url: "./components/insertRoom.php",
                dataType: "html",
                contentType: false,
                processData: false,
                success: function(res) {
                    Swal.fire({
                        html: res,
                        showConfirmButton: false
                    })
                }
            })

        })

        $(document).on("click", "#edit", function() {
            let roomId = $(this).data("id")
            let formData = new FormData();
            formData.append("roomId", roomId);

            $.ajax({
                url: "./components/editRoom.php",
                type: "POST",
                data: formData,
                dataType: "html",
                contentType: false,
                processData: false,
                success: function(res) {
                    Swal.fire({
                        html: res,
                        showConfirmButton: false
                    })
                }
            })
        })

        $(document).on("click", "#btnInsert", function() {
            var formData = new FormData()
            if ($('#image')[0].files.length != 0) {
                var image = $('#image')[0].files[0];
                formData.append("image", image);
            }
            let roomName = $('#roomName').val();
            let codeRoom = $('#codeRoom').val();
            formData.append("codeRoom", codeRoom)
            formData.append("roomName", roomName)
            $.ajax({
                url: "./backend/insertRoom.php",
                type: "POST",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(res) {
                    console.log(res)
                    if (res.status == '200') {
                        Swal.fire({
                            title: "เพิ่่มข้อมูลเสร็จสิ้น",
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
                            // window.location.reload()
                        })
                    }
                }
            })
        })

        $(document).on("click", "#btnEdit", function() {

            var formData = new FormData()
            if ($('#image')[0].files.length != 0) {
                var image = $('#image')[0].files[0];
                formData.append("image", image);
            }
            let roomId = $(this).data("id");
            let roomName = $('#roomName').val();
            let codeRoom = $('#codeRoom').val();
            formData.append("roomId", roomId)
            formData.append("codeRoom", codeRoom)
            formData.append("roomName", roomName)
            $.ajax({
                url: "./backend/editRoom.php",
                type: "POST",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(res) {
                    console.log(res)
                    if (res.status == '200') {
                        Swal.fire({
                            title: "แก้ไขข้อมูลเสร็จสิ้น",
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
                            // window.location.reload()
                        })
                    }
                }
            })
        })

        $(document).on("click", "#delete", function() {
            Swal.fire({
                title: "ต้องการลบใช้หรือไม่",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ยืนยัน"
            }).then((result) => {
                if (result.isConfirmed) {
                    let roomId = $(this).data("id");
                    let formData = new FormData();
                    formData.append("roomId", roomId);

                    $.ajax({
                        url: "./backend/deleteRoom.php",
                        type: "POST",
                        data: formData,
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        success: function(res) {
                            console.log(res)
                            if (res.status == '200') {
                                Swal.fire({
                                    title: "ลบเสร็จสิ้น",
                                    showConfirmButton: false,
                                    timer: 1000,
                                    icon: "success"
                                }).then(() => {
                                    window.location.reload()
                                })
                            } else {
                                Swal.fire({
                                    title: "เกิดข้อผิดพลาด",
                                    showConfirmButton: false,
                                    timer: 1000,
                                    icon: "error"
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