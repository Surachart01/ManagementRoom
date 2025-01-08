<?php
session_start();
if (isset($_SESSION['auth'])) {
    $dataUser = $_SESSION['auth'];
} else {
    // header("location:login.php");
}
if (isset($_GET['roomCode'])) {
    $roomCode = $_GET['roomCode'];
} else {
    header("Location:index.php");
}
?>

</html>
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
    <link rel="icon" type="image/gif" href="./images/Logo.gif">
</head>

<body style="min-height:100vh;">
    <input type="hidden" value="<?php echo $roomCode ?>" id="roomCode">
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
            <div class="d-flex justify-content-center">
                <div id="calendar" style="margin-top: 20px; width: 40%;"></div>
            </div>
        </div>
        <div class="fixed-bottom">
            <button class="btn btn-warning" id="back">ย้อนกลับ</button>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            createCalendar();
        });

        $(document).on("click", "#back", function() {
            window.history.back();
        })

        function addOrderRoom(info) {
            const clickedDate = info.dateStr; // วันที่ที่กดในปฏิทิน
            
            if (new Date(clickedDate).toISOString().split('T')[0] < new Date().toISOString().split('T')[0]) {
                // เงื่อนไขถ้าวันที่อยู่ในอดีต
                console.log("This is a past date.");
                // ทำสิ่งที่ต้องการเมื่อวันที่อยู่ในอดีต
            } else {
                Swal.fire({
                    title: "ต้องการจองวันที่ " + info.dateStr + " ใช้หรือไม่",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "ยืนยัน"
                }).then((result) => {
                    if (result.isConfirmed) {
                        let formData = new FormData();
                        let roomCode = $('#roomCode').val();
                        formData.append("date", info.dateStr);
                        formData.append("roomCode", roomCode);
                        $.ajax({
                            url: "./backend/addRoom.php",
                            type: "POST",
                            data: formData,
                            dataType: "text",
                            contentType: false,
                            processData: false,
                            success: function(data) {
                                console.log(data)
                                if (data == '400') {
                                    Swal.fire({
                                        title: "วันที่คุณเลือกห้องเต็มแล้ว",
                                        icon: "error",
                                        timer: 3000
                                    }).then(() => {
                                        window.location.reload();
                                    })
                                } else {
                                    Swal.fire({
                                        title: "จองห้องเสร็จสิ้น",
                                        icon: "success",
                                        timer: 3000
                                    }).then(() => {
                                        window.location.reload();
                                    })
                                }
                            }
                        })

                    }
                });
            }


        }

        function createCalendar() {
            const params = new URLSearchParams(window.location.search);
            const codeRoom = params.get('roomCode');
            const formData = new FormData();
            formData.append("codeRoom", codeRoom);
            $.ajax({
                url: "./backend/checkRoom.php",
                type: "POST",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(res) {
                    console.log(res)
                    const calendarEl = document.getElementById('calendar');
                    // กิจกรรมทั้งหมด
                    const allEvents = res;

                    // สร้างปฏิทิน
                    const calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth', // แสดงแบบรายเดือน
                        headerToolbar: {
                            left: 'prev,next', // ปุ่มด้านซ้าย
                            center: 'title', // ชื่อเดือน/ปี
                            right: 'dayGridMonth' // ปุ่มด้านขวา
                        },
                        events: allEvents,
                        dateClick: function(info) {
                            // ตรวจสอบว่ามี event ในวันที่กดหรือไม่
                            const eventsOnDate = calendar.getEvents().filter(event => {
                                const eventDate = FullCalendar.formatDate(event.start, {
                                    year: 'numeric',
                                    month: '2-digit',
                                    day: '2-digit'
                                });
                                const clickedDate = FullCalendar.formatDate(info.date, {
                                    year: 'numeric',
                                    month: '2-digit',
                                    day: '2-digit'
                                });
                                return eventDate === clickedDate;
                            });

                            if (eventsOnDate.length === 0) {

                                addOrderRoom(info);
                            } else {
                                // มี event ในวันที่กด
                                console.log("This date already has events.");
                            }
                        }
                    });

                    calendar.render();
                }
            })

        }
    </script>

</body>

</html>