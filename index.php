<?php
session_start();
if (isset($_SESSION['auth'])) {
    $dataUser = $_SESSION['auth'];
} else {
    // header("location:login.php");
}

include("./include/connect.php");
$sqlRoom = "SELECT * FROM rooms";
$qRoom = $db->query($sqlRoom);
$rRoom = $qRoom->num_rows;
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
            <h6 class="my-auto me-auto ms-1">ระบบจองห้องประชุมออนไลน์วิทยาลัยเทคนิคลพบุรี</h6>
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
                                <th class="text-center">รูป</th>
                                <th class="text-center">ชื่อห้อง</th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            while ($item = $qRoom->fetch_object()) { ?>
                                <tr>
                                    <td class="text-center py-auto"><img width="100px" src="<?php echo $item->image ?>" alt=""></td>
                                    <td class="text-center py-auto"><?php echo $item->roomName ?></td>
                                    <td class="text-center py-auto"><a class="btn btn-success" href="./orderRoom.php?roomCode=<?php echo $item->codeRoom ?>">จองห้อง</a></td>
                                    <td class="text-center py-auto"><button class="btn btn-primary" data-id="<?php echo $item->id ?>" id="description">รายละเอียด</button></td>
                                </tr>
                            <?php }
                            ?>
                        </tbody>
                    </table>
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

        $(document).on("click","#description",function(){
            let roomId = $(this).data("id");
            let formData = new FormData();
            formData.append("roomId",roomId);
            $.ajax({
                url:"./backend/readRoom.php",
                type:"POST",
                data:formData,
                dataType:"text",
                contentType:false,
                processData:false,
                success:function(res){
                    Swal.fire({
                        html:res,
                        showConfirmButton:false,
                        showCloseButton:true
                    })
                }
            })
        })

    </script>

</body>