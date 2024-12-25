<?php
session_start();
if (isset($_SESSION['auth'])) {
    $dataUser = $_SESSION['auth'];
} else {
    // header("location:login.php");
}

include("./include/connect.php");
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
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                <div class="container my-3">
                                    <h2 class="text-center">แก้ไขข้อมูล</h2>
                                    <hr />
                                    <label for="">ชื่อจริง</label>
                                    <input type="text" class="form-control" value="<?php echo $dataUser->firstName ?>" id="firstName">
                                    <label for="">นามสกุล</label>
                                    <input type="text" class="form-control" value="<?php echo $dataUser->lastName ?>" id="lastName">
                                    <label for="">อีเมล</label>
                                    <input type="email" class="form-control" value="<?php echo $dataUser->email ?>" id="email">

                                    <button class="btn btn-success form-control my-2" id="btnSubmit" data-id="<?php echo $dataUser->id ?>">ยืนยัน</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="fixed-bottom">
            <button class="btn btn-warning" id="back">ย้อนกลับ</button>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
         $(document).on("click", "#back", function() {
            window.history.back();
        })

        
        $(document).on("click","#btnSubmit",function(){
            let firstName = $('#firstName').val()
            let lastName = $('#lastName').val()
            let email = $('#email').val()
            let userId = $(this).data("id")
            let formData = new FormData()
            formData.append("firstName",firstName)
            formData.append("lastName",lastName)
            formData.append("email",email)
            formData.append("userId",userId)

            $.ajax({
                url:"./backend/editUser.php",
                type:"POST",
                data:formData,
                dataType:"json",
                contentType:false,
                processData:false,
                success:function(res){
                    console.log(res)
                    if(res.status == 200){
                        Swal.fire({
                            title:"แก้ไขข้อมูลเสร็จสิ้น",
                            showConfirmButton:false,
                            timer:1000,
                            icon:"success"
                        }).then(() => {
                            window.location.reload()
                        })
                    }else{
                        Swal.fire({
                            title:"เกิดข้อผิดพลาด",
                            showConfirmButton:false,
                            timer:1000,
                            icon:"error"
                        }).then(() => {
                            // window.location.reload()
                        })
                    }
                }
            })
        })

       

    </script>

</body>