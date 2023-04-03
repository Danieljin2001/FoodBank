<?php
    include 'connect.php';
    session_start();
    if(!isset($_SESSION['username']) || $_SESSION['role'] == "Back"){
        header('location:signin.php');
    }
?>


<?php
    include 'connect.php';
    $name = $_GET['name'];
    $add = $_GET['add'];
    $type = $_GET['type'];
    if($add){
        $sql ="insert into `ordertemp` (`name`, `qty`)
        values ('$name', '1')";
        $result =mysqli_query($con, $sql); //insert into ordertemp
        if($result){
            header("location:list-food.php?type=$type");
        } else {
            die(mysqli_error($con));
        }
    } else { //delete
        $sql="delete from `ordertemp` where name='$name'";
          $result = mysqli_query($con, $sql);
          if($result){
            header("location:list-food.php?type=$type");
          } else {
            die(mysqli_error($con));
          }

    }
    

?>