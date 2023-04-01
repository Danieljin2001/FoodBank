<?php
    include 'connect.php';
    if(isset($_GET['emp'])){
        $id = $_GET['emp']; //get the id of the employee to edit

        $sql="Select *
        from `employee`
        where Emp_id='$id'";
        $result=mysqli_query($con, $sql);
        if($result){
            $row=mysqli_fetch_assoc($result);
            $role=$row['role'];
            if($role == 'Front'){
                $sql1="update `employee` set role='Back' where Emp_id='$id'";
            } else {
                $sql1="update `employee` set role='Front' where Emp_id='$id'";
            }
            $result1=mysqli_query($con, $sql1);
            if($result1){
                header('location:employees.php');
            } else{
                die(mysqli_error($con));
            }
        } else {
            die(mysqli_error($con));
        }
    }
?>