<?php  
    include("../include/connect.php");
    try {
        $month = $_POST['month'];
        $sqlLog = "SELECT * FROM orders INNER JOIN rooms ON orders.roomId = rooms.id INNER JOIN users ON orders.userId = users.id WHERE date LIKE '$month%' AND status = '1'";
        $qLog = $db->query($sqlLog);
    } catch (\Throwable $th) {
        echo $th;
    }
?>

        <?php 
        $i = 1;
            while($item = $qLog->fetch_object()){
        ?>
        <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $item->roomName ?></td>
            <td><?php echo $item->codeRoom ?></td>
            <td><?php echo $item->date ?></td>
            <td><?php echo $item->firstName." ".$item->lastName?></td>
        </tr>
        <?php  
        $i++;
            }
        ?>
   