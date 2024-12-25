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
$sqlUSer = "SELECT * FROM users WHERE role = '1'";
$qUser = $db->query($sqlUSer);
$sqlRooms= "SELECT * FROM orders WHERE date >= CURRENT_DATE";
$qRoom = $db->query($sqlRooms);
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

                <a href="./admin.php" class="py-2 menu" style="background-color:rgb(146, 141, 125); color:#fff;">
                    หน้าหลัก
                </a>
                <a href="./recserveRoom.php" class="py-2 menu">
                    การจองห้อง
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
                    <a href="./admin.php" class="mt-auto"><?php echo $_SESSION['auth']->firstName ?></a>
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
                    <hr class="my-3" />
                </div>

            </div>
        </div>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>