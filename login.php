<!doctype html>
<html lang="en">

<head>
    <title>Login</title>
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
        <link rel="stylesheet" href="./css/login.css">
        <link rel="icon" type="image/gif" href="./images/Logo.gif">
        <style>
            label{
                font-weight: 400;
            }
            .card{
                background-color: #444444;
                color: #fff;
            }
            .btnn{
                background-color :rgb(254, 201, 95);
                border-radius: 10px;
                transition: ease-in-out 0.2s all;
            }
            .btnn:hover{
                background-color :rgb(123, 84, 8);
                color: #fff;
            }
            .signUp{
                color: #fff;
            }
        </style>
</head>

<body style="height:100vh; background: linear-gradient(135deg, #3498db 50%, #e74c3c 50%); margin: 0;">
    <div class="d-flex justify-content-center" style="align-items: center; height:100%">
        <div class="card " style="width: 40%;">
            <div class="card-body">
                <h2 class="text-center">ระบบจองห้อง</h2>
                <hr />
                <label  for="">Email</label>
                <input type="email" class="form-control" id="email" placeholder="example@gmail.com">
                <label for="">Password</label>
                <input type="password" class="form-control" id="password" placeholder="password">

                <button class="form-control btnn  my-3" id="login">เข้าสู่ระบบ</button>
                <a href="./register.php" class="signUp">สมัครสมาชิก</a>
            </div>
        </div>
   </div>


    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        $(document).on("click","#login",function(){
            let email = $('#email').val();
            let password = $('#password').val();
            let formData = new FormData();
            formData.append("email",email);
            formData.append("password",password);

            $.ajax({
                url:"./backend/checkLogin.php",
                type:"POST",
                data:formData,
                dataType:"text",
                contentType:false,
                processData:false,
                success:function(res){
                    if(res == "200"){
                        Swal.fire({
                            title:"เข้าสู่ระบบสำเร็จ",
                            icon:"success",
                            timer:1000,
                            showConfirmButton:false
                        }).then(() => {
                            window.location.href = "index.php";
                        })
                    }else if(res == "201"){
                        Swal.fire({
                            title:"เข้าสู่ระบบสำเร็จ",
                            icon:"success",
                            timer:1000,
                            showConfirmButton:false
                        }).then(() => {
                            window.location.href = "admin.php";
                        })
                    }else{
                        Swal.fire({
                            title:"Email หรือ Password ไม่ถูกต้อง",
                            icon:"error",
                            timer:1000,
                            showConfirmButton:false,
                            position:"top-end"
                        })
                    }
                }
            })
        })
    </script>
</body>

</html>