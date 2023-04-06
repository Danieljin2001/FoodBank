<?php
    include 'connect.php';

    if(isset($_GET['ordNo']) && isset($_GET['empId'] )){
        $ordNo = $_GET['ordNo']; //get the id of the employee to edit
        $user = $_GET['empId'];
        echo ".$ordNo.";
        echo ".$user.";
        $sql1 = "update `order` set Bemp_id=$user where Order_no = $ordNo";
        $result1=mysqli_query($con, $sql1);
        if($result1){
            header('location:unassigned-orders.php');
        } else{
            die(mysqli_error($con));
        }
    } else {
        die(mysqli_error($con));
    }
?>
