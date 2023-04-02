<?php
    include 'connect.php';
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:signin.php');
    }
    $id = $_SESSION['Emp_id'];
    $sql = "Select * from `employee` where Emp_id = '$id'";
    $result = mysqli_query($con, $sql);
    $row=mysqli_fetch_assoc($result);
    if($result){
      $fname = $row['Fname'];
      $lname = $row['Lname'];
      $role = $row['role'];
      $username = $row['username'];
      $semp_id = $row['Semp_id'];
    }
    $sql1 = "Select * from `employee` where Emp_id = '$semp_id'";
    $result1 = mysqli_query($con, $sql1);
    if($result1){
        $SFname = $row['Fname'];
        $SLname = $row['Lname'];
    }
    if($role == "Supervisor"){
        $x = "super-home.php";
        $s = $role;
    }
    else if ($role == "Front"){
        $x = "front-home.php";
        $s = $role . " Employee";
        $i = "Supervisor: " . $SFname . " " . $SLname;
    }
    else{
        $x = "back-home.php";
        $s = $role . " Employee";
        $i = "Supervisor: " . $SFname . " " . $SLname;
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  </head>
  <body>
    <div class="d-flex justify-content-between">
        <a href="<?php echo $x;?>" class="btn btn-primary m-2">Home</a>
        <a href="logout.php" class="btn btn-primary m-2">Logout</a>
    </div>
    <h1 class="text-center mt-5">Profile</h1>
    <div class="container mt-5 d-flex flex-column justify-content-start w-25">
        <p><?php echo "Username: " . $username;?></p>
        <p><?php echo "First name: ". $fname?></p>
        <p><?php echo "Last name: " .$lname;?></p>
        <p><?php echo "Role: " . $s;?></p>
        <p><?php echo $i;?></p>
        <div class="d-flex justify-content-center">
            <a class="btn btn-primary w-50" href="change-password.php" role="button">Change Password</a>
        </div>
    </div>
  </body>
</html>