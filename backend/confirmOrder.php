<?php


try {
    include("../include/connect.php");
    session_start();
    $orderId = $_POST['orderId'];
    $sqlConfirm = "UPDATE orders SET status = '1' WHERE id = '$orderId'";
    $qConfirm = $db->query($sqlConfirm);

    if ($qConfirm) {
        echo json_encode(['status' => '200', 'message' => 'Update Status Success']);
    } else {
        echo json_encode(['status' => '400', 'message' => 'cannot update database']);
    }
} catch (\Throwable $th) {
    echo json_encode(['status' => '500', 'message' => "$th"]);
}
