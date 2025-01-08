<?php
session_start();
if (isset($_SESSION['auth'])) {
    $dataUser = $_SESSION['auth'];
} else {
    header("location:login.php");
}

include("./include/connect.php");
$sqlOrder = "SELECT * FROM orders WHERE userId = '$dataUser->id'";
$qOrder = $db->query($sqlOrder);
$rOrder = $qOrder->num_rows;
?>

<!doctype html>
<html lang="en">

<head>
    <title>Home</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <link rel="icon" type="image/gif" href="./images/Logo.gif">
</head>

<body style="min-height:100vh;">
    <div class="row">
    <div class="col-12 d-flex justify-content-between bg-dark px-4  py-1 text-light shadow">
            <p class="my-auto"><img src="./images/Logo.gif" width="80px" alt=""></p>
            <div class="d-flex my-auto ">
                <a class="dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    คุณ <?php echo $dataUser->firstName ?>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="./reserveRoomHis.php">รายการจองห้อง</a></li>
                    <li><a class="dropdown-item" href="./profile.php">โปรไฟล์</a></li>
                    <li><a class="dropdown-item" href="./backend/logout.php">ออกจากระบบ</a></li>
                </ul>

            </div>

        </div>
        <div class="col-12">
            <div class="d-flex justify-content-center mt-5">
                <div class="container">
                    <h2>รายการห้องประชุม</h2>
                    <hr />
                    <table class="table table-hover " id="myTable">
                        <thead>
                            <tr>

                                <th class="text-center">#</th>
                                <th class="text-center">รูป</th>
                                <th class="text-center">ชื่อห้อง</th>
                                <th class="text-center">วันที่จอง</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $i = 1;
                            while ($item = $qOrder->fetch_object()) {
                                $sqlroom = "SELECT * FROM rooms WHERE id = '$item->roomId'";
                                $qroom = $db->query($sqlroom);
                                $itemRoom = $qroom->fetch_object();
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $i ?></td>
                                    <td class="text-center"><img width="100px" src="<?php echo $itemRoom->image ?>" alt=""></td>
                                    <td class="text-center"><?php echo $itemRoom->roomName ?></td>
                                    <td class="text-center"><?php echo $item->date ?></td>
                                    <td class="text-center"><button class="btn btn-danger" data-id="<?php echo $item->id ?>" id="cancelReserve">ยกเลิก</button></td>
                                </tr>

                            <?php
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="fixed-bottom">
                    <button class="btn btn-warning" id="back">ย้อนกลับ</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let table = new DataTable('#myTable');

        $(document).on("click", "#back", function() {
            window.history.back();
        })

        $(document).on("click", "#cancelReserve", function() {
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
                        url: "./backend/cancelReserve.php",
                        type: "POST",
                        data: formData,
                        dataType: "text",
                        contentType: false,
                        processData: false,
                        success: function(res) {
                            if (res == '200') {
                                Swal.fire({
                                    title: "ยกเลิกเสร็จสิ้น",
                                    icon: "success",
                                    timer: 1000,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.reload();
                                })
                            } else {
                                Swal.fire({
                                    title: "เกิดข้อผิดพลาดโปรดลองอีกครั้ง",
                                    icon: "error",
                                    timer: 1000,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.reload();
                                })
                            }
                        }
                    })
                }
            })
        })
    </script>
</body>