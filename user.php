<?php
session_start();
if (isset($_SESSION['auth']) && isset($_SESSION['auth']->role)) {
    if ($_SESSION['auth']->role != '0') {
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}

include("./include/connect.php");
$sqlUSer = "SELECT * FROM users ORDER BY role ASC";
$qUser = $db->query($sqlUSer);
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

                <a href="./admin.php" class="py-2 menu" >
                    หน้าหลัก
                </a>
                <a href="./history.php" class="py-2 menu">
                    ประวัติการจองห้อง
                </a>
                <a href="./room.php" class="py-2 menu">
                    รายการห้อง
                </a>
                <a href="./user.php" class="py-2 menu" style="background-color:rgb(146, 141, 125); color:#fff;">
                    ผู้ใช้งาน
                </a>
            </div>
        </div>
        <div class="col-10">
            <div class="content mx-3 my-3">
                <div class="d-flex justify-content-between px-3 py-3 " style="background-color:rgb(220, 220, 218);">
                    <a href="./admin.php" class="mt-auto"><?php echo $_SESSION['auth']->firstName ?></a>
                    <a href="./backend/logout.php" class="mt-auto">ออกจากระบบ</a>
                </div>
                <div class="row px-3 py-2">
                   <button class="btn btn-primary form-control" id="insert">เพิ่มผู้ใช้งาน</button>
                   <hr>
                   <table id="myTable ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ชื่อจริง</th>
                                <th>นามสกุล</th>
                                <th>อีเมล</th>
                                <th>สถานะ</th>
                                <th>รหัสผ่าน</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                            $i = 1;
                                while($item = $qUser->fetch_object()){
                            ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $item->firstName ?></td>
                                <td><?php echo $item->lastName ?></td>
                                <td><?php echo $item->email ?></td>
                                <td><?php echo ($item->role == 0) ? 'admin' : 'user'; ?></td>
                                <td><button class="btn btn-warning" id="editPassword" data-id="<?php echo $item->id ?>">แก้ไขรหัสผ่าน</button></td>
                                <td><button class="btn btn-primary" id="editProfile" data-id="<?php echo $item->id ?>">แก้ไขข้อมูลส่วนตัว</button></td>
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
        
        $(document).on("click","#insert",function(){
            $.ajax({
                url:"./components/insertProfile.php",
                type:"POST",
                dataType:"html",
                contentType:false,
                processData:false,
                success:function(res){
                    Swal.fire({
                        html:res,
                        showConfirmButton:false
                    })
                }
            })
        })

        $(document).on("click","#submitInsert",function(){
            let firstName = $('#firstName').val()
            let lastName = $('#lastName').val()
            let email = $('#email').val()
            let password = $('#password').val()
            let role = $('#role').val()
            let formData = new FormData();
            formData.append("firstName",firstName);
            formData.append("lastName",lastName)
            formData.append("email",email)
            formData.append("password",password)
            formData.append("role",role)

            $.ajax({
                url:"./backend/insertUser.php",
                type:"POST",
                data:formData,
                dataType:"json",
                contentType:false,
                processData:false,
                success:function(res){
                    if(res.status == 200){
                        Swal.fire({
                            title:"เพิ่มเสร็จสิ้น",
                            icon:"success",
                            timer:1000,
                            showConfirmButton:false
                        }).then(() => {
                            window.location.reload()
                        })
                    }else{
                        Swal.fire({
                            title:"เกิดข้อผิดพลาด",
                            icon:"error",
                            timer:1000,
                            showConfirmButton:false
                        }).then(() => {
                            console.log(res.message)
                            window.location.reload()
                        })
                    }
                }
            })
        })

        $(document).on("click","#editPassword",function(){
            let userId = $(this).data("id")
            let formData = new FormData()
            formData.append("userId",userId);

            $.ajax({
                url:"./components/editPassword.php",
                type:"POST",
                data:formData,
                dataType:"html",
                contentType:false,
                processData:false,
                success:function(res){
                    Swal.fire({
                        html:res,
                        showConfirmButton:false
                    })
                }
            })
        })
        $(document).on("click","#editProfile",function(){
            let userId = $(this).data("id")
            let formData = new FormData()
            formData.append("userId",userId);

            $.ajax({
                url:"./components/editProfile.php",
                type:"POST",
                data:formData,
                dataType:"html",
                contentType:false,
                processData:false,
                success:function(res){
                    Swal.fire({
                        html:res,
                        showConfirmButton:false
                    })
                }
            })
        })

        $(document).on("click","#submitProfile",function(){
            let userId = $(this).data("id")
            let firstName = $('#firstName').val()
            let lastName = $('#lastName').val()
            let email = $('#email').val()
            let role = $('#role').val()
            let formData = new FormData();
            formData.append("firstName",firstName);
            formData.append("lastName",lastName)
            formData.append("email",email)
            formData.append("role",role)
            formData.append("userId",userId)

            $.ajax({
                url:"./backend/editProfile.php",
                type:"POST",
                data:formData,
                dataType:"json",
                contentType:false,
                processData:false,
                success:function(res){
                    console.log(res)
                    if(res.status == 200){
                        Swal.fire({
                            title:"เพิ่มเสร็จสิ้น",
                            icon:"success",
                            timer:1000,
                            showConfirmButton:false
                        }).then(() => {
                            window.location.reload()
                        })
                    }else{
                        Swal.fire({
                            title:"เกิดข้อผิดพลาด",
                            icon:"error",
                            timer:1000,
                            showConfirmButton:false
                        }).then(() => {
                            console.log(res.message)
                            window.location.reload()
                        })
                    }
                }
            })
        })

        $(document).on("click","#submitPassword",function(){
            let userId = $(this).data("id");
            let password = $('#password').val();
            let formData = new FormData();
            formData.append("userId",userId)
            formData.append("password",password)

            $.ajax({
                url:"./backend/editPassword.php",
                type:"POST",
                data:formData,
                dataType:"json",
                contentType:false,
                processData:false,
                success:function(res){
                    if(res.status == 200){
                        Swal.fire({
                            title:"แก้ไขเสร็จสิ้น",
                            icon:"success",
                            timer:1000,
                            showConfirmButton:false
                        }).then(() => {
                            window.location.reload()
                        })
                    }else{
                        Swal.fire({
                            title:"เกิดข้อผิดพลาด",
                            icon:"error",
                            timer:1000,
                            showConfirmButton:false
                        }).then(() => {
                            console.log(res.message)
                            window.location.reload()
                        })
                    }
                }
            })
        })

    </script>

</body>

</html>