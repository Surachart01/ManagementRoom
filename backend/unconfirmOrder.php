<?php
try {
    include("../include/connect.php");
    session_start();
    $orderId = $_POST['orderId'];
    $sqlunConfirm = "DELETE FROM orders WHERE id = '$orderId'";
    $qunConfirm = $db->query($sqlunConfirm);

    if ($qunConfirm) {
        echo json_encode(['status' => '200', 'message' => 'Delete order Success']);
    } else {
        echo json_encode(['status' => '400', 'message' => 'Cannot delete database']);
    }
} catch (\Throwable $th) {
    echo json_encode(['status' => '500', 'message' => "$th"]);
}
